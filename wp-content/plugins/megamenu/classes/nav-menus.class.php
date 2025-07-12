<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists( 'Mega_Menu_Nav_Menus' ) ) :
/**
 * Handles all admin related functionality.
 */
class Mega_Menu_Nav_Menus {

    /**
     * Return the default settings for each menu item
     *
     * @since 1.5
     */
    public static function get_menu_item_defaults() {

        $defaults = array(
            'type' => 'flyout',
            'align' => 'bottom-left',
            'icon' => 'disabled',
            'hide_text' => 'false',
            'disable_link' => 'false',
            'hide_on_mobile' => 'false',
            'hide_on_desktop' => 'false',
            'hide_sub_menu_on_mobile' => 'false',
            'hide_arrow' => 'false',
            'item_align' => 'left',
            'icon_position' => 'left',
            'panel_columns' => 6, // total number of columns displayed in the panel
            'mega_menu_columns' => 1, // for sub menu items, how many columns to span in the panel,
            'mega_menu_order' => 0
        );

        return apply_filters( "megamenu_menu_item_defaults", $defaults );

    }

    /**
     * Constructor
     *
     * @since 1.0
     */
    public function __construct() {

        add_action( 'admin_init', array( $this, 'register_nav_meta_box' ), 9 );
        add_action( 'megamenu_nav_menus_scripts', array( $this, 'enqueue_menu_page_scripts' ), 10 );
        add_action( 'wp_ajax_mm_save_settings', array($this, 'save') );
        add_filter( 'hidden_meta_boxes', array( $this, 'show_mega_menu_metabox' ) );

        add_filter('siteorigin_panels_is_admin_page', array( $this, 'enable_site_origin_page_builder' ) );

        if ( function_exists( 'siteorigin_panels_admin_enqueue_scripts' ) ) {
            add_action( 'admin_print_scripts-nav-menus.php', array( $this, 'siteorigin_panels_admin_enqueue_scripts') );
        }

        if ( function_exists( 'siteorigin_panels_admin_enqueue_styles' ) ) {
            add_action( 'admin_print_styles-nav-menus.php', array( $this, 'siteorigin_panels_admin_enqueue_styles') );
        }

    }


    /**
     * Enqueue Site Origin Page Builder scripts on nav-menus page.
     *
     * @since 2.3.7
     */
    public function enable_site_origin_page_builder( $enabled ) {
        $screen = get_current_screen();

        if ($screen->base == 'nav-menus') {
            return true;
        }

        return $enabled;
    }

    /**
     * Enqueue Page Builder scripts (https://wordpress.org/plugins/siteorigin-panels/)
     * @since 1.9
     */
    public function siteorigin_panels_admin_enqueue_scripts() {
        siteorigin_panels_admin_enqueue_scripts('', true);
    }


    /**
     * Enqueue Page Builder styles (https://wordpress.org/plugins/siteorigin-panels/)
     * @since 1.9
     */
    public function siteorigin_panels_admin_enqueue_styles() {
        siteorigin_panels_admin_enqueue_styles('', true);
    }


    /**
     * By default the mega menu meta box is hidden - show it.
     *
     * @since 1.0
     * @param array $hidden
     * @return array
     */
    public function show_mega_menu_metabox( $hidden ) {

        if ( is_array( $hidden ) && count( $hidden ) > 0 ) {
            foreach ( $hidden as $key => $value ) {
                if ( $value == 'mega_menu_meta_box' ) {
                    unset( $hidden[$key] );
                }
            }
        }

        return $hidden;
    }


    /**
     * Adds the meta box container
     *
     * @since 1.0
     */
    public function register_nav_meta_box() {
        global $pagenow;

        if ( 'nav-menus.php' == $pagenow ) {

            add_meta_box(
                'mega_menu_meta_box',
                __("Max Mega Menu Settings", "megamenu"),
                array( $this, 'metabox_contents' ),
                'nav-menus',
                'side',
                'high'
            );

        }

    }


