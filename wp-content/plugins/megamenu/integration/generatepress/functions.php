<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

/**
 * Append integration CSS
 */
function megamenu_generatepress_style($scss) {
    $path = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'style.scss';
    $contents = file_get_contents( $path );
    return $scss . $contents;
}
add_filter( 'megamenu_load_scss_file_contents', 'megamenu_generatepress_style', 9999 );