<?php
/*
Plugin Name: Woocommerce Products Slider
Plugin URI: http://pickplugins.com/items/woocommerce-product-slider-for-wordpress/
Description: Fully responsive and mobile ready Carousel Slider for your woo-commerce product. unlimited slider anywhere via short-codes and easy admin setting.
Version: 1.12.17
Author: pickplugins
Author URI: http://pickplugins.com
Text Domain: woocommerce-products-slider
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class WoocommerceProductsSlider{
	
	public function __construct(){
		
		define('wcps_plugin_url', plugins_url('/', __FILE__)  );
		define('wcps_plugin_dir', plugin_dir_path( __FILE__ ) );
		define('wcps_wp_url', 'https://wordpress.org/plugins/woocommerce-products-slider/' );
		define('wcps_wp_reviews', 'http://wordpress.org/support/view/plugin-reviews/woocommerce-products-slider' );
		define('wcps_pro_url','http://www.pickplugins.com/item/woocommerce-products-slider-for-wordpress/' );
		define('wcps_demo_url', 'http://pickplugins.com/demo/woocommerce-products-slider/' );
		define('wcps_conatct_url', 'http://pickplugins.com/contact/' );
		define('wcps_qa_url', 'https://www.pickplugins.com/support/' );
		define('wcps_plugin_name', 'Woocommerce Products Slider' );
		define('wcps_plugin_version', '1.12.17' );
		define('wcps_customer_type', 'free' );	 // pro & free	
		define('wcps_share_url', 'https://wordpress.org/plugins/woocommerce-products-slider/' );
		define('wcps_tutorial_video_url', '' );

		require_once( plugin_dir_path( __FILE__ ) . 'includes/meta.php');
		require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php');
		
		require_once( plugin_dir_path( __FILE__ ) . 'includes/class-functions.php');
		require_once( plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes.php');
		require_once( plugin_dir_path( __FILE__ ) . 'includes/class-settings.php');	
		require_once( plugin_dir_path( __FILE__ ) . 'includes/class-update.php');				
						
		
		// to work upload button
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' ); 
		 
		//shoer-code support into sidebar.
		add_filter('widget_text', 'do_shortcode'); 
		
		add_action( 'wp_enqueue_scripts', array( $this, 'wcps_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'wcps_admin_scripts' ) );
		
		add_action( 'plugins_loaded', array( $this, 'wcps_load_textdomain' ));
		
		
		register_activation_hook( __FILE__, array( $this, 'wcps_install' ) );
		register_deactivation_hook( __FILE__, array( $this, 'wcps_uninstall' ) );
		
		
		}
		
		
		
	public function wcps_load_textdomain() {
	  load_plugin_textdomain( 'woocommerce-products-slider', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}
		
		
		
		
		
		
	public function wcps_install(){
		
		
		do_action( 'wcps_action_install' );
		
		}		
		
	public function wcps_uninstall(){
		
		do_action( 'wcps_action_uninstall' );
		}		
		
	public function wcps_deactivation(){
		
		do_action( 'wcps_action_deactivation' );
		}
		
	public function wcps_front_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('wcps_js', plugins_url( '/assets/front/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script('wcps_js', 'wcps_ajax', array( 'wcps_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		wp_enqueue_style('wcps_style', wcps_plugin_url.'assets/front/css/style.css');
		wp_enqueue_style('wcps_style.themes', wcps_plugin_url.'assets/global/css/style.themes.css');		
		wp_enqueue_style('font-awesome', wcps_plugin_url.'assets/global/css/font-awesome.css');
		//wp_enqueue_script('owl.carousel', plugins_url( '/assets/front/js/owl.carousel.js' , __FILE__ ) , array( 'jquery' ));
		//wp_enqueue_style('owl.carousel', wcps_plugin_url.'assets/front/css/owl.carousel.css');
		//wp_enqueue_style('owl.theme', wcps_plugin_url.'assets/front/css/owl.theme.css');
		
		wp_enqueue_script('owl.carousel.min', plugins_url( '/assets/front/js/owl.carousel.min.js' , __FILE__ ) , array( 'jquery' ));		
		
		wp_enqueue_style('owl.carousel', wcps_plugin_url.'assets/front/css/owl.carousel.css');
		
		
		
		
		
		
		}
		
	public function wcps_admin_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('wcps_admin_js', plugins_url( '/assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script('wcps_admin_js', 'wcps_ajax', array( 'wcps_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		wp_enqueue_style('font-awesome', wcps_plugin_url.'assets/global/css/font-awesome.css');
		wp_enqueue_style('wcps_style', wcps_plugin_url.'assets/admin/css/style.css');
		
		//ParaAdmin
		wp_enqueue_style('ParaAdmin', wcps_plugin_url.'assets/admin/ParaAdmin/css/ParaAdmin.css');	
		wp_enqueue_script('ParaAdmin', plugins_url( 'assets/admin/ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));
		
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wcps_color_picker', plugins_url('assets/admin/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
		}
	
	}

	new WoocommerceProductsSlider();

