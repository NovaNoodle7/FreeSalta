<?php
/**
* Plugin Name: App Links
* Plugin URI: https://applinks.com
* Description: This plugin adds a widget that shows links to your app in the sidebar.
* Version: 1.0.0
* Author: Cristian Gonzalez
* Author URI: http://saltatech.com
*/
 
/**
 * Función que instancia el Widget
 */
function applinks_create_widget(){    
    include_once(plugin_dir_path( __FILE__ ).'/includes/applinks_widget.php');
    register_widget('applinks_widget');
}
add_action('widgets_init','applinks_create_widget'); 