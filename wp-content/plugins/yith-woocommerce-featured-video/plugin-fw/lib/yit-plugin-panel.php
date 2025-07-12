<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'YIT_Plugin_Panel' ) ) {
    /**
     * YIT Plugin Panel
     *
     * Setting Page to Manage Plugins
     *
     * @class YIT_Plugin_Panel
     * @package    Yithemes
     * @since      1.0
     * @author     Your Inspiration Themes
     */

    class YIT_Plugin_Panel {

        /**
         * @var string version of class
         */
        public $version = '1.0.0';

        /**
         * @var array a setting list of parameters
         */
        public $settings = array();

        /**
         * @var array
         */
        protected $_tabs_path_files;

        /**
         * @var array
         */
        private $_main_array_options = array();

        /**
         * @var array
         */
        public $links;

	    /**
	     * Constructor
	     *
	     * @since  1.0
	     * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
	     *
	     * @param array $args
	     */
        public function __construct( $args = array() ) {

            if ( ! empty( $args ) ) {

                $default_args = array(
                    'parent_slug' => 'edit.php?',
                    'page_title'  => __( 'Plugin Settings', 'yith-plugin-fw' ),
                    'menu_title'  => __( 'Settings', 'yith-plugin-fw' ),
                    'capability'  => 'manage_options',
	                'icon_url'    => '',
	                'position'    => null
                );

                $args = apply_filters( 'yit_plugin_fw_panel_option_args', wp_parse_args( $args, $default_args ) );

                $this->settings         = $args;
                $this->_tabs_path_files = $this->get_tabs_path_files();

                if ( isset( $this->settings['create_menu_page'] ) && $this->settings['create_menu_page'] ) {
                    $this->add_menu_page();
                }

                if ( !empty( $this->settings[ 'links' ] ) ) {
                    $this->links = $this->settings[ 'links' ];
                }

                add_action( 'admin_init', array( $this, 'register_settings' ) );
                add_action( 'admin_menu', array( $this, 'add_setting_page' ), 20 );
                add_action( 'admin_menu', array( $this, 'add_premium_version_upgrade_to_menu' ), 100 );
                add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_menu' ), 100 );
                add_action( 'admin_init', array( $this, 'add_fields' ) );
            }

            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        }

        /**
         * Add Menu page link
         *
         * @return void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function add_menu_page() {
           global $admin_page_hooks;

            if( ! isset( $admin_page_hooks['yit_plugin_panel'] ) ){
                $position = apply_filters( 'yit_plugins_menu_item_position', '62.32' );
                //  YITH Plugins text must not be translated
	            apply_filters('yit_plugin_panel_menu_page_capability', current_user_can( 'manage_options' )) && add_menu_page( 'yit_plugin_panel', 'YITH Plugins', 'manage_options', 'yit_plugin_panel', NULL, YIT_CORE_PLUGIN_URL . '/assets/images/yithemes-icon.png', $position );
            }
        }

        /**
         * Remove duplicate submenu
         *
         * Submenu page hack: Remove the duplicate YIT Plugin link on subpages
         *
         * @return void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function remove_duplicate_submenu_page() {
            /* === Duplicate Items Hack === */
            remove_submenu_page( 'yit_plugin_panel', 'yit_plugin_panel' );
        }

        /**
         * Enqueue script and styles in admin side
         *
         * Add style and scripts to administrator
         *
         * @return void
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function admin_enqueue_scripts() {

            global $wp_scripts, $pagenow;

            //scripts
            wp_enqueue_media();
            wp_enqueue_script( 'jquery-ui' );
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-slider' );
            wp_enqueue_script( 'jquery-ui-dialog' );
            wp_enqueue_script( 'jquery-chosen', YIT_CORE_PLUGIN_URL . '/assets/js/chosen/chosen.jquery.js', array( 'jquery' ), '1.1.0', true );
            wp_register_script( 'yit-plugin-panel', YIT_CORE_PLUGIN_URL . '/assets/js/yit-plugin-panel.js', array( 'jquery', 'jquery-chosen','wp-color-picker'), $this->version, true );
            wp_register_script( 'codemirror', YIT_CORE_PLUGIN_URL . '/assets/js/codemirror/codemirror.js', array( 'jquery' ), $this->version, true );
            wp_register_script( 'codemirror-javascript', YIT_CORE_PLUGIN_URL . '/assets/js/codemirror/javascript.js', array( 'jquery', 'codemirror' ), $this->version, true );
            wp_register_script( 'colorbox', YIT_CORE_PLUGIN_URL . '/assets/js/jquery.colorbox.js', array( 'jquery' ), '1.6.3', true );
            wp_enqueue_script( 'yith_how_to', YIT_CORE_PLUGIN_URL . '/assets/js/how-to.js', array('jquery'), $this->version, true );

            //styles
            $jquery_version = isset( $wp_scripts->registered['jquery-ui-core']->ver ) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';
            wp_register_style( 'codemirror', YIT_CORE_PLUGIN_URL . '/assets/css/codemirror/codemirror.css' );
            wp_enqueue_style( 'jquery-ui-overcast', YIT_CORE_PLUGIN_URL . '/assets/css/overcast/jquery-ui-custom/jquery-ui-1.8.9.custom.css', false, '1.8.9', 'all' );
            wp_register_style( 'yit-plugin-style', YIT_CORE_PLUGIN_URL . '/assets/css/yit-plugin-panel.css', array(), $this->version );
            wp_enqueue_style( 'raleway-font', '//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,100,200,300,900' );
            wp_enqueue_style( 'jquery-chosen', YIT_CORE_PLUGIN_URL . '/assets/css/chosen/chosen.css' );
            wp_enqueue_style( 'yit-jquery-ui-style', '//code.jquery.com/ui/' . $jquery_version . '/themes/smoothness/jquery-ui.css', array(), $jquery_version );
            wp_register_style( 'colorbox', YIT_CORE_PLUGIN_URL . '/assets/css/colorbox.css', array(), $this->version );
            wp_register_style( 'yit-upgrade-to-pro', YIT_CORE_PLUGIN_URL . '/assets/css/yit-upgrade-to-pro.css', array( 'colorbox' ), $this->version );
            
             if( ( 'admin.php' == $pagenow && strpos( get_current_screen()->id, 'yith-plugins_page' ) !== false ) || apply_filters( 'yit_plugin_panel_asset_loading', false ) ){
                 wp_enqueue_style( 'yit-plugin-style' );
                 wp_enqueue_script( 'yit-plugin-panel' );
            }

            if( 'admin.php' == $pagenow && strpos( get_current_screen()->id, 'yith_upgrade_premium_version' ) !== false ){
                wp_enqueue_style( 'yit-upgrade-to-pro' );
                wp_enqueue_script( 'colorbox' );
            }

        }

        /**
         * Register Settings
         *
         * Generate wp-admin settings pages by registering your settings and using a few callbacks to control the output
         *
         * @return void
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function register_settings() {
            register_setting( 'yit_' . $this->settings['parent'] . '_options', 'yit_' . $this->settings['parent'] . '_options', array( $this, 'options_validate' ) );
        }

        /**
         * Options Validate
         *
         * a callback function called by Register Settings function
         *
         * @param $input
         *
         * @return array validate input fields
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function options_validate( $input ) {

            $current_tab = ! empty( $input['current_tab'] ) ? $input['current_tab'] : 'general';

            $yit_options = $this->get_main_array_options();

            // default
            $valid_input = $this->get_options();

            $submit = ( ! empty( $input['submit-general'] ) ? true : false );
            $reset  = ( ! empty( $input['reset-general'] ) ? true : false );

            foreach ( $yit_options[$current_tab] as $section => $data ) {
                foreach ( $data as $option ) {
                    if ( isset( $option['sanitize_call'] ) && isset( $option['id'] ) ) { //yiw_debug($option, false);
                        if ( is_array( $option['sanitize_call'] ) ) :
                            foreach ( $option['sanitize_call'] as $callback ) {
                                if ( is_array( $input[$option['id']] ) ) {
                                    $valid_input[$option['id']] = array_map( $callback, $input[$option['id']] );
                                }
                                else {
                                    $valid_input[$option['id']] = call_user_func( $callback, $input[$option['id']] );
                                }
                            }
                        else :
                            if ( is_array( $input[$option['id']] ) ) {
                                $valid_input[$option['id']] = array_map( $option['sanitize_call'], $input[$option['id']] );
                            }
                            else {
                                $valid_input[$option['id']] = call_user_func( $option['sanitize_call'], $input[$option['id']] );
                            }
                        endif;
                    }
                    else {
                        if ( isset( $option['id'] ) ) {
                            if ( isset( $input[$option['id']] ) ) {
                                $valid_input[$option['id']] = $input[$option['id']];
                            }
                            else {
                                $valid_input[$option['id']] = 'no';
                            }

                        }
                    }

                }
            }

            return $valid_input;
        }

        /**
         * Add Setting SubPage
         *
         * add Setting SubPage to wordpress administrator
         *
         * @return array validate input fields
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function add_setting_page() {
	        $this->settings['icon_url'] = isset( $this->settings['icon_url'] ) ? $this->settings['icon_url'] : '';
		    $this->settings['position'] = isset( $this->settings['position'] ) ? $this->settings['position'] : null;
	        $parent = $this->settings['parent_slug'] . $this->settings['parent_page'];

	        if ( ! empty( $parent ) ) {
		        add_submenu_page( $parent, $this->settings['page_title'], $this->settings['menu_title'], $this->settings['capability'], $this->settings['page'], array( $this, 'yit_panel' ) );
	        } else {
		        add_menu_page( $this->settings['page_title'], $this->settings['menu_title'], $this->settings['capability'], $this->settings['page'], array( $this, 'yit_panel' ), $this->settings['icon_url'], $this->settings['position'] );
	        }
            /* === Duplicate Items Hack === */
            $this->remove_duplicate_submenu_page();
            do_action( 'yit_after_add_settings_page' );


        }

        /**
         * Add Premium Version upgrade menu item
         *
         * @return   void
         * @since    2.9.13
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function add_premium_version_upgrade_to_menu(){
            global $submenu;

            if( apply_filters( 'yit_show_upgrade_to_premium_version', ! isset( $submenu['yit_plugin_panel']['how_to'] ) ) ){
                $submenu['yit_plugin_panel']['how_to'] = array(
                    sprintf( '%s%s%s', '<span id="yith-how-to-premium">', __( 'How to install premium version', 'yith-plugin-fw' ), '</span>' ),
                    'install_plugins',
                    '//support.yithemes.com/hc/en-us/articles/217840988',
                    __( 'How to install premium version', 'yith-plugin-fw' ),
                );
            }
        }

        /**
         * Show a tabbed panel to setting page
         *
         * a callback function called by add_setting_page => add_submenu_page
         *
         * @return void
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function yit_panel() {

            $tabs        = '';
            $current_tab = $this->get_current_tab();
            $yit_options = $this->get_main_array_options();

            // tabs
            foreach ( $this->settings['admin-tabs'] as $tab => $tab_value ) {
                $active_class = ( $current_tab == $tab ) ? ' nav-tab-active' : '';
                $tabs .= '<a class="nav-tab' . $active_class . '" href="?' . $this->settings['parent_page'] . '&page=' . $this->settings['page'] . '&tab=' . $tab . '">' . $tab_value . '</a>';
            }
            ?>
            <div id="icon-themes" class="icon32"><br /></div>
            <h2 class="yith nav-tab-wrapper">
                <?php echo $tabs ?>
            </h2>
            <?php
            $custom_tab_action = $this->is_custom_tab( $yit_options, $current_tab );
            if ( $custom_tab_action ) {
                $this->print_custom_tab( $custom_tab_action );
                return;
            }
            ?>
	        <?php $this->print_video_box(); ?>
            <?php
            $panel_content_class = apply_filters( 'yit_admin_panel_content_class', 'yit-admin-panel-content-wrap' );
            ?>
            <div id="wrap" class="plugin-option yit-admin-panel-container">
                <?php $this->message(); ?>
                <div class="<?php echo $panel_content_class; ?>">
                <h2><?php echo $this->get_tab_title() ?></h2>
                <?php if ( $this->is_show_form() ) : ?>
                    <form method="post" action="options.php">
                        <?php do_settings_sections( 'yit' ); ?>
                        <p>&nbsp;</p>
                        <?php settings_fields( 'yit_' . $this->settings['parent'] . '_options' ); ?>
                        <input type="hidden" name="<?php echo $this->get_name_field( 'current_tab' ) ?>" value="<?php echo esc_attr( $current_tab ) ?>" />
                        <input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'yith-plugin-fw' ) ?>" style="float:left;margin-right:10px;" />
                    </form>
                    <form method="post">
                        <?php $warning = __( 'If you continue with this action, you will reset all options in this page.', 'yith-plugin-fw' ) ?>
                        <input type="hidden" name="yit-action" value="reset" />
                        <input type="submit" name="yit-reset" class="button-secondary" value="<?php _e( 'Reset to default', 'yith-plugin-fw' ) ?>" onclick="return confirm('<?php echo $warning . '\n' . __( 'Are you sure?', 'yith-plugin-fw' ) ?>');" />
                    </form>
                    <p>&nbsp;</p>
                <?php endif ?>
                </div>
            </div>
        <?php
        }

        public function is_custom_tab( $options, $current_tab ) {
            foreach ( $options[$current_tab] as $section => $option ) {
                if ( isset( $option['type'] ) && isset( $option['action'] ) && 'custom_tab' == $option['type'] && ! empty( $option['action'] ) ) {
                    return $option['action'];
                }
                else {
                    return false;
                }
            }
            return false;
        }

        /**
         * Fire the action to print the custom tab
         *
         *
         * @param string $action Action to fire
         *
         * @return void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function print_custom_tab( $action) {
            do_action( $action );
        }

        /**
         * Add sections and fields to setting panel
         *
         * read all options and show sections and fields
         *
         * @return void
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function add_fields() {
            $yit_options = $this->get_main_array_options();
            $current_tab = $this->get_current_tab();

            if ( ! $current_tab ) {
                return;
            }
            foreach ( $yit_options[$current_tab] as $section => $data ) {
                add_settings_section( "yit_settings_{$current_tab}_{$section}", $this->get_section_title( $section ), $this->get_section_description( $section ), 'yit' );
                foreach ( $data as $option ) {
                    if ( isset( $option['id'] ) && isset( $option['type'] ) && isset( $option['name'] ) ) {
                        add_settings_field( "yit_setting_" . $option['id'], $option['name'], array( $this, 'render_field' ), 'yit', "yit_settings_{$current_tab}_{$section}", array( 'option' => $option, 'label_for' => $this->get_id_field( $option['id'] ) ) );
                    }
                }
            }
        }


        /**
         * Add the tabs to admin bar menu
         *
         * set all tabs of settings page on wp admin bar
         *
         * @return void|array return void when capability is false
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function add_admin_bar_menu() {

            global $wp_admin_bar;

            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            if ( ! empty( $this->settings['admin_tabs'] ) ) {
                foreach ( $this->settings['admin-tabs'] as $item => $title ) {

                    $wp_admin_bar->add_menu( array(
                        'parent' => $this->settings['parent'],
                        'title'  => $title,
                        'id'     => $this->settings['parent'] . '-' . $item,
                        'href'   => admin_url( 'themes.php' ) . '?page=' . $this->settings['parent_page'] . '&tab=' . $item
                    ) );
                }
            }
        }


        /**
         * Get current tab
         *
         * get the id of tab showed, return general is the current tab is not defined
         *
         * @return string
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function get_current_tab() {
            $admin_tabs = array_keys( $this->settings['admin-tabs'] );

            if ( ! isset( $_GET['page'] ) || $_GET['page'] != $this->settings['page'] ) {
                return false;
            }
            if ( isset( $_REQUEST['yit_tab_options'] ) ) {
                return $_REQUEST['yit_tab_options'];
            }
            elseif ( isset( $_GET['tab'] ) && isset( $this->_tabs_path_files[$_GET['tab']] ) ) {
                return $_GET['tab'];
            }
            elseif ( isset( $admin_tabs[0] ) ) {
                return $admin_tabs[0];
            }
            else {
                return 'general';
            }
        }


        /**
         * Message
         *
         * define an array of message and show the content od message if
         * is find in the query string
         *
         * @return void
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function message() {

            $message = array(
                'element_exists'   => $this->get_message( '<strong>' . __( 'The element you have entered already exists. Please, enter another name.', 'yith-plugin-fw' ) . '</strong>', 'error', false ),
                'saved'            => $this->get_message( '<strong>' . __( 'Settings saved', 'yith-plugin-fw' ) . '.</strong>', 'updated', false ),
                'reset'            => $this->get_message( '<strong>' . __( 'Settings reset', 'yith-plugin-fw' ) . '.</strong>', 'updated', false ),
                'delete'           => $this->get_message( '<strong>' . __( 'Element deleted correctly.', 'yith-plugin-fw' ) . '</strong>', 'updated', false ),
                'updated'          => $this->get_message( '<strong>' . __( 'Element updated correctly.', 'yith-plugin-fw' ) . '</strong>', 'updated', false ),
                'settings-updated' => $this->get_message( '<strong>' . __( 'Element updated correctly.', 'yith-plugin-fw' ) . '</strong>', 'updated', false ),
                'imported'         => $this->get_message( '<strong>' . __( 'Database imported correctly.', 'yith-plugin-fw' ) . '</strong>', 'updated', false ),
                'no-imported'      => $this->get_message( '<strong>' . __( 'An error has occurred during import. Please try again.', 'yith-plugin-fw' ) . '</strong>', 'error', false ),
                'file-not-valid'   => $this->get_message( '<strong>' . __( 'The added file is not valid.', 'yith-plugin-fw' ) . '</strong>', 'error', false ),
                'cant-import'      => $this->get_message( '<strong>' . __( 'Sorry, import is disabled.', 'yith-plugin-fw' ) . '</strong>', 'error', false ),
                'ord'              => $this->get_message( '<strong>' . __( 'Sorting successful.', 'yith-plugin-fw' ) . '</strong>', 'updated', false )
            );

            foreach ( $message as $key => $value ) {
                if ( isset( $_GET[$key] ) ) {
                    echo $message[$key];
                }
            }

        }

        /**
         * Get Message
         *
         * return html code of message
         *
         * @param        $message
         * @param string $type can be 'error' or 'updated'
         * @param bool   $echo
         *
         * @return void|string
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function get_message( $message, $type = 'error', $echo = true ) {
            $message = '<div id="message" class="' . $type . ' fade"><p>' . $message . '</p></div>';
            if ( $echo ) {
                echo $message;
            }
            return $message;
        }


        /**
         * Get Tab Path Files
         *
         * return an array with filenames of tabs
         *
         * @return array
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function get_tabs_path_files() {

            $option_files_path = $this->settings['options-path'] . '/';

            $tabs = array();

            foreach ( ( array ) glob( $option_files_path . '*.php' ) as $filename ) {
                preg_match( '/(.*)-options\.(.*)/', basename( $filename ), $filename_parts );

	            if ( ! isset( $filename_parts[1] ) ) {
		            continue;
	            }

                $tab = $filename_parts[1];

                $tabs[$tab] = $filename;
            }

            return $tabs;
        }

        /**
         * Get main array options
         *
         * return an array with all options defined on options-files
         *
         * @return array
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function get_main_array_options() {
            if ( ! empty( $this->_main_array_options ) ) {
                return $this->_main_array_options;
            }

            foreach ( $this->settings['admin-tabs'] as $item => $v ) {
                $path = $this->settings['options-path'] . '/' . $item . '-options.php';
                if ( file_exists( $path ) ) {
                    $this->_main_array_options = array_merge( $this->_main_array_options, include $path );
                }
            }

            return $this->_main_array_options;
        }


        /**
         * Set an array with all default options
         *
         * put default options in an array
         *
         * @return array
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function get_default_options() {
            $yit_options     = $this->get_main_array_options();
            $default_options = array();

            foreach ( $yit_options as $tab => $sections ) {
                foreach ( $sections as $section ) {
                    foreach ( $section as $id => $value ) {
                        if ( isset( $value['std'] ) && isset( $value['id'] ) ) {
                            $default_options[$value['id']] = $value['std'];
                        }
                    }
                }
            }

            unset( $yit_options );
            return $default_options;
        }


        /**
         * Get the title of the tab
         *
         * return the title of tab
         *
         * @return string
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function get_tab_title() {
            $yit_options = $this->get_main_array_options();
            $current_tab = $this->get_current_tab();

            foreach ( $yit_options[$current_tab] as $sections => $data ) {
                foreach ( $data as $option ) {
                    if ( isset( $option['type'] ) && $option['type'] == 'title' ) {
                        return $option['name'];
                    }
                }
            }
        }

        /**
         * Get the title of the section
         *
         * return the title of section
         *
         * @param $section
         *
         * @return string
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function get_section_title( $section ) {
            $yit_options = $this->get_main_array_options();
            $current_tab = $this->get_current_tab();

            foreach ( $yit_options[$current_tab][$section] as $option ) {
                if ( isset( $option['type'] ) && $option['type'] == 'section' ) {
                    return $option['name'];
                }
            }
        }

        /**
         * Get the description of the section
         *
         * return the description of section if is set
         *
         * @param $section
         *
         * @return string
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function get_section_description( $section ) {
            $yit_options = $this->get_main_array_options();
            $current_tab = $this->get_current_tab();

            foreach ( $yit_options[$current_tab][$section] as $option ) {
                if ( isset( $option['type'] ) && $option['type'] == 'section' && isset( $option['desc'] ) ) {
                    return '<p>' . $option['desc'] . '</p>';
                }
            }
        }


        /**
         * Show form when necessary
         *
         * return true if 'showform' is not defined
         *
         * @return bool
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function is_show_form() {
            $yit_options = $this->get_main_array_options();
            $current_tab = $this->get_current_tab();

            foreach ( $yit_options[$current_tab] as $sections => $data ) {
                foreach ( $data as $option ) {
                    if ( ! isset( $option['type'] ) || $option['type'] != 'title' ) {
                        continue;
                    }
                    if ( isset( $option['showform'] ) ) {
                        return $option['showform'];
                    }
                    else {
                        return true;
                    }
                }
            }
        }

        /**
         * Get name field
         *
         * return a string with the name of the input field
         *
         * @param string $name
         *
         * @return string
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function get_name_field( $name = '' ) {
            return 'yit_' . $this->settings['parent'] . '_options[' . $name . ']';
        }

        /**
         * Get id field
         *
         * return a string with the id of the input field
         *
         * @param string $id
         *
         * @return string
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function get_id_field( $id ) {
            return 'yit_' . $this->settings['parent'] . '_options_' . $id;
        }


        /**
         * Render the field showed in the setting page
         *
         * include the file of the option type, if file do not exists
         * return a text area
         *
         * @param array $param
         *
         * @return void
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        function render_field( $param ) {

            if ( ! empty( $param ) && isset( $param ['option'] ) ) {
                $option     = $param ['option'];
                $db_options = $this->get_options();

                $custom_attributes = array();

                if ( ! empty( $option['custom_attributes'] ) && is_array( $option['custom_attributes'] ) ) {
                    foreach ( $option['custom_attributes'] as $attribute => $attribute_value ) {
                        $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
                    }
                }

                $custom_attributes = implode( ' ', $custom_attributes );
                $std = isset( $option['std'] ) ? $option['std'] : '';
                $db_value = ( isset( $db_options[$option['id']] ) ) ? $db_options[$option['id']] : $std;

                if ( isset( $option['deps'] ) ) {
                    $deps = $option['deps'];
                }
                $type = YIT_CORE_PLUGIN_PATH . '/templates/panel/types/' . $option['type'] . '.php';
                if ( file_exists( $type ) ) {
                    include $type;
                }
                else {
                    do_action( "yit_panel_{$option['type']}", $option, $db_value, $custom_attributes );
                }
            }
        }

        /**
         * Get options from db
         *
         * return the options from db, if the options aren't defined in the db,
         * get the default options ad add the options in the db
         *
         * @return array
         * @since  1.0
         * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function get_options() {
            $options = get_option( 'yit_' . $this->settings['parent'] . '_options' );
            if ( $options === false || ( isset( $_REQUEST['yit-action'] ) && $_REQUEST['yit-action'] == 'reset' ) ) {
                $options = $this->get_default_options();
            }
            return $options;
        }

        /**
         * Show a box panel with specific content in two columns as a new woocommerce type
         *
         *
         * @param array $args
         *
         * @return   void
         * @since    1.0
         * @author   Emanuela Castorina      <emanuela.castorina@yithemes.com>
         */
        public function add_infobox( $args = array() ) {
            if ( ! empty( $args ) ) {
                extract( $args );
                require_once( YIT_CORE_PLUGIN_TEMPLATE_PATH . '/panel/boxinfo.php' );
            }
        }

        /**
         * Show a box panel with specific content in two columns as a new woocommerce type
         *
         * @param array $args
         *
         * @return   void
         * @since    1.0
         * @author   Emanuela Castorina      <emanuela.castorina@yithemes.com>
         */
        public function add_videobox( $args = array() ) {
            if ( ! empty( $args ) ) {
                extract( $args );
                require_once( YIT_CORE_PLUGIN_TEMPLATE_PATH . '/panel/videobox.php' );
            }
        }

	    /**
	     * Fire the action to print the custom tab
	     *
	     * @return void
	     * @since    1.0
	     * @author   Antonino Scarfì <antonino.scarfi@yithemes.com>
	     */
	    public function print_video_box() {
		    $file = $this->settings['options-path'] . '/video-box.php';

		    if ( ! file_exists( $file ) ) {
			    return;
		    }

		    $args = include_once( $file );

		    $this->add_videobox( $args );
	    }
    }
}