<?php
/**
* Options
*/
class Mappress_Options extends Mappress_Obj {
	var $alignment,
		$autoicons,
		$autoupdate,
		$apiKey,
		$apiKeyServer,
		$autodisplay = 'top',
		$betas,
		$country,
		$css = true,
		$defaultIcon,
		$directions = 'google',
		$directionsServer = 'https://maps.google.com',
		$filter,
		$footer = true,
		$geolocate,
		$iconScale,
		$initialOpenInfo,
		$iwType = 'iw',
		$language,
		$license,
		$mashupTitle = 'poi',
		$mashupBody = 'poi',
		$mashupClick = 'poi',
		$metaKeys = array(),
		$metaSyncSave = true,
		$poiList = false,
		$poiZoom = 15,
		$postTypes = array('post', 'page'),
		$radius = 15,
		$search,
		$size = 1,
		$sizes = array(array('width' => 300, 'height' => 300), array('width' => 425, 'height' => 350), array('width' => 640, 'height' => 480)),
		$sort,
		$style,
		$styles = array(),
		$thumbs = true,
		$thumbSize,
		$thumbWidth = 64,
		$thumbHeight = 64
		;

	function __construct($options = '') {
		$this->update($options);
	}

	// Options are saved as array because WP settings API is fussy about objects
	static function get() {
		$options = get_option('mappress_options');
		return new Mappress_Options($options);
	}

	function save() {
		return update_option('mappress_options', get_object_vars($this));
	}
}      // End class Mappress_Options


/**
* Options menu display
*/
class Mappress_Settings {
	static $basename = 'mappress_options';
	var $options;

	function __construct() {
		$this->options = Mappress_Options::get();
		add_action('admin_init', array($this, 'admin_init'));
	}

	function admin_init() {
		register_setting('mappress', self::$basename, array($this, 'validate'));

		// License: single blogs, or main blog on multisite
		if (Mappress::$pro && $this->options->autoupdate && (!is_multisite() || (is_super_admin() && is_main_site())) )
			$this->add_section('license', __('License', 'mappress-google-maps-for-wordpress'));

		$this->add_section('basic', __('Basic Settings', 'mappress-google-maps-for-wordpress'));
		$this->add_field('apiKey', __('Google API key', 'mappress-google-maps-for-wordpress'), 'basic');
		$this->add_field('postTypes', __('Post types', 'mappress-google-maps-for-wordpress'), 'basic');
		$this->add_field('autodisplay', __('Automatic display', 'mappress-google-maps-for-wordpress'), 'basic');

		$this->add_section('maps', __('Map Settings', 'mappress-google-maps-for-wordpress'));
		$this->add_field('alignment', __('Map alignment', 'mappress-google-maps-for-wordpress'), 'maps');
		$this->add_field('directions', __('Directions', 'mappress-google-maps-for-wordpress'), 'maps');

		$this->add_section('pois', __('POI Settings', 'mappress-google-maps-for-wordpress'));
		$this->add_field('poiZoom', __('Default zoom', 'mappress-google-maps-for-wordpress'), 'pois');
		$this->add_field('initialOpenInfo', __('Open first POI', 'mappress-google-maps-for-wordpress'), 'pois');

		if (Mappress::$pro) {
			$this->add_section('mashups', __('Mashups', 'mappress-google-maps-for-wordpress'));
			$this->add_section('icons', __('Icons', 'mappress-google-maps-for-wordpress'));
			$this->add_section('styles', __('Styled Maps', 'mappress-google-maps-for-wordpress'));
			$this->add_section('geocoding', __('Geocoding', 'mappress-google-maps-for-wordpress'));
			$this->add_field('apiKeyServer', __('Google Server API key', 'mappress-google-maps-for-wordpress'), 'geocoding');
		}

		$this->add_section('l10n', __('Localization', 'mappress-google-maps-for-wordpress'));
		$this->add_field('language', __('Language', 'mappress-google-maps-for-wordpress'), 'l10n');
		$this->add_field('country', __('Country', 'mappress-google-maps-for-wordpress'), 'l10n');
		$this->add_field('directionsServer', __('Directions server', 'mappress-google-maps-for-wordpress'), 'l10n');

		$this->add_section('misc', __('Miscellaneous', 'mappress-google-maps-for-wordpress'));
		$this->add_field('sizes', __('Map sizes', 'mappress-google-maps-for-wordpress'), 'misc');
		$this->add_field('footer', __('Scripts', 'mappress-google-maps-for-wordpress'), 'misc');
	}

	function add_section($section, $title) {
		add_settings_section($section, $title, null, 'mappress');
	}

