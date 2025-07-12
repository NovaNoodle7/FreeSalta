<?php
class Mappress_Map extends Mappress_Obj {
	var $alignment,
		$center,
		$editable,
		$embed,
		$filter,
		$geolocate,
		$height,
		$hideEmpty,
		$initialOpenDirections,
		$initialOpenInfo,
		$layers,
		$layout,
		$mapid,
		$mapTypeId,
		$metaKey,
		$minZoom,
		$name,
		$poiList,
		$postid,
		$query,
		$title,
		$width,
		$zoom
		;

	var $pois = array();

	function __sleep() {
		return array('mapid', 'center', 'height', 'mapTypeId', 'metaKey', 'pois', 'title', 'width', 'zoom');
	}

	function __construct($atts=null) {

		// Update with defaults, then any passed atts
		$this->update(Mappress::$options);
		$this->update($atts);

		// Convert POIs from arrays to objects if needed
		foreach((array)$this->pois as $index => $poi) {
			if (is_array($poi))
				$this->pois[$index] = new Mappress_Poi($poi);
		}

		// Set default size if no width/height specified
		if (!$this->width || !$this->height) {
			$i = (int) Mappress::$options->size;
			if (isset(Mappress::$options->sizes[$i])) {
				$size = Mappress::$options->sizes[$i];
				$this->width = ($this->width) ? $this->width : $size['width'];
				$this->height = ($this->height) ? $this->height : $size['height'];
			}
		}
	}

	static function register() {
		global $wpdb;

		// Ajax
		add_action('wp_ajax_mapp_create', array(__CLASS__, 'ajax_create'));
		add_action('wp_ajax_mapp_get', array(__CLASS__, 'ajax_get'));
		add_action('wp_ajax_mapp_save', array(__CLASS__, 'ajax_save'));
		add_action('wp_ajax_mapp_delete', array(__CLASS__, 'ajax_delete'));
		add_action('wp_ajax_mapp_find', array(__CLASS__, 'ajax_find'));

		// Editing meta boxes
		add_action('admin_init', array(__CLASS__, 'add_meta_boxes'));

		// Tables
		$maps_table = $wpdb->prefix . 'mappress_maps';
		$posts_table = $wpdb->prefix . 'mappress_posts';

		$wpdb->show_errors(true);

		$exists = $wpdb->get_var("show tables like '$maps_table'");
		if (!$exists) {
			$result = $wpdb->query ("CREATE TABLE $maps_table (
									mapid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
									obj LONGTEXT)
									CHARACTER SET utf8;");
		}

		$exists = $wpdb->get_var("show tables like '$posts_table'");
		if (!$exists) {
			$result = $wpdb->query ("CREATE TABLE $posts_table (
									postid INT,
									mapid INT,
									PRIMARY KEY (postid, mapid) )
									CHARACTER SET utf8;");
		}

		$wpdb->show_errors(false);
	}

	static function media_button($editor_id) {
		if ($editor_id == 'content') {
			echo '<button type="button" class="button" id="mapp-pick-button">';
			echo '<span class="wp-media-buttons-icon dashicons dashicons-location-alt"></span> ' . __('Insert Map', 'mappress-google-maps-for-wordpress') . '</button>';
		}
	}

	static function add_meta_boxes() {
		// Add editing meta box to standard & custom post types
		foreach(Mappress::$options->postTypes as $post_type)
			add_meta_box('mappress', 'MapPress', array(__CLASS__, 'meta_box'), $post_type, 'normal', 'high');
	}

	static function meta_box($post) {
		Mappress::load('editor');
		$map = new Mappress_Map(array('editable' => true, 'layout' => 'left', 'poiList' => true));
		require(Mappress::$basedir . '/forms/map_media.php');
	}

