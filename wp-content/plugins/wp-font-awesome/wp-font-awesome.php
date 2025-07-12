<?php
   /*
   Plugin Name: WP Font Awesome
   Plugin URI: https://wordpress.org/plugins/wp-font-awesome/
   Description: This plugin allows the easily embed Font Awesome to your site.
   Version: 1.5
   Author: Zayed Baloch
   Author URI: http://www.zayed.xyz/
   License: GPL2
   */

defined('ABSPATH') or die("No script kiddies please!");
define( 'ZB_FAWE_VERSION',   '1.5' );
define( 'ZB_FAWE_URL', plugins_url( '', __FILE__ ) );
define( 'ZB_FAWE_TEXTDOMAIN',  'zb_font_awesome' );

function zb_wp_font_awesome() {
  load_plugin_textdomain( ZB_FAWE_TEXTDOMAIN );
}
add_action( 'init', 'zb_wp_font_awesome' );

function wp_font_awesome_style() {
  wp_register_style('fontawesome-css', ZB_FAWE_URL . '/font-awesome/css/font-awesome.min.css', array(), ZB_FAWE_VERSION);
  wp_enqueue_style('fontawesome-css');
}
add_action('wp_enqueue_scripts', 'wp_font_awesome_style');

function wp_fa_shortcode( $atts ) {
  extract( shortcode_atts( array( 'icon' => 'home', 'size' => '' ), $atts ) );
  if ( $size ) { $size = ' fa-'.$size; }
    else{ $size = ''; }
  return '<i class="fa fa-'.str_replace('fa-','',$icon). $size.'"></i>';
}

add_shortcode( 'wpfa', 'wp_fa_shortcode' );
add_filter('wp_nav_menu_items', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');

function wpfa_add_shortcode_to_title( $title ){
  return do_shortcode($title);
}
add_filter( 'the_title', 'wpfa_add_shortcode_to_title' );