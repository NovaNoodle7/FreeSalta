<?php
/*
Plugin Name: MapPress Easy Google Maps
Plugin URI: http://www.wphostreviews.com/mappress
Author URI: http://www.wphostreviews.com/mappress
Description: MapPress makes it easy to insert Google Maps in WordPress posts and pages.
Version: 2.47
Author: Chris Richardson
Text Domain: mappress-google-maps-for-wordpress
Thanks to all the translators and to Matthias Stasiak for his wonderful icons (http://code.google.com/p/google-maps-icons/)
*/

/*
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the license.txt file for details.
*/

require_once dirname( __FILE__ ) . '/mappress_obj.php';
require_once dirname( __FILE__ ) . '/mappress_controls.php';
require_once dirname( __FILE__ ) . '/mappress_poi.php';
require_once dirname( __FILE__ ) . '/mappress_map.php';
require_once dirname( __FILE__ ) . '/mappress_settings.php';

if (is_dir(dirname( __FILE__ ) . '/pro')) {
	include_once dirname( __FILE__ ) . '/pro/mappress_filter.php';
	include_once dirname( __FILE__ ) . '/pro/mappress_geocoder.php';
	include_once dirname( __FILE__ ) . '/pro/mappress_icons.php';
	include_once dirname( __FILE__ ) . '/pro/mappress_meta.php';
	include_once dirname( __FILE__ ) . '/pro/mappress_pro_settings.php';
	include_once dirname( __FILE__ ) . '/pro/mappress_query.php';
	include_once dirname( __FILE__ ) . '/pro/mappress_updater.php';
	include_once dirname( __FILE__ ) . '/pro/mappress_widget.php';
}

class Mappress {
	const VERSION = '2.47';

	static
		$baseurl,
		$basename,
		$basedir,
		$debug,
		$options,
		$pages,
		$pro,
		$updater
		;

	function __construct()  {
		self::$basedir = dirname(__FILE__);
		self::$basename = plugin_basename(__FILE__);
		self::$baseurl = plugins_url('', __FILE__);
		self::$options = Mappress_Options::get();
		self::$pro = is_dir(dirname( __FILE__ ) . '/pro');
		self::debugging();

		// Pro updater
		if (self::$pro)
			self::$updater = new Mappress_Updater(self::$basename, 'mappress', self::VERSION, self::$options->license, self::$options->betas, self::$options->autoupdate, Mappress_Pro_Settings::get_usage());

		add_action('admin_menu', array(__CLASS__, 'admin_menu'));
		add_action('init', array(__CLASS__, 'init'));
		add_action('plugins_loaded', array(__CLASS__, 'plugins_loaded'));

		add_shortcode('mappress', array(__CLASS__, 'shortcode_map'));
		add_action('admin_notices', array(__CLASS__, 'admin_notices'));

		// Post hooks
		add_action('deleted_post', array(__CLASS__, 'deleted_post'));

		// Filter to automatically add maps to post/page content
		add_filter('the_content', array(__CLASS__, 'the_content'), 2);

		// Namespace
		add_action('wp_head', array(__CLASS__, 'wp_head'), 0);
		add_action('admin_head', array(__CLASS__, 'wp_head'), 0);

		// Scripts and stylesheets
		add_action('wp_enqueue_scripts', array(__CLASS__, 'wp_enqueue_scripts'));
		add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_scripts'));

		// Plugin action links
		add_filter("plugin_action_links_" . self::$basename, array(__CLASS__, 'plugin_action_links'), 10, 2);

		if (self::$pro) {
			add_shortcode('mashup', array(__CLASS__, 'shortcode_mashup'));
			add_action('widgets_init', create_function('', 'return register_widget("Mappress_Widget");'));
		}

		// Slow heartbeat
		if (self::$debug)
			add_filter( 'heartbeat_settings', array(__CLASS__, 'heartbeat_settings'));
	}

	static function heartbeat_settings( $settings ) {
		$settings['minimalInterval'] = 600;
		return $settings;
	}