	static function find($args) {
		global $wpdb;
		$args = (object) wp_parse_args($args, array('type' => 'post', 'page' => 1, 'page_size' => 20, 'postid' => null, 'search' => null));

		$posts_table = $wpdb->prefix . 'mappress_posts';

		$where = ($args->type == 'post') ? $wpdb->prepare("WHERE postid=%d", $args->postid) : $wpdb->prepare("WHERE postid<>%d", $args->postid);

		if ($args->search)
			$where .= $wpdb->prepare(" AND $wpdb->posts.post_title LIKE %s", '%' . $args->search . '%');

		$limit = sprintf(" LIMIT %d, %d", ($args->page - 1) * $args->page_size, $args->page_size);
		$sql = "SELECT SQL_CALC_FOUND_ROWS $wpdb->posts.post_title, $wpdb->posts.ID, $posts_table.mapid FROM $posts_table INNER JOIN $wpdb->posts ON ($wpdb->posts.ID = $posts_table.postid) $where $limit";

		$rows = $wpdb->get_results($sql);
		$found = $wpdb->get_var('SELECT FOUND_ROWS()');

		$results = array();
		foreach($rows as $row) {
			$map = self::get($row->mapid, 'raw');
			$results[] = array(
				'mapid' => $row->mapid,
				'postid' => $row->ID,
				'post_title' => $row->post_title,
				'can_edit' => current_user_can('edit_post', $row->ID),
				'mapdata' => $map
			);
		}

		$pages = (int) ceil($found / $args->page_size);
		$page = (int) min($args->page, $pages);
		return (object) array('items' => $results, 'page' => $page, 'pages' => $pages);
	}

	static function ajax_find() {
		Mappress::ajax_response('OK', self::find($_GET));
	}

	/**
	* Get a map.  Output is 'raw' or 'object'
	*/
	static function get($mapid, $output = 'object') {
		global $wpdb;
		$maps_table = $wpdb->prefix . 'mappress_maps';
		$posts_table = $wpdb->prefix . 'mappress_posts';

		$sql = "SELECT $posts_table.postid, $maps_table.mapid, $maps_table.obj FROM $posts_table INNER JOIN $maps_table ON ($maps_table.mapid = $posts_table.mapid) WHERE $maps_table.mapid = %d";
		$result = $wpdb->get_row($wpdb->prepare($sql, $mapid));

		if (!$result)
			return false;

		// Read the map data and construct a new map from it
		$mapdata = unserialize($result->obj);
		$mapdata->postid = $result->postid;
		$mapdata->mapid = $result->mapid;
		return ($output == 'object') ? new Mappress_Map($mapdata) : $mapdata;
	}

	static function ajax_get() {
		ob_start();
		$mapid = (isset($_GET['mapid'])) ? $_GET['mapid']  : null;
		$map = ($mapid) ? self::get($mapid) : null;
		if (!$map)
			Mappress::ajax_response(__('Map not found', 'mappress-google-maps-for-wordpress'));
		else
			Mappress::ajax_response('OK', array('map' => $map));
	}

	/**
	* Get list of mapids for a post or all maps
	*
	* @return array of mapids | empty array
	*
	*/
	static function get_list($postid = null, $output = 'objects') {
		global $wpdb;
		$posts_table = $wpdb->prefix . 'mappress_posts';

		$where = ($postid) ? $wpdb->prepare("WHERE postid = %d", $postid) : '';

		$mapids = $wpdb->get_col("SELECT mapid FROM $posts_table $where");
		if (!$mapids)
			return array();

		if ($output == 'ids') {
			return $mapids;
		} else {
			$maps = array();
			foreach($mapids as $mapid) {
				$map = Mappress_Map::get($mapid);
				if ($map)
					$maps[] = $map;
			}
			return $maps;
		}
	}