    /**
     * Enqueue required CSS and JS for Mega Menu
     *
     * @since 1.0
     */
    public function enqueue_menu_page_scripts($hook) {

        if( 'nav-menus.php' != $hook )
            return;

        // Compatibility fix for SlideDeck Pro
        wp_deregister_script('codemirror');
        wp_deregister_style('codemirror');

        // Compatibility fix for Pinboard Theme
        wp_deregister_script('colorbox');
        wp_deregister_style('colorbox');

        // Compatibility fix for AGP Font Awesome Collection
        wp_deregister_script('colorbox-js');
        wp_deregister_style('colorbox-css');

        // Compatibility fix for purple-xmls-google-product-feed-for-woocommerce
        wp_deregister_script('cart-product-colorbox');
        wp_deregister_style('cart-product-colorstyle');

        // Compatibility fix for WordFence
        wp_deregister_script('jquery.wfcolorbox');
        wp_deregister_style('wordfence-colorbox-style');

        // Compatibility fix for Profit Builder
        wp_deregister_script('color-box-min');
        wp_deregister_script('color-box');
        wp_deregister_style('color-box-css');

        // Compatibility fix for Reamaze
        wp_deregister_script('jquery-colorbox');
        wp_deregister_style('colorbox-css');


        wp_enqueue_style( 'colorbox', MEGAMENU_BASE_URL . 'js/colorbox/colorbox.css', false, MEGAMENU_VERSION );
        wp_enqueue_style( 'mega-menu', MEGAMENU_BASE_URL . 'css/admin/admin.css', false, MEGAMENU_VERSION );

        wp_enqueue_script( 'mega-menu', MEGAMENU_BASE_URL . 'js/admin.js', array(
            'jquery',
            'jquery-ui-core',
            'jquery-ui-sortable',
            'jquery-ui-accordion'),
        MEGAMENU_VERSION );

        wp_enqueue_script( 'colorbox', MEGAMENU_BASE_URL . 'js/colorbox/jquery.colorbox-min.js', array( 'jquery' ), MEGAMENU_VERSION );

        $settings = get_option( 'megamenu_settings' );

        $prefix = isset( $settings['prefix'] ) ? $settings['prefix'] : 'true';

        wp_localize_script( 'mega-menu', 'megamenu',
            array(
                'debug_launched' => __("Launched for Menu ID", "megamenu"),
                'launch_lightbox' => __("Mega Menu", "megamenu"),
                'is_disabled_error' => __("Please enable Max Mega Menu using the settings on the left of this page.", "megamenu"),
                'save_menu' => __("Please save the menu structure to enable this option.", "megamenu"),
                'saving' => __("Saving", "megamenu"),
                'nonce' => wp_create_nonce('megamenu_edit'),
                'nonce_check_failed' => __("Oops. Something went wrong. Please reload the page.", "megamenu"),
                'css_prefix' => $prefix,
                'css_prefix_message' => __("Custom CSS Classes will be prefixed with 'mega-'", "megamenu"),
                'row_is_full' => __("There is not enough space in this row to add a new column. Make space by reducing the width of the columns within the row or create a new row.", "megamenu")
            )
        );

        do_action("megamenu_enqueue_admin_scripts");

    }

    /**
     * Show the Meta Menu settings
     *
     * @since 1.0
     */
    public function metabox_contents() {

        $menu_id = $this->get_selected_menu_id();

        $this->print_enable_megamenu_options( $menu_id );

    }


    /**
     * Save the mega menu settings (submitted from Menus Page Meta Box)
     *
     * @since 1.0
     */
    public function save() {

        check_ajax_referer( 'megamenu_edit', 'nonce' );

        if ( isset( $_POST['menu'] ) && $_POST['menu'] > 0 && is_nav_menu( $_POST['menu'] ) && isset( $_POST['megamenu_meta'] ) ) {

            $raw_submitted_settings = $_POST['megamenu_meta'];

            $parsed_submitted_settings = json_decode( stripslashes( $raw_submitted_settings ), true );

            $submitted_settings = array();

            foreach ( $parsed_submitted_settings as $index => $value ) {
                $name = $value['name'];

                // find values between square brackets
                preg_match_all( "/\[(.*?)\]/", $name, $matches );

                if ( isset( $matches[1][0] ) && isset( $matches[1][1] ) ) {
                    $location = $matches[1][0];
                    $setting = $matches[1][1];

                    $submitted_settings[$location][$setting] = $value['value'];
                }
            }

            $submitted_settings = apply_filters("megamenu_submitted_settings_meta", $submitted_settings);

            if ( ! get_option( 'megamenu_settings' ) ) {

                update_option( 'megamenu_settings', $submitted_settings );

            } else {

                $existing_settings = get_option( 'megamenu_settings' );

                $new_settings = array_merge( $existing_settings, $submitted_settings );

                update_option( 'megamenu_settings', $new_settings );

            }

            do_action( "megamenu_after_save_settings" );

            do_action( "megamenu_delete_cache" );

        }

        wp_die();

    }