	static function debugging() {
		global $wpdb;

		if (isset($_GET['mp_info'])) {
			echo "<b>Plugin version</b> " . self::get_version_string();
			$posts_table = $wpdb->prefix . 'mappress_posts';
			$results = $wpdb->get_results("SELECT postid, mapid FROM $posts_table");
			echo "<br/>postid => mapid";
			foreach($results as $result)
				echo "<br/>$result->postid => $result->mapid";
			die();
		}

		if (isset($_REQUEST['mp_debug']))
			self::$debug = max(1, (int) $_REQUEST['mp_debug']);
		else if (defined('MAPPRESS_DEBUG'))
			self::$debug = MAPPRESS_DEBUG;

		if (self::$debug) {
			error_reporting(E_ALL);
			ini_set('error_reporting', E_ALL);
			ini_set('display_errors','On');
			$wpdb->show_errors();
		}
	}

	static function plugin_action_links($links, $file) {
		$settings_link = "<a href='" . admin_url("admin.php?page=mappress") . "'>" . __('Settings', 'mappress-google-maps-for-wordpress') . "</a>";
		array_unshift( $links, $settings_link );
		return $links;
	}

	static function get_version_string() {
		$version = __('Version', 'mappress-google-maps-for-wordpress') . ":" . self::VERSION;
		if (self::$pro)
			$version .= " PRO";
		return $version;
	}

	static function get_support_links($title = 'MapPress') {
		$html = "<div class='mapp-support'>" . self::get_version_string();
		$html .= " | <a target='_blank' href='http://wphostreviews.com/mappress/mappress-documentation'>" . __('Documentation', 'mappress-google-maps-for-wordpress') . "</a>";
		$html .= " | <a target='_blank' href='http://wphostreviews.com/chris-contact'>" . __('Support', 'mappress-google-maps-for-wordpress') . "</a>";
		if (!self::$pro)
			$html .= "<a class='button button-primary' href='http://wphostreviews.com/mappress' target='_blank'>" . __('Upgrade to MapPress Pro', 'mappress-google-maps-for-wordpress') . "</a>";
		$html .= "</div>";
		echo $html;
	}

	static function ajax_response($status, $data=null) {
		$output = trim(ob_get_clean());		// Ignore whitespace, any other output is an error
		header( "Content-Type: application/json" );
		$response = json_encode(array('status' => $status, 'output' => $output, 'data' => $data));
		die ($response);
	}

	/**
	* When a post is deleted, delete its map assignments
	*
	*/
	static function deleted_post($postid) {
		Mappress_Map::delete_post_map($postid);
	}

	static function admin_menu() {
		// Settings
		$settings = (self::$pro) ? new Mappress_Pro_Settings() : new Mappress_Settings();
		self::$pages[] = add_menu_page('MapPress', 'MapPress', 'manage_options', 'mappress', array(&$settings, 'options_page'), 'dashicons-location');
	}

/**
	* Automatic map display.
	* If set, the [mappress] shortcode will be prepended/appended to the post body, once for each map
	* The shortcode is used so it can be filtered - for example WordPress will remove it in excerpts by default.
	*
	* @param mixed $content
	*/
	static function the_content($content="",$mostrar_map=0) {
		global $post;
		global $wp_current_filter;
		
		$autodisplay = self::$options->autodisplay;
		
		// No auto display
		if (!$autodisplay || $autodisplay == 'none')
			return $content;

		// Check if in the loop, to prevent conflicts with JetPack - see http://wordpress.org/support/topic/easy-adsense-lite-and-jetpack
		if (!in_the_loop())
			return $content;

		// Don't add the shortcode for feeds or admin screens
		if (is_feed() || self::is_admin())
			return $content;

		// No shortcode if post is password protected
		if (post_password_required())
			return $content;

		// If this is an excerpt don't attempt to add the map to it
		if (in_array('get_the_excerpt', $wp_current_filter))
			return $content;

		// Don't auto display if the post already contains a MapPress shortcode
		//cristian comento para no mostrar mapa en descripcion
		if (stristr($content, '[mappress') !== false || stristr($content, '[mashup') !== false)
			return $content;

		// Get maps associated with post
		$mapids = Mappress_Map::get_list($post->ID, 'ids');
		if (empty($mapids))
			return $content;
		var_export($mostrar_map);
		// Add the shortcode once for each map
		$shortcodes = "";
		foreach($mapids as $mapid)
			$shortcodes .= '<p>[mappress mapid="' . $mapid . '"]</p>';
		return $shortcodes;
		/*if ($mostrar_solo_mapa == 1)
			return $shortcodes;
		else
			if ($autodisplay == 'top')
				return $shortcodes . $content;
			else
				return $content . $shortcodes;*/
	}

