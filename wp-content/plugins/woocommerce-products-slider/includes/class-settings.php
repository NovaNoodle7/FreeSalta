<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	

class class_wcps_settings{
	
	public function __construct(){

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );

    }
	
	
	public function admin_menu() {

		add_submenu_page('edit.php?post_type=wcps', __('Settings','woocommerce-products-slider'), __('Settings','woocommerce-products-slider'), 'manage_options', 'wcps_menu_settings', array( $this, 'settings_page' ));


	}
	
	public function settings_page(){
		
		include( 'menu/settings.php' );	
		
		}
	
		
	}

	new class_wcps_settings();