	function save($postid) {
		global $wpdb;
		$maps_table = $wpdb->prefix . 'mappress_maps';
		$posts_table = $wpdb->prefix . 'mappress_posts';

		// Apply wpautop to POI bodies
		foreach($this->pois as &$poi)
			$poi->body = wpautop($poi->body);


		$map = serialize($this);

		// Update map
		if (!$this->mapid) {
			// If no ID then autonumber
			$result = $wpdb->query($wpdb->prepare("INSERT INTO $maps_table (obj) VALUES(%s)", $map));
			$this->mapid = (int)$wpdb->get_var("SELECT LAST_INSERT_ID()");
		} else {
			// Id provided, so insert or update
			$result = $wpdb->query($wpdb->prepare("INSERT INTO $maps_table (mapid, obj) VALUES(%d, '%s') ON DUPLICATE KEY UPDATE obj = %s", $this->mapid, $map, $map));
		}

		if ($result === false || !$this->mapid)
			return false;

		// Update posts
		$result = $wpdb->query($wpdb->prepare("INSERT INTO $posts_table (postid, mapid) VALUES(%d, %d) ON DUPLICATE KEY UPDATE postid = %d, mapid = %d", $postid, $this->mapid,
			$postid, $this->mapid));

		if ($result === false)
			return false;

		$wpdb->query("COMMIT");
		return $this->mapid;
	}

	static function ajax_save() {
		ob_start();

		$mapdata = (isset($_POST['map'])) ? json_decode(stripslashes($_POST['map']), true) : null;
		$postid = (isset($_POST['postid'])) ? $_POST['postid'] : null;

		if (!$mapdata)
			Mappress::ajax_response('Internal error, your data has not been saved!');

		$map = new Mappress_Map($mapdata);
		$mapid = $map->save($postid);

		if ($mapid === false)
			Mappress::ajax_response('Internal error, your data has not been saved!');

		do_action('mappress_map_save', $mapid); 	// Use for your own developments
		Mappress::ajax_response('OK', array('mapid' => $mapid, 'list' => self::get_map_list($postid)) );
	}

	/**
	* Delete a map and all of its post assignments
	*
	* @param mixed $mapid
	*/
	static function delete($mapid) {
		global $wpdb;
		$maps_table = $wpdb->prefix . 'mappress_maps';
		$posts_table = $wpdb->prefix . 'mappress_posts';

		// Delete from posts table
		$result = $wpdb->query($wpdb->prepare("DELETE FROM $posts_table WHERE mapid = %d", $mapid));
		if ($result === false)
			return false;

		$result = $wpdb->query($wpdb->prepare("DELETE FROM $maps_table WHERE mapid = %d", $mapid));
		if ($result === false)
			return false;

		$wpdb->query("COMMIT");
		return true;
	}

	static function ajax_delete() {
		ob_start();

		$mapid = (isset($_POST['mapid'])) ? $_POST['mapid'] : null;
		$result = Mappress_Map::delete($mapid);

		if (!$result)
			Mappress::ajax_response("Internal error when deleting map ID '$mapid'!");

		do_action('mappress_map_delete', $mapid); 	// Use for your own developments
		Mappress::ajax_response('OK', array('mapid' => $mapid));
	}

	/**
	* Delete a map assignment(s) for a post
	* If $mapid is null, then ALL maps will be removed from the post
	*
	* @param int $mapid Map to remove
	* @param int $postid Post to remove from
	* @return TRUE if map has been removed, FALSE if map wasn't assigned to the post
	*/
	static function delete_post_map($postid, $mapid=null) {
		global $wpdb;
		$posts_table = $wpdb->prefix . 'mappress_posts';

		if (!$postid)
			return true;

		if ($mapid)
			$results = $wpdb->query($wpdb->prepare("DELETE FROM $posts_table WHERE postid = %d AND mapid = %d", $postid, $mapid));
		else
			$results = $wpdb->query($wpdb->prepare("DELETE FROM $posts_table WHERE postid = %d", $postid));

		$wpdb->query("COMMIT");

		if ($results === false)
			return false;

		return true;
	}