	/**
	* Automatic map display.
	* If set, the [mappress] shortcode will be prepended/appended to the post body, once for each map
	* The shortcode is used so it can be filtered - for example WordPress will remove it in excerpts by default.
	*
	* @param mixed $content
	*/
	static function the_content_map() {
		global $post;
		global $wp_current_filter;

		/*$autodisplay = self::$options->autodisplay;

		// No auto display
		if (!$autodisplay || $autodisplay == 'none')
			return $content;*/

		// Check if in the loop, to prevent conflicts with JetPack - see http://wordpress.org/support/topic/easy-adsense-lite-and-jetpack
		/*if (!in_the_loop())
			return $content;

		// Don't add the shortcode for feeds or admin screens
		if (is_feed() || self::is_admin())
			return $content;

		// No shortcode if post is password protected
		if (post_password_required())
			return $content;

		// If this is an excerpt don't attempt to add the map to it
		if (in_array('get_the_excerpt', $wp_current_filter))
			return $content;*/

		// Get maps associated with post
		$mapids = Mappress_Map::get_list($post->ID, 'ids');
		if (empty($mapids))
			return $content;

		// Add the shortcode once for each map
		$shortcodes = "";
		foreach($mapids as $mapid)
			$shortcodes .= '<p>[mappress mapid="' . $mapid . '"]</p>';

		
		return $shortcodes;
	}

	/**
	* Map a shortcode in a post.
	*
	* @param mixed $atts - shortcode attributes
	*/
	static function shortcode_map($atts='') {
		global $post;

		// No feeds
		if (is_feed())
			return;

		// Try to protect against calls to do_shortcode() in the post editor...
		if (self::is_admin())
			return;

		$atts = self::scrub_atts($atts);

		// Determine what to show
		$mapid = (isset($atts['mapid'])) ? $atts['mapid'] : null;

		if ($mapid) {
			// Show map by mapid
			$map = Mappress_Map::get($mapid);
		} else {
			// Get the first map attached to the post
			$maps = Mappress_Map::get_list($post->ID);
			$map = (isset ($maps[0]) ? $maps[0] : false);
		}

		if (!$map)
			return;

		return $map->display($atts);
	}

	/**
	* Process the mashup shortcode
	*
	*/
	static function shortcode_mashup($atts='') {
		// No feeds
		if (is_feed())
			return;

		// Prevent do_shortcode() in the post editor, but allow for AJAX calls from other plugins (which run as admin)
		if (self::is_admin())
			return;

		$atts = self::scrub_atts($atts);
		return self::get_mashup($atts);
	}

	/**
	* Get a mashup - used by shortcode and widget
	*
	* @param mixed $atts
	*/
	static function get_mashup($atts) {
		global $wp_query;

		$mashup = new Mappress_Map($atts);
		$mashup->query = Mappress_Query::parse_query($atts);

		// If parameter test="true", output the query result without using a map
		if (isset($_GET['mp_test']) || (isset($atts['test']) && $atts['test'])) {
			$wpq = new WP_Query($mashup->query);
			return "<pre>" . print_r($wpq, true) . "</pre>";
		}

		// If using query 'current' then create a static map for current posts
		if (empty($mashup->query))
			$mashup->pois = Mappress_Query::get_pois($wp_query->posts);

		// If 'hideEmpty' is set, try to suppress the map if there are no POIs
		if ($mashup->hideEmpty) {
			// 'current' query - check found pois
			if (empty($mashup->query) && empty($mashup->pois))
				return "";

			// Other queries - check for at least 1 result
			if (Mappress_Query::is_empty($mashup->query))
				return "";
		}
		return $mashup->display();
	}

	static function wp_head() {
		echo "\r\n<!-- MapPress Easy Google Maps " . self::get_version_string() . " (http://www.wphostreviews.com/mappress) -->\r\n";
		echo "<script type='text/javascript'>mapp = window.mapp || {}; mapp.data = [];</script>\r\n";
	}

	/**
	* Scripts & styles for frontend
	* CSS is loaded from: child theme, theme, or plugin directory
	*/
	static function wp_enqueue_scripts() {
		// Load the default CSS from the plugin directory
		wp_enqueue_style('mappress', self::$baseurl . '/css/mappress.css', null, self::VERSION);

		// If a 'mappress.css' exists in the theme directory, load that afterwards
		if ( @file_exists( get_stylesheet_directory() . '/mappress.css' ) )
			$file = get_stylesheet_directory_uri() . '/mappress.css';
		elseif ( @file_exists( get_template_directory() . '/mappress.css' ) )
			$file = get_template_directory_uri() . '/mappress.css';

		if (isset($file))
			wp_enqueue_style('mappress-custom', $file, array('mappress'), self::VERSION);

		// Load scripts in header
		if (!self::footer())
			self::load();
	}