    /**
     * Print the custom Meta Box settings
     *
     * @param int $menu_id
     * @since 1.0
     */
    public function print_enable_megamenu_options( $menu_id ) {

        $tagged_menu_locations = $this->get_tagged_theme_locations_for_menu_id( $menu_id );
        $theme_locations = get_registered_nav_menus();

        $saved_settings = get_option( 'megamenu_settings' );

        if ( ! count( $theme_locations ) ) {

            $link = '<a href="https://www.megamenu.com/documentation/widget/?utm_source=free&amp;utm_medium=link&amp;utm_campaign=pro" target="_blank">' . __("here", "megamenu") . '</a>';

            echo "<p>" . __("This theme does not register any menu locations.", "megamenu") . "</p>";
            echo "<p>" . __("You will need to create a new menu location and use the Max Mega Menu widget or shortcode to display the menu on your site.", "megamenu") . "</p>";
            echo "<p>" . str_replace( "{link}", $link, __("Click {link} for instructions.", "megamenu") ) . "</p>";

        } else if ( ! count ( $tagged_menu_locations ) ) {

            echo "<p>" . __("Please assign this menu to a theme location to enable the Mega Menu settings.", "megamenu") . "</p>";

            echo "<p>" . __("To assign this menu to a theme location, scroll to the bottom of this page and tag the menu to a 'Display location'.", "megamenu") . "</p>";

        } else { ?>

            <?php if ( count( $tagged_menu_locations ) == 1 ) : ?>

                <?php

                $locations = array_keys( $tagged_menu_locations );
                $location = $locations[0];

                if (isset( $tagged_menu_locations[ $location ] ) ) {
                    $this->settings_table( $location, $saved_settings );
                }

                ?>

            <?php else: ?>

                <div id='megamenu_accordion'>

                    <?php foreach ( $theme_locations as $location => $name ) : ?>

                        <?php if ( isset( $tagged_menu_locations[ $location ] ) ): ?>

                            <h3 class='theme_settings'><?php echo esc_html( $name ); ?></h3>

                            <div class='accordion_content' style='display: none;'>
                                <?php $this->settings_table( $location, $saved_settings ); ?>
                            </div>

                        <?php endif; ?>

                    <?php endforeach;?>
                </div>

            <?php endif; ?>

            <?php

            submit_button( __( 'Save' ), 'max-mega-menu-save button-primary alignright');

            ?>

            <span class='spinner'></span>

            <?php

        }

    }