	/**
	* Display a map
	*
	* @param mixed $atts - override attributes.  Attributes applied from options -> map -> $atts
	*/
	function display($atts = null) {
		static $div = 0;

		$this->update($atts);

		// Assign a map name, if none was provided.  Uniqid is used for for ajax to prevent repeating ids
		if (empty($this->name)) {
			$this->name = (defined('DOING_AJAX') && DOING_AJAX) ? "mapp" . uniqid() : "mapp$div";
			$div++;
		}

		// Output scripts
		Mappress::load();

		// For static maps: prepare the pois
		if (empty($this->query))
			$this->prepare();

		$html = Mappress::get_template('map', array('map' => $this));
		$script = "mapp.data.push( " . json_encode($this) . " ); \r\nif (typeof mapp.load != 'undefined') { mapp.load(); };";

		// WP 4.5: queue maps for XHTML compatibility
		if (function_exists('wp_add_inline_script') && Mappress::footer() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
			wp_add_inline_script('mappress', "//<![CDATA[\r\n" . $script . "\r\n//]]>");
		} else {
			$html .= Mappress::script($script);
		}

		return $html;
	}

	function width() {
		return ( stripos($this->width, 'px') || strpos($this->width, '%')) ? $this->width : $this->width. 'px';
	}

	function height() {
		if (stristr($this->height, ':')) {
			$parts = explode(':', $this->height);
			if (count($parts) == 2 && $parts[0] > 0)
				return round((100 * $parts[1] / $parts[0]), 2) . '%';
		}
		return ( stripos($this->height, 'px') || strpos($this->height, '%')) ? $this->height : $this->height. 'px';
	}

	function check($part) {
		switch ($part) {
			case 'directions' :
				return !$this->editable && Mappress::$options->directions == 'inline';

			case 'filters' :
			case 'filters-toggle' :
				return !$this->editable && $this->query && $this->filter;

			case 'header' :
				return $this->query && ($this->check('filters') || $this->check('search'));

			case 'list-inline' :
				return $this->poiList && $this->layout != 'left';

			case 'list-left' :
				return $this->poiList && $this->layout == 'left';

			case 'search' :
				return $this->editable;

			case 'show' :
				return $this->hidden;
		}
		return true;
	}

	function part($part) {

		if (!$this->check($part))
			return;

		switch ($part) {
			case 'controls' :
			case 'directions' :
			case 'filters' :
			case 'header' :
			case 'search' :
				$html = Mappress::get_template("map-$part", array('map' => $this));
				break;

			case 'filters-toggle' :
				$html = "<div class='mapp-caret mapp-button mapp-filters-toggle' data-mapp-action='filters-toggle'>" . __('Filter', 'mappress-google-maps-for-wordpress') . "</div>";
				break;

			case 'layout-class' :
				$class = 'mapp-layout';
				$class .= ($this->layout == 'left') ? ' mapp-left' : ' mapp-inline';
				$class .= (wp_is_mobile()) ? ' mobile' : '';
				if (!$this->editable)
					$class .= ($this->alignment) ? " mapp-align-{$this->alignment}" : '';
				$html = $class;
				break;

			case 'layout-style' :
				$w = $this->width();
				$html = "width: $w;";

				if ($this->embed) {
					$h = $this->height();
					$html .= " height: $h;";
				}
				break;

			case 'list-inline' :
			case 'list-left' :
				$html = Mappress::get_template('map-list', array('map' => $this));
				break;

			case 'show' :
				// Should be onclick...
				$html = sprintf("<a href='#' data-mapp-action='show'>%s</a>", __('Show map', 'mappress-google-maps-for-wordpress'));
				break;

			case 'wrapper-style' :
				if ($this->embed)
					$html = '';
				else {
				$h = $this->height();
					$html = (stristr($h, '%')) ? "padding-bottom: $h;" : "height: $h";
				}
				break;
		}

		return (isset($html)) ? $html : "<!-- unknown part $part -->";
	}

	/**
	* Prepare map for output
	*
	*/
	function prepare() {

		// Assign pois to map for template functions
		foreach($this->pois as $poi)
			$poi->map($this);

		// Prepare the pois
		foreach($this->pois as $poi)
			$poi->prepare();

		// Sort the pois
		if (Mappress::$options->sort && !isset($this->query['orderby']))
			$this->sort_pois();

		// Set the HTML for each POI (comes *after* sort because links embed POI list position)
		foreach($this->pois as $poi)
			$poi->set_html();

		// Autoicons
		$this->autoicons();

		// Last chance to alter map before display
		do_action('mappress_map_display', $this);
	}