	// Scripts & styles for admin
	// CSS is always loaded from the plugin directory
	static function admin_enqueue_scripts($hook) {
		// Some plugins call this without setting $hook
		if (empty($hook))
			return;

		// Network admin has no pages
		if (empty(self::$pages))
			return;

		$editing = in_array($hook, array('edit.php', 'post.php', 'post-new.php'));

		// Settings scripts
		if ($hook == self::$pages[0])
			self::load('settings');

		// CSS
		if (in_array($hook, self::$pages) || $editing) {
			wp_enqueue_style('mappress', self::$baseurl . '/css/mappress.css', null, self::VERSION);
			wp_enqueue_style('mappress-admin', self::$baseurl . '/css/mappress_admin.css', null, self::VERSION);
		}
	}

	static function plugins_loaded() {
		load_plugin_textdomain('mappress-google-maps-for-wordpress', false, dirname(self::$basename) . '/languages');
	}


	/**
	* There are several WP bugs that prevent correct activation in multisitie:
	*   http://core.trac.wordpress.org/ticket/14170
	*   http://core.trac.wordpress.org/ticket/14718)
	*
	*/
	static function init() {
		// Register hooks and create database tables
		Mappress_Map::register();

		// Register static classes
		if (self::$pro) {
			Mappress_Icons::register();
			Mappress_Meta::register();
			Mappress_Pro_Settings::register();
			Mappress_Query::register();
		}

		// Check if upgrade is needed
		$current_version = get_option('mappress_version');

		// Convert meta key settings
		if ($current_version < '2.45') {
			$old = (object) get_option('mappress_options');
			foreach(array('address1', 'address2', 'address3', 'address4', 'address5', 'address6', 'lat', 'lng', 'iconid', 'title', 'body', 'zoom') as $i => $key) {
				if ($i < 6) {
					$value = (isset($old->metaKeyAddress[$i])) ? $old->metaKeyAddress[$i] : null;
				} else {
					$old_key = 'metaKey' . ucfirst($key);
					$value = (isset($old->$old_key)) ? $old->$old_key : null;
				}
				if ($value)
					Mappress::$options->metaKeys[$key] = $value;
			}
			Mappress::$options->save();
		}

		update_option('mappress_version', self::VERSION);
	}

	// Sanity checks via notices
	static function admin_notices() {
		global $wpdb;
		$error =  "<div id='error' class='error'><p>%s</p></div>";

		$map_table = $wpdb->prefix . "mappress_maps";
		$exists = $wpdb->get_var("show tables like '$map_table'");

		if (!$exists) {
			echo sprintf($error, __("MapPress database tables are missing.  Please deactivate the plugin and activate it again to fix this.", 'mappress-google-maps-for-wordpress'));
			return;
		}

		if (get_bloginfo('version') < "3.2") {
			echo sprintf($error, __("WARNING: MapPress now requires WordPress 3.2 or higher.  Please upgrade before using MapPress.", 'mappress-google-maps-for-wordpress'));
			return;
		}

		if (class_exists('WPGeo')) {
			echo sprintf($error, __("WARNING: MapPress is not compfatible with the WP-Geo plugin.  Please deactivate or uninstall WP-Geo before using MapPress.", 'mappress-google-maps-for-wordpress'));
			return;
		}

		// Dismissible notices
		$notices = array();
		if (!self::get_api_keys()->browser)
			$notices['apikey'] = sprintf("%s. %s <a href='%s'>%s</a>.", __("A Google Maps API key is required", 'mappress-google-maps-for-wordpress'), __("Please update your", 'mappress-google-maps-for-wordpress'), admin_url('admin.php?page=mappress'), __('MapPress Settings', 'mappress-google-maps-for-wordpress'));

		foreach($notices as $notice => $msg)
			echo "<div class='notice error is-dismissible'><p>$msg</p></div>";
	}

	static function dismiss($notice) {
		$dismissed = get_option('mappress-dismissed');
		$dismissed = (is_array($dismissed)) ? $dismissed : array();
		$dismissed[$key] = true;
	}

