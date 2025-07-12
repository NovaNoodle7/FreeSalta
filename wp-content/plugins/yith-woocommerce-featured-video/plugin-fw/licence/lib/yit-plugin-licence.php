<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'YIT_Plugin_Licence' ) ) {
    /**
     * YIT Plugin Licence Panel
     *
     * Setting Page to Manage Plugins
     *
     * @class      YIT_Plugin_Licence
     * @package    Yithemes
     * @since      1.0
     * @author     Andrea Grillo      <andrea.grillo@yithemes.com>
     */
    class YIT_Plugin_Licence extends YIT_Licence {

        /**
         * @var array The settings require to add the submenu page "Activation"
         * @since 1.0
         */
        protected $_settings = array();

        /**
         * @var object The single instance of the class
         * @since 1.0
         */
        protected static $_instance = null;

        /**
         * @var string Option name
         * @since 1.0
         */
        protected $_licence_option = 'yit_plugin_licence_activation';

        /**
         * @var string product type
         * @since 1.0
         */
        protected $_product_type = 'plugin';

        /**
         * Constructor
         *
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function __construct() {
            parent::__construct();

            if ( !is_admin() ) {
                return;
            }

            $this->_settings = array(
                'parent_page' => 'yit_plugin_panel',
                'page_title'  => __( 'License Activation', 'yith-plugin-fw' ),
                'menu_title'  => __( 'License Activation', 'yith-plugin-fw' ),
                'capability'  => 'manage_options',
                'page'        => 'yith_plugins_activation',
            );

            add_action( 'admin_menu', array( $this, 'add_submenu_page' ), 99 );
            add_action( "wp_ajax_yith_activate-{$this->_product_type}", array( $this, 'activate' ) );
            add_action( "wp_ajax_yith_deactivate-{$this->_product_type}", array( $this, 'deactivate' ) );
            add_action( "wp_ajax_yith_update_licence_information-{$this->_product_type}", array( $this, 'update_licence_information' ) );
            add_action( 'yit_licence_after_check', array( $this, 'licence_after_check' ) );
        }


        public function licence_after_check() {
            /* === Regenerate Update Plugins Transient === */
            YIT_Upgrade()->force_regenerate_update_transient();
        }

        /**
         * Main plugin Instance
         *
         * @static
         * @return object Main instance
         *
         * @since  1.0
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Add "Activation" submenu page under YITH Plugins
         *
         * @return void
         * @since  1.0
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function add_submenu_page() {
            add_submenu_page(
                $this->_settings['parent_page'],
                $this->_settings['page_title'],
                $this->_settings['menu_title'],
                $this->_settings['capability'],
                $this->_settings['page'],
                array( $this, 'show_activation_panel' )
            );
        }

        /**
         * Premium plugin registration
         *
         * @param $plugin_init | string | The plugin init file
         * @param $secret_key  | string | The product secret key
         * @param $product_id  | string | The plugin slug (product_id)
         *
         * @return void
         *
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function register( $plugin_init, $secret_key, $product_id ) {
            if ( !function_exists( 'get_plugins' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }

            $plugins                             = get_plugins();
            $plugins[$plugin_init]['secret_key'] = $secret_key;
            $plugins[$plugin_init]['product_id'] = $product_id;
            $this->_products[$plugin_init]       = $plugins[$plugin_init];
        }

        public function get_product_type() {
            return $this->_product_type;
        }
    }
}

/**
 * Main instance of plugin
 *
 * @return object
 * @since  1.0
 * @author Andrea Grillo <andrea.grillo@yithemes.com>
 */
if ( !function_exists( 'YIT_Plugin_Licence' ) ) {
    function YIT_Plugin_Licence() {
        return YIT_Plugin_Licence::instance();
    }
}