	/**
	* Autoicons
	*/
	function autoicons() {
		global $post;

		// Only 1 rule allowed
		$rule = (object) wp_parse_args(Mappress::$options->autoicons, array('key' => null, 'values' => array()));

		foreach($rule->values as $value => $iconid) {
			// Get all post IDs that match the current key & value
			if ($rule->key == 'post_type') {
				$wpq = new WP_Query(array('post_type' => $value, 'fields' => 'ids', 'posts_per_page' => -1));
				$postids = $wpq->posts;
			} else {
				$term = get_term_by('slug', $value, $rule->key);
				if (!is_object($term))
					continue;

				$objects = get_objects_in_term($term->term_id, $rule->key);
				if (!is_array($objects))
					continue;

				$postids = array_keys(array_flip($objects));
			}

			// Check each post ID to see if it's in the map's POIs, if so set iconid
			$current_post = ($post) ? $post->ID : null;
			foreach($this->pois as &$poi) {
				$postid = ($poi->postid) ? $poi->postid : $current_post;
				if (in_array($postid, $postids))
					$poi->iconid = $iconid;
			}
		}

		// Filter
		foreach($this->pois as &$poi)
			$poi->iconid = apply_filters('mappress_poi_iconid', $poi->iconid, $poi);
	}

	/**
	* Default action to sort the map
	*
	* @param mixed $map
	*/
	function sort_pois() {
		usort($this->pois, array(__CLASS__, 'compare_title'));
		do_action('mappress_sort_pois', $this);
	}

	/**
	* Compare two POIs by title
	* HTML tags are stripped - until URL is separated from title this is the only way to
	* sort titles with HTML
	*
	* @param mixed $a
	* @param mixed $b
	* @return mixed
	*/
	static function compare_title($a, $b) {
		return strcasecmp(strip_tags($a->title), strip_tags($b->title));
	}

	/**
	* Get a list of maps attached to the post
	*
	* @param int $postid Post for which to get the list
	* @return an array of all maps for the post or FALSE if no maps
	*/
	static function get_post_map_list($postid) {
		global $wpdb;
		$posts_table = $wpdb->prefix . 'mappress_posts';

		$results = $wpdb->get_results($wpdb->prepare("SELECT postid, mapid FROM $posts_table WHERE postid = %d", $postid));

		if ($results === false)
			return false;

		// Get all of the maps
		$maps = array();
		foreach($results as $key => $result) {
			$map = Mappress_Map::get($result->mapid);
			if ($map)
				$maps[] = $map;
		}
		return $maps;
	}

	/**
	* Get a list of maps for editing
	*
	* @param mixed $postid
	*/
	static function get_map_list($postid = null) {
		global $post;

		$postid = ($postid) ? $postid : $post->ID;
		$maps = self::get_post_map_list($postid);

		$actions = "<div class='mapp-m-actions'>"
			. "<a href='#' class='mapp-maplist-edit'>" . __('Edit', 'mappress-google-maps-for-wordpress') . "</a> | "
			. "<a href='#' class='mapp-maplist-insert'>" . __('Insert into post', 'mappress-google-maps-for-wordpress') . "</a> | "
			. "<a href='#' class='mapp-maplist-delete'>" . __('Delete', 'mappress-google-maps-for-wordpress') . "</a>"
			. "</div>";

		$html = "<table class='mapp-m-map-list'>";
		foreach($maps as $map) {
			$title = ($map->title) ? $map->title : __('Untitled', 'mappress-google-maps-for-wordpress');
			$html .= "<tr data-mapid='$map->mapid'><td><b><a href='#' class='mapp-maplist-title mapp-maplist-edit'>[$map->mapid] " . esc_html($title) . "</a></b>$actions</td></tr>";
		}

		$html .= "</table>";
		return $html;
	}

	static function ajax_create() {
		ob_start();
		$map = new Mappress_Map();
		Mappress::ajax_response('OK', array('map' => $map));
	}
}
?>