	/**
	* Scrub attributes
	* The WordPress shortcode API passes shortcode attributes in lowercase and with boolean values as strings (e.g. "true")
	* Converts atts to lowercase, replaces boolean strings with booleans, and creates arrays from comma-separated attributes
	*
	* Returns empty array if $atts is empty or not an array
	*/
	static function scrub_atts($atts=null) {
		if (!$atts || !is_array($atts))
			return array();

		$atts = self::string_to_boolean($atts);

		// Shortcode attributes are lowercase so convert everything to lowercase
		$atts = array_change_key_case($atts);

		// Center
		if (isset($atts['center'])) {
			$latlng = explode(',', $atts['center']);
			if (count($latlng) == 2)
				$atts['center'] = array('lat' => $latlng[0], 'lng' => $latlng[1]);
			else
				unset($atts['center']);
		}

		// Explode layers
		if (isset($atts['layers'])) {
			$atts['layers'] = explode(',', $atts['layers']);
			foreach($atts['layers'] as &$layer)
				$layer = trim($layer);
		}

		// Search = 'post', replace with post's location
		if (isset($atts['search']) && $atts['search'] == 'post') {
			global $post;
			$maps = Mappress_Map::get_list($post->ID, 'ids');
			$map = ($maps) ? Mappress_Map::get($maps[0]) : null;
			$atts['search'] = ($map && $map->pois) ? $map->pois[0]->point : null;
		}

		return $atts;
	}

	static function string_to_boolean($data) {
		if ($data === 'false')
			return false;

		if ($data === 'true')
			return true;

		if (is_array($data)) {
			foreach($data as &$datum)
				$datum = self::string_to_boolean($datum);
		}

		return $data;
	}

	static function load($type = null) {
		static $loaded;

		if ($loaded)
			return;
		$loaded = true;

		$dev = self::dev();
		$version = self::VERSION;
		$footer = self::footer();

		$apiversion = ($dev) ? 'v=3.exp' : 'v=3';
		$apikey = "&key=" . self::get_api_keys()->browser;
		$libstring = ($type == 'editor') ? '&libraries=places,drawing' : '&libraries=places';

		// Directories
		$min = ($dev) ? "" : ".min";
		$js = ($dev) ? "http://localhost/$dev/wp-content/plugins/mappress-google-maps-for-wordpress/src" : self::$baseurl . '/js';

		// Get language for WPML or qTranslate, or use options setting
		$language = self::get_language();
		$language = ($language) ? "&language=$language" : '';

		wp_enqueue_script("mappress-gmaps", "https://maps.googleapis.com/maps/api/js?{$apiversion}{$language}{$libstring}{$apikey}", null, null, $footer);

		if ($type == 'editor')
			wp_enqueue_script('mappress_editor', $js . "/mappress_editor$min.js", array('jquery', 'jquery-ui-position', 'jquery-ui-sortable'), $version, $footer);

		if ($type == 'settings')
			wp_enqueue_script('mappress_settings', $js . "/mappress_settings$min.js", array('postbox', 'jquery', 'jquery-ui-position', 'jquery-ui-sortable'), $version, $footer);

		// mappress.js includes loader, so must come after editor
		wp_enqueue_script('mappress', $js . "/mappress$min.js", array('jquery', 'underscore'), $version, $footer);

		if (!$min) {
			foreach(array('directions', 'geocoding', 'icons', 'infobox', 'lib', 'places', 'poi', 'widgets', 'loader') as $script)
				wp_enqueue_script($script, $js . "/mappress_{$script}.js", null, $version, $footer);
		}

		wp_localize_script('mappress', 'mappl10n', self::l10n());
	}

	static function footer() {
		return (is_admin() || self::$options->footer && !get_option('infinite_scroll'));
	}

	static function dev() {
		if (defined('MAPPRESS_DEV') && MAPPRESS_DEV)
			return MAPPRESS_DEV;
		else if (isset($_REQUEST['mp_dev']))
			return ($_REQUEST['mp_dev']) ? $_REQUEST['mp_dev'] : 'dev';
		else
			return false;
	}