    /**
     * Print the list of Mega Menu settings
     *
     * @since 1.0
     */
    public function settings_table( $location, $settings ) {
        ?>
        <table>
            <tr>
                <td><?php _e("Enable", "megamenu") ?></td>
                <td>
                    <input type='checkbox' class='megamenu_enabled' name='megamenu_meta[<?php echo $location ?>][enabled]' value='1' <?php checked( isset( $settings[$location]['enabled'] ) ); ?> />
                </td>
            </tr>
            <tr>
                <td><?php _e("Event", "megamenu") ?></td>
                <td>
                    <select name='megamenu_meta[<?php echo $location ?>][event]'>
                        <option value='hover' <?php selected( isset( $settings[$location]['event'] ) && $settings[$location]['event'] == 'hover'); ?>><?php _e("Hover Intent", "megamenu"); ?></option>
                        <option value='hover_' <?php selected( isset( $settings[$location]['event'] ) && $settings[$location]['event'] == 'hover_'); ?>><?php _e("Hover", "megamenu"); ?></option>
                        <option value='click' <?php selected( isset( $settings[$location]['event'] ) && $settings[$location]['event'] == 'click'); ?>><?php _e("Click", "megamenu"); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php _e("Effect", "megamenu") ?></td>
                <td>
                    <select name='megamenu_meta[<?php echo $location ?>][effect]'>
                    <?php

                        $selected = isset( $settings[$location]['effect'] ) ? $settings[$location]['effect'] : 'fade_up';

                        $options = apply_filters("megamenu_transition_effects", array(
                            "disabled" => array(
                                'label' => __("None", "megamenu"),
                                'selected' => $selected == 'disabled',
                            ),
                            "fade" => array(
                                'label' => __("Fade", "megamenu"),
                                'selected' => $selected == 'fade',
                            ),
                            "fade_up" => array(
                                'label' => __("Fade Up", "megamenu"),
                                'selected' => $selected == 'fade_up' || $selected == 'fadeUp',
                            ),
                            "slide" => array(
                                'label' => __("Slide", "megamenu"),
                                'selected' => $selected == 'slide',
                            ),
                            "slide_up" => array(
                                'label' => __("Slide Up", "megamenu"),
                                'selected' => $selected == 'slide_up',
                            )
                        ), $selected );

                        foreach ( $options as $key => $value ) {
                            ?><option value='<?php echo $key ?>' <?php selected( $value['selected'] ); ?>><?php echo $value['label'] ?></option><?php
                        }

                    ?>
                    </select>

                    <select name='megamenu_meta[<?php echo $location ?>][effect_speed]'>
                    <?php

                        $selected = isset( $settings[$location]['effect_speed'] ) ? $settings[$location]['effect_speed'] : '200';

                        $options = apply_filters("megamenu_effect_speed", array(
                            "600" => __("Slow", "megamenu"),
                            "400" => __("Med", "megamenu"),
                            "200" => __("Fast", "megamenu")
                        ), $selected );

                        ksort($options);

                        foreach ( $options as $key => $value ) {
                            ?><option value='<?php echo $key ?>' <?php selected( $key == $selected ); ?>><?php echo $value ?></option><?php
                        }

                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php _e("Theme", "megamenu"); ?></td>
                <td>

                    <select name='megamenu_meta[<?php echo $location ?>][theme]'>
                        <?php
                            $style_manager = new Mega_Menu_Style_Manager();
                            $themes = $style_manager->get_themes();
                            $selected_theme = isset( $settings[$location]['theme'] ) ? $settings[$location]['theme'] : 'default';

                            foreach ( $themes as $key => $theme ) {
                                echo "<option value='{$key}' " . selected( $selected_theme, $key ) . ">{$theme['title']}</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>

            <?php do_action( 'megamenu_settings_table', $location, $settings ); ?>
        </table>
        <?php
    }


    /**
     * Return the locations that a specific menu ID has been tagged to.
     *
     * @param $menu_id int
     * @return array
     */
    public function get_tagged_theme_locations_for_menu_id( $menu_id ) {

        $locations = array();

        $nav_menu_locations = get_nav_menu_locations();

        foreach ( get_registered_nav_menus() as $id => $name ) {

            if ( isset( $nav_menu_locations[ $id ] ) && $nav_menu_locations[$id] == $menu_id )
                $locations[$id] = $name;

        }

        return $locations;
    }

    /**
     * Get the current menu ID.
     *
     * Most of this taken from wp-admin/nav-menus.php (no built in functions to do this)
     *
     * @since 1.0
     * @return int
     */
    public function get_selected_menu_id() {

        $nav_menus = wp_get_nav_menus( array('orderby' => 'name') );

        $menu_count = count( $nav_menus );

        $nav_menu_selected_id = isset( $_REQUEST['menu'] ) ? (int) $_REQUEST['menu'] : 0;

        $add_new_screen = ( isset( $_GET['menu'] ) && 0 == $_GET['menu'] ) ? true : false;

        // If we have one theme location, and zero menus, we take them right into editing their first menu
        $page_count = wp_count_posts( 'page' );
        $one_theme_location_no_menus = ( 1 == count( get_registered_nav_menus() ) && ! $add_new_screen && empty( $nav_menus ) && ! empty( $page_count->publish ) ) ? true : false;

        // Get recently edited nav menu
        $recently_edited = absint( get_user_option( 'nav_menu_recently_edited' ) );
        if ( empty( $recently_edited ) && is_nav_menu( $nav_menu_selected_id ) )
            $recently_edited = $nav_menu_selected_id;

        // Use $recently_edited if none are selected
        if ( empty( $nav_menu_selected_id ) && ! isset( $_GET['menu'] ) && is_nav_menu( $recently_edited ) )
            $nav_menu_selected_id = $recently_edited;

        // On deletion of menu, if another menu exists, show it
        if ( ! $add_new_screen && 0 < $menu_count && isset( $_GET['action'] ) && 'delete' == $_GET['action'] )
            $nav_menu_selected_id = $nav_menus[0]->term_id;

        // Set $nav_menu_selected_id to 0 if no menus
        if ( $one_theme_location_no_menus ) {
            $nav_menu_selected_id = 0;
        } elseif ( empty( $nav_menu_selected_id ) && ! empty( $nav_menus ) && ! $add_new_screen ) {
            // if we have no selection yet, and we have menus, set to the first one in the list
            $nav_menu_selected_id = $nav_menus[0]->term_id;
        }

        return $nav_menu_selected_id;

    }
}

endif;