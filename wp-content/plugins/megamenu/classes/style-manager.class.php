<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists( 'Mega_Menu_Style_Manager' ) ) :

/**
 *
 */
final class Mega_Menu_Style_Manager {

    /**
     *
     */
    var $settings = array();


    /**
     * Constructor
     *
     * @since 1.0
     */
    public function __construct() {
        $this->settings = get_option( "megamenu_settings" );
    }


    /**
     * Setup actions
     *
     * @since 1.0
     */
    public function setup_actions() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 999 );
        add_action( 'wp_head', array( $this, 'head_css' ), 9999 );
        add_action( 'megamenu_delete_cache', array( $this, 'delete_cache' ) );
        add_action( 'after_switch_theme', array( $this, 'delete_cache') );

        // PolyLang
        if ( function_exists( 'pll_current_language' ) ) {
            add_filter( 'megamenu_css_transient_key', array( $this, 'polylang_transient_key') );
            add_filter( 'megamenu_css_filename', array( $this, 'polylang_css_filename') );
            add_action( 'megamenu_after_delete_cache', array( $this, 'polylang_delete_cache') );
        } else if ( defined( 'ICL_LANGUAGE_CODE' ) ) { // WPML
            add_filter( 'megamenu_css_transient_key', array( $this, 'wpml_transient_key') );
            add_filter( 'megamenu_css_filename', array( $this, 'wpml_css_filename') );
            add_action( 'megamenu_after_delete_cache', array( $this, 'wpml_delete_cache') );
        }
    }


    /**
     * Return the default menu theme
     */
    public function get_default_theme() {
        return apply_filters("megamenu_default_theme", array(
            'title'                                     => __("Default", "megamenu"),
            'container_background_from'                 => '#222',
            'container_background_to'                   => '#222',
            'container_padding_left'                    => '0px',
            'container_padding_right'                   => '0px',
            'container_padding_top'                     => '0px',
            'container_padding_bottom'                  => '0px',
            'container_border_radius_top_left'          => '0px',
            'container_border_radius_top_right'         => '0px',
            'container_border_radius_bottom_left'       => '0px',
            'container_border_radius_bottom_right'      => '0px',
            'arrow_up'                                  => 'dash-f142',
            'arrow_down'                                => 'dash-f140',
            'arrow_left'                                => 'dash-f141',
            'arrow_right'                               => 'dash-f139',
            'font_size'                                 => '14px', // deprecated
            'font_color'                                => '#666', // deprecated
            'font_family'                               => 'inherit', // deprecated
            'menu_item_align'                           => 'left',
            'menu_item_background_from'                 => 'rgba(0,0,0,0)',
            'menu_item_background_to'                   => 'rgba(0,0,0,0)',
            'menu_item_background_hover_from'           => '#333',
            'menu_item_background_hover_to'             => '#333',
            'menu_item_spacing'                         => '0px',
            'menu_item_link_font'                       => 'inherit',
            'menu_item_link_font_size'                  => '14px',
            'menu_item_link_height'                     => '40px',
            'menu_item_link_color'                      => '#ffffff',
            'menu_item_link_weight'                     => 'normal',
            'menu_item_link_text_transform'             => 'none',
            'menu_item_link_text_decoration'            => 'none',
            'menu_item_link_text_align'                 => 'left',
            'menu_item_link_color_hover'                => '#ffffff',
            'menu_item_link_weight_hover'               => 'normal',
            'menu_item_link_text_decoration_hover'      => 'none',
            'menu_item_link_padding_left'               => '10px',
            'menu_item_link_padding_right'              => '10px',
            'menu_item_link_padding_top'                => '0px',
            'menu_item_link_padding_bottom'             => '0px',
            'menu_item_link_border_radius_top_left'     => '0px',
            'menu_item_link_border_radius_top_right'    => '0px',
            'menu_item_link_border_radius_bottom_left'  => '0px',
            'menu_item_link_border_radius_bottom_right' => '0px',
            'menu_item_border_color'                    => '#fff',
            'menu_item_border_left'                     => '0px',
            'menu_item_border_right'                    => '0px',
            'menu_item_border_top'                      => '0px',
            'menu_item_border_bottom'                   => '0px',
            'menu_item_border_color_hover'              => '#fff',
            'menu_item_highlight_current'               => 'on',
            'menu_item_divider'                         => 'off',
            'menu_item_divider_color'                   => 'rgba(255, 255, 255, 0.1)',
            'menu_item_divider_glow_opacity'            => '0.1',
            'panel_background_from'                     => '#f1f1f1',
            'panel_background_to'                       => '#f1f1f1',
            'panel_width'                               => '100%',
            'panel_inner_width'                         => '100%',
            'panel_border_color'                        => '#fff',
            'panel_border_left'                         => '0px',
            'panel_border_right'                        => '0px',
            'panel_border_top'                          => '0px',
            'panel_border_bottom'                       => '0px',
            'panel_border_radius_top_left'              => '0px',
            'panel_border_radius_top_right'             => '0px',
            'panel_border_radius_bottom_left'           => '0px',
            'panel_border_radius_bottom_right'          => '0px',
            'panel_header_color'                        => '#555',
            'panel_header_text_transform'               => 'uppercase',
            'panel_header_font'                         => 'inherit',
            'panel_header_font_size'                    => '16px',
            'panel_header_font_weight'                  => 'bold',
            'panel_header_text_decoration'              => 'none',
            'panel_header_padding_top'                  => '0px',
            'panel_header_padding_right'                => '0px',
            'panel_header_padding_bottom'               => '5px',
            'panel_header_padding_left'                 => '0px',
            'panel_header_margin_top'                   => '0px',
            'panel_header_margin_right'                 => '0px',
            'panel_header_margin_bottom'                => '0px',
            'panel_header_margin_left'                  => '0px',
            'panel_header_border_color'                 => 'panel_header_color',
            'panel_header_border_left'                  => '0px',
            'panel_header_border_right'                 => '0px',
            'panel_header_border_top'                   => '0px',
            'panel_header_border_bottom'                => '0px',
            'panel_padding_left'                        => '0px',
            'panel_padding_right'                       => '0px',
            'panel_padding_top'                         => '0px',
            'panel_padding_bottom'                      => '0px',
            'panel_widget_padding_left'                 => '15px',
            'panel_widget_padding_right'                => '15px',
            'panel_widget_padding_top'                  => '15px',
            'panel_widget_padding_bottom'               => '15px',
            'panel_font_size'                           => 'font_size',
            'panel_font_color'                          => 'font_color',
            'panel_font_family'                         => 'font_family',
            'panel_second_level_font_color'             => 'panel_header_color',
            'panel_second_level_font_color_hover'       => 'panel_header_color',
            'panel_second_level_text_transform'         => 'panel_header_text_transform',
            'panel_second_level_font'                   => 'panel_header_font',
            'panel_second_level_font_size'              => 'panel_header_font_size',
            'panel_second_level_font_weight'            => 'panel_header_font_weight',
            'panel_second_level_font_weight_hover'      => 'panel_header_font_weight',
            'panel_second_level_text_decoration'        => 'panel_header_text_decoration',
            'panel_second_level_text_decoration_hover'  => 'panel_header_text_decoration',
            'panel_second_level_background_hover_from'  => 'rgba(0,0,0,0)',
            'panel_second_level_background_hover_to'    => 'rgba(0,0,0,0)',
            'panel_second_level_padding_left'           => '0px',
            'panel_second_level_padding_right'          => '0px',
            'panel_second_level_padding_top'            => '0px',
            'panel_second_level_padding_bottom'         => '0px',
            'panel_second_level_margin_left'            => '0px',
            'panel_second_level_margin_right'           => '0px',
            'panel_second_level_margin_top'             => '0px',
            'panel_second_level_margin_bottom'          => '0px',
            'panel_second_level_border_color'           => 'panel_header_color',
            'panel_second_level_border_left'            => '0px',
            'panel_second_level_border_right'           => '0px',
            'panel_second_level_border_top'             => '0px',
            'panel_second_level_border_bottom'          => '0px',
            'panel_third_level_font_color'              => 'panel_font_color',
            'panel_third_level_font_color_hover'        => 'panel_font_color',
            'panel_third_level_text_transform'          => 'none',
            'panel_third_level_font'                    => 'panel_font_family',
            'panel_third_level_font_size'               => 'panel_font_size',
            'panel_third_level_font_weight'             => 'normal',
            'panel_third_level_font_weight_hover'       => 'normal',
            'panel_third_level_text_decoration'         => 'none',
            'panel_third_level_text_decoration_hover'   => 'none',
            'panel_third_level_background_hover_from'   => 'rgba(0,0,0,0)',
            'panel_third_level_background_hover_to'     => 'rgba(0,0,0,0)',
            'panel_third_level_padding_left'            => '0px',
            'panel_third_level_padding_right'           => '0px',
            'panel_third_level_padding_top'             => '0px',
            'panel_third_level_padding_bottom'          => '0px',
            'flyout_width'                              => '150px',
            'flyout_menu_background_from'               => '#f1f1f1',
            'flyout_menu_background_to'                 => '#f1f1f1',
            'flyout_border_color'                       => '#ffffff',
            'flyout_border_left'                        => '0px',
            'flyout_border_right'                       => '0px',
            'flyout_border_top'                         => '0px',
            'flyout_border_bottom'                      => '0px',
            'flyout_border_radius_top_left'             => '0px',
            'flyout_border_radius_top_right'            => '0px',
            'flyout_border_radius_bottom_left'          => '0px',
            'flyout_border_radius_bottom_right'         => '0px',
            'flyout_menu_item_divider'                  => 'off',
            'flyout_menu_item_divider_color'            => 'rgba(255, 255, 255, 0.1)',
            'flyout_padding_top'                        => '0px',
            'flyout_padding_right'                      => '0px',
            'flyout_padding_bottom'                     => '0px',
            'flyout_padding_left'                       => '0px',
            'flyout_link_padding_left'                  => '10px',
            'flyout_link_padding_right'                 => '10px',
            'flyout_link_padding_top'                   => '0px',
            'flyout_link_padding_bottom'                => '0px',
            'flyout_link_weight'                        => 'normal',
            'flyout_link_weight_hover'                  => 'normal',
            'flyout_link_height'                        => '35px',
            'flyout_link_text_decoration'               => 'none',
            'flyout_link_text_decoration_hover'         => 'none',
            'flyout_background_from'                    => '#f1f1f1',
            'flyout_background_to'                      => '#f1f1f1',
            'flyout_background_hover_from'              => '#dddddd',
            'flyout_background_hover_to'                => '#dddddd',
            'flyout_link_size'                          => 'font_size',
            'flyout_link_color'                         => 'font_color',
            'flyout_link_color_hover'                   => 'font_color',
            'flyout_link_family'                        => 'font_family',
            'flyout_link_text_transform'                => 'none',
            'responsive_breakpoint'                     => '600px',
            'responsive_text'                           => 'MENU', // deprecated
            'line_height'                               => '1.7',
            'z_index'                                   => '999',
            'shadow'                                    => 'off',
            'shadow_horizontal'                         => '0px',
            'shadow_vertical'                           => '0px',
            'shadow_blur'                               => '5px',
            'shadow_spread'                             => '0px',
            'shadow_color'                              => 'rgba(0, 0, 0, 0.1)',
            'transitions'                               => 'off',
            'resets'                                    => 'off',
            'mobile_columns'                            => '2',
            'toggle_background_from'                    => 'container_background_from',
            'toggle_background_to'                      => 'container_background_to',
            'toggle_font_color'                         => 'menu_item_link_color', // deprecated
            'toggle_bar_height'                         => '40px',
            'mobile_menu_item_height'                   => '40px',
            'mobile_background_from'                    => 'container_background_from',
            'mobile_background_to'                      => 'container_background_to',
            'mobile_menu_item_link_font_size'           => 'menu_item_link_font_size',
            'mobile_menu_item_link_color'               => 'menu_item_link_color',
            'mobile_menu_item_link_text_align'          => 'menu_item_link_text_align',
            'disable_mobile_toggle'                     => 'off',
            'custom_css'                                => '/** Push menu onto new line **/ 
#{$wrap} { 
    clear: both; 
}' 
        ) );
    }


    /**
     *
     * @since 1.0
     */
    public function default_themes() {

        $themes['default'] = $this->get_default_theme();

        return apply_filters( "megamenu_themes", $themes );
    }

    /**
     * Merge the saved themes (from options table) into array of complete themes
     *
     * @since 2.1
     */
    private function merge_in_saved_themes( $all_themes ) {

        if ( $saved_themes = max_mega_menu_get_themes() ) {

            foreach ( $saved_themes as $key => $settings ) {

                if ( isset( $all_themes[ $key ] ) ) {
                    // merge modifications to default themes
                    $all_themes[ $key ] = array_merge( $all_themes[ $key ], $saved_themes[ $key ] );
                } else {
                    // add in new themes
                    $all_themes[ $key ] = $settings;
                }

            }
        }

        return $all_themes;

    }


    /**
     * Populate all themes with all keys from the default theme
     *
     * @since 2.1
     */
    private function ensure_all_themes_have_all_default_theme_settings( $all_themes ) {

        $default_theme = $this->get_default_theme();

        $themes = array();

        foreach ( $all_themes as $theme_id => $theme ) {
            $themes[ $theme_id ] = array_merge( $default_theme, $theme );
        }

        return $themes;
    }


    /**
     * For backwards compatibility, copy old settings into new values
     *
     * @since 2.1
     */
    private function process_theme_replacements( $all_themes ) {

        foreach ( $all_themes as $key => $settings ) {

            // process replacements
            foreach ( $settings as $var => $val ) {

                if ( ! is_array( $val ) && isset( $all_themes[$key][$val] ) ) {

                    $all_themes[$key][$var] = $all_themes[$key][$val];

                }

            }

        }

        return $all_themes;
    }


    /**
     * Return a filtered list of themes
     *
     * @since 1.0
     * @return array
     */
    public function get_themes() {

        $default_themes = $this->default_themes();

        $all_themes = $this->merge_in_saved_themes( $default_themes );

        $all_themes = $this->ensure_all_themes_have_all_default_theme_settings( $all_themes );

        $all_themes = $this->process_theme_replacements( $all_themes );

        uasort( $all_themes, array( $this, 'sort_by_title' ) );

        return $all_themes;

    }


    /**
     * Sorts a 2d array by the 'title' key
     *
     * @since 1.0
     * @param array $a
     * @param array $b
     */
    private function sort_by_title( $a, $b ) {

        return strcmp( $a['title'], $b['title'] );

    }


    /**
     *
     *
     * @since 1.3.1
     */
    private function is_debug_mode() {

        return ( defined( 'MEGAMENU_DEBUG' ) && MEGAMENU_DEBUG === true ) || ( current_user_can('edit_theme_options') && isset( $_GET['nocache'] ) );

    }


    /**
     * Return the menu CSS for use in inline CSS block. Use the cache if possible.
     *
     * @since 1.3.1
     */
    public function get_css() {

        if ( ( $css = $this->get_cached_css() ) && ! $this->is_debug_mode() ) {

            return $css;

        } else {

            return $this->generate_css();

        }

    }


    /**
     * Generate and cache the CSS for our menus.
     * The CSS is compiled by scssphp using the file located in /css/megamenu.scss
     *
     * @since 1.0
     * @return string
     * @param boolean $debug_mode (prints error messages to the CSS when enabled)
     */
    public function generate_css() {

        if ( function_exists('wp_raise_memory_limit') ) {
            wp_raise_memory_limit(); // attempt to raise memory limit to 256MB
        }

        // the settings may have changed since the class was instantiated,
        // reset them here
        $this->settings = get_option( "megamenu_settings" );

        if ( ! $this->settings ) {
            return "/** CSS Generation Failed. No menu settings found **/";
        }

        $css = "";

        foreach ( $this->settings as $location => $settings ) {
            if ( isset( $settings['enabled'] ) && has_nav_menu( $location ) ) {
                $theme = $this->get_theme_settings_for_location( $location );
                $menu_id = $this->get_menu_id_for_location( $location );
                $compiled_css = $this->generate_css_for_location( $location, $theme, $menu_id );

                if ( ! is_wp_error( $compiled_css ) ) {
                    $css .= $compiled_css;
                }
            }
        }

        if ( strlen( $css ) ) {
            $scss_location = 'core';

            foreach ( $this->get_possible_scss_file_locations() as $path ) {
                if ( file_exists($path) && $path !== $this->get_default_scss_file_location() ) {
                    $scss_location = 'custom';
                }
            }

            $css = "/** " . date('l jS \of F Y h:i:s A') . " ({$scss_location}) **/\n\n" . $css;

            $css = apply_filters( "megamenu_compiled_css", $css );

            $this->set_cached_css( $css );

            if ( $this->get_css_output_method() == 'fs' ) {
                $this->save_to_filesystem( $css );
            }

        }

        return $css;
    }


    /**
     *
     * @since 1.6.1
     */
    private function save_to_filesystem( $css ) {
        global $wp_filesystem;

        if ( ! $wp_filesystem ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $upload_dir = wp_upload_dir();
        $filename = $this->get_css_filename();
        
        $dir = trailingslashit( $upload_dir['basedir'] ) . 'maxmegamenu/';

        WP_Filesystem( false, $upload_dir['basedir'], true );

        if( ! $wp_filesystem->is_dir( $dir ) ) {
            $wp_filesystem->mkdir( $dir );
        }

        if ( ! $wp_filesystem->put_contents( $dir . $filename, $css ) ) {
            // File write failed.
            // Update CSS output option to 'head' to stop us from attempting to regenerate the CSS on every request.
            $settings = get_option( 'megamenu_settings' );
            $settings['css'] = 'head';
            update_option( 'megamenu_settings', $settings );
            $this->settings = get_option( "megamenu_settings" );

        }

    }


    /**
     * Return an array of all the possible file path locations for the SCSS file
     * @since 2.2.3
     * @return array
     */
    private function get_possible_scss_file_locations() {
        return apply_filters( "megamenu_scss_locations", array(
            trailingslashit( get_stylesheet_directory() ) . trailingslashit("megamenu") . 'megamenu.scss', // child theme
            trailingslashit( get_template_directory() ) . trailingslashit("megamenu") . 'megamenu.scss', // parent theme
            $this->get_default_scss_file_location()
        ));
    }


    /**
     * Return the default SCSS file path
     *
     * @since 2.2.3
     * @return string
     */
    private function get_default_scss_file_location() {
        return MEGAMENU_PATH . trailingslashit('css') . 'megamenu.scss';
    }


    /**
     * Return the path to the megamenu.scss file, look for custom files before
     * loading the core version.
     *
     * @since 1.0
     * @return string
     */
    private function load_scss_file() {

        /**
         *  *** IMPORTANT NOTICE ***
         *
         * Allowing users to create their own versions of megamenu.scss was a poor design decision.
         *
         * The bundled SCSS file and the plugin code work in perfect harmony.
         *
         * When a user (or theme developer) creates their own copy of megamenu.scss it
         * _will_ become outdated as the plugin is updated and the menu HTML changes.
         *
         * Instead of using a custom SCSS file, override only the absolutel minimum CSS in the
         * Menu Theme > Custom Styling section.
         */
        $scss  = file_get_contents( MEGAMENU_PATH . trailingslashit('css') . 'mixin.scss' );
        $scss .= file_get_contents( MEGAMENU_PATH . trailingslashit('css') . 'reset.scss' );

        $locations = $this->get_possible_scss_file_locations();

        foreach ( $locations as $path ) {

            if ( file_exists( $path ) ) {

                $scss .= file_get_contents( $path );
                //break;
                //
                // @todo: add a break here. This is a known bug but some users may be relying on it.
                // Add warning message to plugin to alert users about not using custom megamenu.scss files
                // then fix the bug in a later release.
            }

        }

        return apply_filters( "megamenu_load_scss_file_contents", $scss);

    }

    public function test_theme_compilation($theme) {
        $menu_id = 0;

        $menus = get_registered_nav_menus();

        if ( count( $menus ) ) {
            $locations = get_nav_menu_locations();

            foreach ($menus as $location => $description ) {
                if ( isset( $locations[ $location ] ) ) {
                    $menu_id = $locations[ $location ];
                    continue;
                }
            }
        }

        return $this->generate_css_for_location( 'test', $theme, $menu_id );

    }

    /**
     * Compiles raw SCSS into CSS for a particular menu location.
     *
     * @since 1.3
     * @return mixed
     * @param array $settings
     * @param string $location
     */
    public function generate_css_for_location( $location, $theme, $menu_id ) {

        $scssc = new scssc();
        $scssc->setFormatter( 'scss_formatter' );

        $import_paths = apply_filters('megamenu_scss_import_paths', array(
            trailingslashit( get_stylesheet_directory() ) . trailingslashit("megamenu"),
            trailingslashit( get_stylesheet_directory() ),
            trailingslashit( get_template_directory() ) . trailingslashit("megamenu"),
            trailingslashit( get_template_directory() ),
            trailingslashit( WP_PLUGIN_DIR )
        ));

        foreach ( $import_paths as $path ) {
            $scssc->addImportPath( $path );
        }

        try {
            return $scssc->compile( $this->get_complete_scss_for_location( $location, $theme, $menu_id ) );
        }
        catch ( Exception $e ) {
            $message = __("Warning: CSS compilation failed. Please check your changes or revert the theme.", "megamenu");

            return new WP_Error( 'scss_compile_fail', $message . "<br /><br />" . $e->getMessage() );
        }

    }


    /**
     * Generates a SCSS string which includes the variables for a menu theme,
     * for a particular menu location.
     *
     * @since 1.3
     * @return string
     * @param string $theme
     * @param string $location
     * @param int $menu_id
     */
    private function get_complete_scss_for_location( $location, $theme, $menu_id ) {

        $sanitized_location = str_replace( apply_filters("megamenu_location_replacements", array("-", " ") ), "-", $location );

        $wrap_selector = apply_filters( "megamenu_scss_wrap_selector", "#mega-menu-wrap-{$sanitized_location}", $menu_id, $location );
        $menu_selector = apply_filters( "megamenu_scss_menu_selector", "#mega-menu-{$sanitized_location}", $menu_id, $location );

        $vars['wrap'] = "'$wrap_selector'";
        $vars['menu'] = "'$menu_selector'";
        $vars['location'] = "'$sanitized_location'";
        $vars['menu_id'] = "'$menu_id'";

        $settings = $this->get_menu_settings_for_location( $location );

        if ( isset( $settings['effect_speed'] ) && intval( $settings['effect_speed'] ) > 0 ) {
            $effect_speed = intval( $settings['effect_speed'] ) . 'ms';
        } else {
            $effect_speed = '200ms';
        }

        $vars['effect_speed'] = $effect_speed;

        foreach( $theme as $name => $value ) {


            if ( in_array( $name, array( 'arrow_up', 'arrow_down', 'arrow_left', 'arrow_right' ) ) ) {

                $parts = explode( '-', $value );
                $code = end( $parts );

                $arrow_icon = $code == 'disabled' ? "''" : "'\\" . $code . "'";

                $vars[$name] = $arrow_icon;

                continue;
            }

            if ( in_array( $name, array( 'responsive_text' ) ) ) {

                if ( strlen( $value ) ) {
                    $vars[$name] = "'" . do_shortcode( $value ) . "'";
                } else {
                    $vars[$name] = "''";
                }

                continue;
            }

            if ( in_array( $name, array( 'panel_width', 'panel_inner_width' ) ) ) {

                if ( preg_match('/^\d/', $value) !== 1 ) { // doesn't start with number (jQuery selector)
                    $vars[$name] = '100%';

                    continue;
                }

            }

            if ( $name != 'custom_css' ) {
                $vars[$name] = $value;
            }

        }

        // Non-standard characters in the title will break CSS compilation, unset it here as it's not needed.
        if ( isset( $vars['title'] ) ) {
            unset( $vars['title'] );
        }

        $vars = apply_filters( "megamenu_scss_variables", $vars, $location, $theme, $menu_id, $this->get_theme_id_for_location($location) );

        $scss = "";

        foreach ($vars as $name => $value) {
            $scss .= "$" . $name . ": " . $value . ";\n";
        }

        $scss .= $this->load_scss_file();

        $scss .= stripslashes( html_entity_decode( $theme['custom_css'], ENT_QUOTES ) );

        return apply_filters( "megamenu_scss", $scss, $location, $theme, $menu_id );

    }


    /**
     * Returns the menu ID for a specified menu location, defaults to 0
     *
     * @since 1.3
     */
    private function get_menu_id_for_location( $location ) {

        $locations = get_nav_menu_locations();

        $menu_id = isset( $locations[ $location ] ) ? $locations[ $location ] : 0;

        return $menu_id;

    }


    /**
     * Returns the theme ID for a specified menu location, defaults to 'default'
     *
     * @since 2.1
     */
    private function get_theme_id_for_location( $location ) {

        $settings = $this->settings;

        $theme_id = isset( $settings[ $location ]['theme'] ) ? $settings[ $location ]['theme'] : 'default';

        return $theme_id;

    }


    /**
     * Returns the theme settings for a specified location. Defaults to the default theme.
     *
     * @since 1.3
     */
    private function get_theme_settings_for_location( $location ) {

        $theme_id = $this->get_theme_id_for_location( $location );

        $all_themes = $this->get_themes();

        $theme_settings = isset( $all_themes[ $theme_id ] ) ? $all_themes[ $theme_id ] : $all_themes[ 'default' ];

        return $theme_settings;

    }


    /**
     * Enqueue public CSS and JS files required by Mega Menu
     *
     * @since 1.0
     */
    public function enqueue_styles() {

        if ( $this->get_css_output_method() == 'fs' ) {
            $this->enqueue_fs_style();
        }

        wp_enqueue_style( 'dashicons' );

        do_action( 'megamenu_enqueue_public_scripts' );

    }

    /**
     * Enqueue public CSS and JS files required by Mega Menu
     *
     * @since 1.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script( 'hoverIntent' );

        $js_path = MEGAMENU_BASE_URL . "js/maxmegamenu.js";

        wp_enqueue_script( 'megamenu', $js_path, array('jquery', 'hoverIntent'), MEGAMENU_VERSION, true );

        $params = apply_filters("megamenu_javascript_localisation",
            array(
                "timeout" => 300,
                "interval" => 100
            )
        );

        wp_localize_script( 'megamenu', 'megamenu', $params );
    }

    /**
     * Returns the menu settings for a specified location.
     *
     * @since 2.2
     */
    private function get_menu_settings_for_location( $location ) {

        $settings = $this->settings;

        $location_settings = isset( $settings[ $location ] ) ? $settings[ $location ] : array();

        return $location_settings;

    }

    /**
     * Enqueue the stylesheet held on the filesystem.
     *
     * @since 1.6.1
     */
    private function enqueue_fs_style() {

        $upload_dir = wp_upload_dir();

        $filename = $this->get_css_filename();

        $filepath = trailingslashit( $upload_dir['basedir'] ) . 'maxmegamenu/' . $filename;

        if ( ! is_file( $filepath ) || $this->is_debug_mode()) {
            // regenerate the CSS and save to filesystem
            $this->generate_css();

        }

        // file should now exist
        if ( is_file( $filepath ) ) {

            $css_url = trailingslashit( $upload_dir['baseurl'] ) . 'maxmegamenu/' . $filename;

            $protocol = is_ssl() ? 'https://' : 'http://';

            // ensure we're using the correct protocol
            $css_url = str_replace( array( "http://", "https://" ), $protocol, $css_url );

            wp_enqueue_style( 'megamenu', $css_url, false, substr( md5( filemtime( $filepath ) ), 0, 6 ) );

        }

    }


    /**
     *
     * @since 1.6.1
     */
    private function set_cached_css( $css ) {

        set_transient( $this->get_transient_key(), $css, 0 );
        set_transient( 'megamenu_css_version', MEGAMENU_VERSION, 0 );

    }


    /**
     * Return the cached css if it exists
     *
     * @since 1.9
     * @return mixed
     */
    private function get_cached_css() {

        return get_transient( $this->get_transient_key() );

    }


    /**
     * Delete the cached CSS
     *
     * @since 1.9
     * @return mixed
     */
    public function delete_cache() {
        global $wp_filesystem;

        if ( ! $wp_filesystem ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $upload_dir = wp_upload_dir();
        $filename = $this->get_css_filename();
        $dir = trailingslashit( $upload_dir['basedir'] ) . 'maxmegamenu/';

        WP_Filesystem( false, $upload_dir['basedir'], true );
        $wp_filesystem->rmdir( $dir, true );

        delete_transient( $this->get_transient_key() );

        $this->generate_css();

        do_action( "megamenu_after_delete_cache" );

        return true;

    }


    /**
     * Return the key to use for the CSS transient
     *
     * @since 1.9
     * @return string
     */
    private function get_transient_key() {

        return apply_filters( 'megamenu_css_transient_key', 'megamenu_css' );

    }


    /**
     * Return the filename to use for the stylesheet, ensuring the filename is unique
     * for multi site setups
     *
     * @since 1.6.1
     */
    private function get_css_filename() {

        return apply_filters( "megamenu_css_filename", 'style' ) . '.css';

    }


    /**
     * Return the CSS output method, default to filesystem
     *
     * @return string
     */
    private function get_css_output_method() {

        return isset( $this->settings['css'] ) ? $this->settings['css'] : 'fs';

    }


    /**
     * Print CSS to <head>
     *
     * @since 1.3.1
     */
    public function head_css() {

        $method = $this->get_css_output_method();
        
        if ( in_array( $method, array( 'disabled', 'fs' ) ) ) {
            echo "<style type=\"text/css\">/** Mega Menu CSS: {$method} **/</style>\n";
            return;
        }

        $css = $this->get_css();

        echo '<style type="text/css">' . str_replace( array( "  ", "\n" ), '', $css ) . "</style>\n";

    }


    /**
     * Delete language specific transients created when PolyLang is installed
     *
     * @since 1.9
     */
    public function polylang_delete_cache() {
        global $polylang;

        foreach ( $polylang->model->get_languages_list() as $term ) {
            delete_transient( 'megamenu_css_' . $term->locale );
        }
    }


    /**
     * Modify the CSS transient key to make it unique to the current language
     *
     * @since 1.9
     * @return string
     */
    public function polylang_transient_key( $key ) {

        $locale = strtolower( pll_current_language('locale') );

        if ( strlen( $locale ) ) {
            $key = $key . "_" . $locale;
        }

        return $key;

    }


    /**
     * Modify the CSS filename to make it unique to the current language
     *
     * @since 1.9
     * @return string
     */
    public function polylang_css_filename( $filename ) {

        $locale = strtolower( pll_current_language('locale') );

        if ( strlen( $locale ) ) {
            $filename .= "_" . $locale;
        }

        return $filename;

    }


    /**
     * Delete language specific transients created when WPML is installed
     *
     * @since 1.9
     */
    public function wpml_delete_cache() {

        $languages = icl_get_languages('skip_missing=N');

        foreach ( $languages as $language ) {
            delete_transient( 'megamenu_css_' . $language['language_code'] );
        }

    }


    /**
     * Modify the CSS transient key to make it unique to the current language
     *
     * @since 1.9
     * @return string
     */
    public function wpml_transient_key( $key ) {

        $key .= "_" . ICL_LANGUAGE_CODE;

        return $key;

    }


    /**
     * Modify the CSS filename to make it unique to the current language
     *
     * @since 1.9
     * @return string
     */
    public function wpml_css_filename( $filename ) {

        $filename .= "_" . ICL_LANGUAGE_CODE;

        return $filename;

    }


}

endif;