	static function l10n() {
		global $post;

		$l10n = array(
			'dir_error' => __('Google cannot return directions between those addresses.  There is no route between them or the routing information is not available.', 'mappress-google-maps-for-wordpress'),
			'kml_error' => __('Error reading KML file', 'mappress-google-maps-for-wordpress'),
			'no_address' => __('No matching address', 'mappress-google-maps-for-wordpress'),
			'no_geolocate' => __('Unable to get your location', 'mappress-google-maps-for-wordpress'),
			'delete_prompt' => __('Delete this POI?', 'mappress-google-maps-for-wordpress'),
			'delete_map_prompt' => __('Delete this map?', 'mappress-google-maps-for-wordpress'),
			'shape' => __('Shape', 'mappress-google-maps-for-wordpress')
		);

		// Globals
		$l10n['options'] = array(
			'admin' => current_user_can('administrator'),
			'ajaxurl' => admin_url('admin-ajax.php'),
			'apiKey' => self::get_api_keys()->browser,
			'debug' => Mappress::$debug,
			'iconsUrl' => (self::$pro) ? Mappress_Icons::$icons_url : null,
			'postid' => ($post) ? $post->ID : null,
			'pro' => self::$pro,
			'siteUrl' => site_url(),
			'standardIconsUrl' => (self::$pro) ? Mappress_Icons::$standard_icons_url : null
		);

		// Global settings
		$options = array('country', 'defaultIcon', 'directions', 'directionsServer', 'iconScale', 'iwType', 'mashupBody', 'mashupClick', 'mashupTitle', 'poiZoom', 'radius', 'size', 'sizes', 'style', 'styles');
		foreach($options as $option)
			$l10n['options'][$option] = self::$options->$option;

		// Styles
		foreach(self::$options->styles as $id => &$style)
			$l10n['options']['styles'][$id] = json_decode($style);

		return $l10n;
	}

	/**
	* Get language using settings/WPML/qTrans
	*
	*/
	static function get_language() {
		// WPML
		if (defined('ICL_LANGUAGE_CODE'))
			return ICL_LANGUAGE_CODE;

		// qTranslate
		if (function_exists('qtrans_getLanguage'))
			return qtrans_getLanguage();

		return self::$options->language;
	}

	/**
	* Switch WPML language during AJAX calls
	*/
	static function set_language() {
		global $sitepress;
		if ($sitepress && method_exists($sitepress, 'switch_lang')) {
			$language = self::get_language();
			$sitepress->switch_lang($language);
		}
	}

	/**
	* Get template.
	*/
	static function get_template($template_name, $args = array()) {
		ob_start();
		$map = (isset($args['map'])) ? $args['map'] : null;
		$poi = (isset($args['poi'])) ? $args['poi'] : null;

		$template_name .= ".php";
		$template_file = locate_template($template_name, false);
		if (!self::$pro || is_admin() || empty($template_file))
			$template_file = Mappress::$basedir . "/templates/$template_name";

		if (file_exists($template_file))
			require($template_file);
		else
			echo "Invalid template: $template_name";

		$html = ob_get_clean();
		$html = str_replace(array("\r\n", "\t"), array(), $html);  // Strip chars that won't display in html anyway
		return $html;
	}

	static function get_api_keys() {
		$results = (object) array('browser' => self::$options->apiKey, 'server' => self::$options->apiKeyServer);
		if (empty($results->browser) && defined('MAPPRESS_APIKEY'))
			$results->browser = MAPPRESS_APIKEY;
		if (empty($results->server) && defined('MAPPRESS_APIKEY_SERVER'))
			$results->server = MAPPRESS_APIKEY_SERVER;
		return $results;
	}

	static function script($script, $ready = false) {
		$html = "\r\n<script type='text/javascript'>\r\n";
		$html .= ($ready) ? "jQuery(document).ready(function() { $script });" : $script;
		$html .= "\r\n</script>";
		return $html;
	}

	static function script_template($template, $id = null) {
		$id = ($id) ? "id='mapp-tmpl-{$id}'" : '';
		$html = "\r\n<script type='text/template' $id>\r\n{$template}\r\n</script>\r\n";
		return $html;
	}

	static function ssl() {
		return (is_ssl() || !filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE));
	}

	static function is_localhost() {
		return !filter_var($_SERVER['SERVER_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
	}

	// WP returns is_admin() = true during AJAX calls, this one returns false in that case
	static function is_admin() {
		$ajax = defined('DOING_AJAX') && DOING_AJAX;
		return is_admin() && !$ajax;
	}
}  // End Mappress class

$mappress = new Mappress();
?>