	function add_field($field, $label, $section) {
		$callback = 'set_' . strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $field));
		add_settings_field($field, $label, array($this, $callback), 'mappress', $section, self::$basename . "[$field]");
	}

	function validate($input) {
		// If reset defaults was clicked
		if (isset($_POST['reset_defaults'])) {
			$options = new Mappress_Options();
			return get_object_vars($this);
		}

		// Trim the api keys
		$input['apiKey'] = (isset($input['apiKey'])) ? trim($input['apiKey']) : '';
		$input['apiKeyServer'] = (isset($input['apiKeyServer'])) ? trim($input['apiKeyServer']) : '';

		// Sizes
		foreach( $input['sizes'] as &$size ) {
			// Strip 'px' from value but allow '%'.  also, % min/max = 5%/100%, px min/max = 200/2048
			if (strpos($size['width'], '%'))
				$size['width'] = max(5, min(100, (int) $size['width'])) . '%';
			else
				$size['width'] = max(200, min(2048, (int) $size['width']));

			if (strpos($size['height'], '%'))
				$size['height'] = max(5, min(100, (int) $size['height'])) . '%';
			else
				$size['height'] = max(200, min(2048, (int) $size['height']));
		}

		// If NO post types selected, set value to empty array
		if (!isset($input['postTypes']))
			$input['postTypes'] = array();

		// Force checkboxes to boolean
		foreach($input as &$item)
			$item = Mappress::string_to_boolean($item);

		// For arrays passed as checkboxes set empty array for no selection
		$input['postTypes'] = (isset($input['postTypes'])) ? $input['postTypes'] : array();

		foreach(array('apiKey', 'apiKeyServer') as $key)
			$input[$key] = trim($input[$key]);
		return $input;
	}

	function set_alignment($name) {
		$alignments = array(
			'' => __('Default', 'mappress-google-maps-for-wordpress'),
			'center' => __('Center', 'mappress-google-maps-for-wordpress'),
			'left' => __('Left', 'mappress-google-maps-for-wordpress'),
			'right' => __('Right', 'mappress-google-maps-for-wordpress')
		);
		echo Mappress_Controls::radios($name, $alignments, $this->options->alignment);
		return;
	}

	function set_api_key($name) {
		echo Mappress_Controls::input($name, $this->options->apiKey, array('size' => '50'));
		$helpurl = "<a href='http://wphostreviews.com/mappress-faq' target='_blank'>" . __('more info', 'mappress-google-maps-for-wordpress') . "</a>";
		printf("<br/><i>%s %s</i>", __("Required to display maps", 'mappress-google-maps-for-wordpress'), $helpurl);
	}

	function set_autodisplay($name) {
		$autos = array(
			'top' => __('Top of post', 'mappress-google-maps-for-wordpress'),
			'bottom' => __('Bottom of post', 'mappress-google-maps-for-wordpress'),
			'none' => __('None', 'mappress-google-maps-for-wordpress')
		);
		echo Mappress_Controls::radios($name, $autos, $this->options->autodisplay);
	}

	function set_country($name) {
		$country = $this->options->country;
		$cctld_link = '<a style="vertical-align:text-bottom" target="_blank" href="http://en.wikipedia.org/wiki/CcTLD#List_of_ccTLDs">' . __("Country code", 'mappress-google-maps-for-wordpress') . '</a>';
		echo Mappress_Controls::input($name, $this->options->country, array('size' => 2));
		echo ' ' . sprintf(__('%s for searching', 'mappress-google-maps-for-wordpress'), $cctld_link);
	}

	function set_directions($name) {
		$directions_types = array(
			'google' => __('Google', 'mappress-google-maps-for-wordpress'),
			'inline' => __('Inline', 'mappress-google-maps-for-wordpress'),
			'none' => __('None', 'mappress-google-maps-for-wordpress')
		);
		echo Mappress_Controls::radios($name, $directions_types, $this->options->directions);
	}

	function set_directions_server($name) {
		echo Mappress_Controls::input($name, $this->options->directionsServer, array('size' => 25));
	}

	function set_footer($name) {
		// Disable if jetpack infinite scroll is used
		if (get_option('infinite_scroll')) {
			echo Mappress_Controls::checkmark($name, false, __('Output scripts in footer', 'mappress-google-maps-for-wordpress'), array('disabled' => true));
			printf("<br/><i>%s</i>", __('Disabled because Jetpack Infinite Scroll is active', 'mappress-google-maps-for-wordpress'));
		} else {
			echo Mappress_Controls::checkmark($name, $this->options->footer, __('Output scripts in footer', 'mappress-google-maps-for-wordpress'));
			printf("<br/><i>(%s)</i>", __('disable if maps are output using AJAX', 'mappress-google-maps-for-wordpress'));
		}
	}

	function set_initial_open_info($name) {
		echo Mappress_Controls::checkmark($name, $this->options->initialOpenInfo, __('Open first POI', 'mappress-google-maps-for-wordpress'));
	}

	function set_language($name) {
		$lang_link = '<a style="vertical-align:text-bottom" target="_blank" href="http://code.google.com/apis/maps/faq.html#languagesupport">' . __("Language", 'mappress-google-maps-for-wordpress') . '</a>';
		echo Mappress_Controls::input($name, $this->options->language, array('size' => 2));
		echo ' ' . sprintf(__('%s for map controls', 'mappress-google-maps-for-wordpress'), $lang_link);
	}

	function set_poi_zoom($name) {
		$zooms = array_combine(range(1, 17), range(1,17));
		echo Mappress_Controls::select($name, $zooms, (int) $this->options->poiZoom);
		echo __("Default zoom for POIs entered by lat/lng", 'mappress-google-maps-for-wordpress');
	}

	function set_post_types($name) {
		$post_types = Mappress_Controls::get_post_types();
		echo Mappress_Controls::checkboxes($name, $post_types, $this->options->postTypes);
		return;
	}

	function set_sizes($name) {
		$headers = array(__('Width (px or %)', 'mappress-google-maps-for-wordpress'), __('Height (px)', 'mappress-google-maps-for-wordpress'), __('Default size', 'mappress-google-maps-for-wordpress'));
		$rows = array();

		foreach($this->options->sizes as $i => $size) {
			$checked = ($i == $this->options->size) ? "checked='checked'" : "";
			$rows[] = array(
				Mappress_Controls::input("{$name}[$i][width]", $size['width'], array('size' => 4)),
				Mappress_Controls::input("{$name}[$i][height]", $size['height'], array('size' => 4)),
				Mappress_Controls::input(self::$basename . "[size]", $i, array('type' => 'radio', 'checked' => $checked)),
			);
		}
		echo Mappress_Controls::table($headers, $rows);
	}

	function metabox_settings($object, $metabox) {
		global $wp_settings_fields;

		$page = $metabox['args']['page'];
		$section = $metabox['args']['section'];

		//call_user_func($section['callback'], $section);
		if ( !isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section['id']]) )
			return;

		echo '<table class="form-table">';
		do_settings_fields($page, $section['id']);
		echo '</table>';
	}

	function metabox_preview($object, $metabox) {
		if (!Mappress::$pro) {
			$link = "<a href='https://wordpress.org/plugins/mappress-google-maps-for-wordpress/'>" . __('rate it 5 Stars', 'mappress-google-maps-for-wordpress') . "</a>";
			echo "<div class='mappress-like' style='float:right; font-size: 14px; width: 45%'><h3>Like this plugin?</h3>";
			echo sprintf(__('Please %s on WordPress.org.', 'mappress-google-maps-for-wordpress'), $link);
			echo "<br/><hr/>" . __('Thanks for your support!', 'mappress-google-maps-for-wordpress');
			echo "</div>";
		}

		$poi = new Mappress_Poi(array(
			'correctedAddress' => 'San Francisco, CA',
			"title" => "MapPress",
			"body" => __("Easy Google Maps", 'mappress-google-maps-for-wordpress'),
			"point" => array('lat' => 37.774095, 'lng' => -122.418731)
		));
		$pois = array($poi);
		$map = new Mappress_Map(array('alignment' => 'default', 'width' => '50%', 'height' => 200, 'pois' => $pois, 'zoom' => 4));
		echo $map->display();
		}

	function options_page() {
		global $wp_settings_sections;
		$hook_suffix = 'mappress';   	// Use global if multiple settings pages

		add_meta_box('metabox_preview', __('Sample Map', 'mappress-google-maps-for-wordpress'), array($this, 'metabox_preview'), $hook_suffix, 'advanced', 'high');
		foreach ($wp_settings_sections['mappress'] as $section )
			add_meta_box('metabox_' . $section['id'], $section['title'], array($this, 'metabox_settings'), $hook_suffix, 'normal', 'high', array('page' => 'mappress', 'section' => $section));
		?>
		<div class="wrap mapp-settings-screen">
			<h1><?php _e('MapPress', 'mappress-google-maps-for-wordpress'); ?></h1>
			<?php echo Mappress::get_support_links(); ?>
			<div id="poststuff">
				<?php // Print demo box early because directions has its own form tag ?>
				<?php do_meta_boxes( $hook_suffix, 'advanced', null ); ?>
				<form action="options.php" method="post">
					<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
					<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
					<?php settings_fields('mappress'); ?>

						<div id="post-body" class="metabox-holder columns-1">
							<div id="postbox-container-1" class="postbox-container">
								<?php do_meta_boxes( $hook_suffix, 'normal', null ); ?>
							</div>
						</div>
						<br class="clear">
					<div class='mapp-settings-toolbar'>
						<input name='submit' type='submit' class='button-primary' value='<?php _e("Save Changes", 'mappress-google-maps-for-wordpress'); ?>' />
						<input name='reset_defaults' type='submit' class='button' value='<?php _e("Reset Defaults", 'mappress-google-maps-for-wordpress'); ?>' />
					</div>
				</form>
			</div>
		</div>
		<?php
		echo Mappress::script("postboxes.add_postbox_toggles('$hook_suffix');", true);
	}
}
?>
