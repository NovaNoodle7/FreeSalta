<?php
/**
 * Plugin Name: WooCommerce Shortcodes
 * Plugin URI: https://www.woothemes.com/
 * Description: WooCommerce Shortcodes.
 * Version: 1.0.0
 * Author: WooThemes, Claudio Sanches
 * Author URI: http://woothemes.com
 * Text Domain: woocommerce-shortcodes
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce_Shortcodes' ) ) :

/**
 * WooCommerce Shortcodes main class.
 */
class WooCommerce_Shortcodes {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Checks with WooCommerce is installed.
		if ( class_exists( 'WooCommerce' ) ) {

			// Admin classes.
			if ( is_admin() ) {
				$this->admin_includes();
			}

		} else {
			add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-shortcodes' );

		load_textdomain( 'woocommerce-shortcodes', trailingslashit( WP_LANG_DIR ) . 'woocommerce-shortcodes/woocommerce-shortcodes-' . $locale . '.mo' );
		load_plugin_textdomain( 'woocommerce-shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Admin includes.
	 *
	 * @return void
	 */
	public function admin_includes() {
		require_once 'includes/class-wc-shortcodes-admin.php';
	}

	/**
	 * WooCommerce fallback notice.
	 *
	 * @return string
	 */
	public function woocommerce_missing_notice() {
		echo '<div class="error"><p>' . sprintf( __( 'WooCommerce Shortcodes depends on the last version of %s to work!', 'woocommerce-shortcodes' ), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">' . __( 'WooCommerce', 'woocommerce-shortcodes' ) . '</a>' ) . '</p></div>';
	}

}

add_action( 'plugins_loaded', array( 'WooCommerce_Shortcodes', 'get_instance' ), 0 );

endif;
