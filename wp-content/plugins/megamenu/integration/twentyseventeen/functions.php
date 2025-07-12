<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

/**
 * Append integration CSS
 */
function megamenu_twentyseventeen_style($scss) {
    $path = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'style.scss';
    $contents = file_get_contents( $path );
    return $scss . $contents;
}
add_filter( 'megamenu_load_scss_file_contents', 'megamenu_twentyseventeen_style', 9999 );


/**
 * TwentySeventeen JavaScript helper
 */
function megamenu_twentyseventeen_script() {
    wp_enqueue_script( "megamenu-twentyseventeen", plugins_url( 'script.js' , __FILE__ ), array('megamenu'), MEGAMENU_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'megamenu_twentyseventeen_script', 999 );


/**
 * Restore menu-item class on menu items. Required for the sticky menu to work.
 */
function megamenu_twentyseventeen_add_menu_item_class($classes) {
    $classes[] = 'menu-item';
    return $classes;
}
add_filter( 'megamenu_nav_menu_css_class', 'megamenu_twentyseventeen_add_menu_item_class', 9999 );
