<?php

if( !defined( 'ABSPATH' ) )
    exit;

if( !function_exists( 'yith_wcfav_locate_template' ) ) {
    /**
     * Locate the templates and return the path of the file found
     *
     * @param string $path
     * @param array $var
     * @return void
     * @since 1.0.0
     */
    function yith_wcfav_locate_template( $path, $var = NULL ){
        global $woocommerce;

        if( function_exists( 'WC' ) ){
            $woocommerce_base = WC()->template_path();
        }
        elseif( defined( 'WC_TEMPLATE_PATH' ) ){
            $woocommerce_base = WC_TEMPLATE_PATH;
        }
        else{
            $woocommerce_base = $woocommerce->plugin_path() . '/templates/';
        }

        $template_woocommerce_path =  $woocommerce_base . $path;
        $template_path = '/' . $path;
        $plugin_path = YWCFAV_TEMPLATE_PATH . '/' . $path;

        $located = locate_template( array(
            $template_woocommerce_path, // Search in <theme>/woocommerce/
            $template_path,             // Search in <theme>/
        ) );

        if( ! $located && file_exists( $plugin_path ) ){
            return apply_filters( 'yith_wcfav_locate_template', $plugin_path, $path );
        }

        return apply_filters( 'yith_wcfav_locate_template', $located, $path );
    }
}

if( !function_exists( 'yith_wcfav_get_template' ) ) {
    /**
     * Retrieve a template file.
     *
     * @param string $path
     * @param mixed $var
     * @param bool $return
     * @return void
     * @since 1.0.0
     */
    function yith_wcfav_get_template( $path, $var = null, $return = false ) {
        $located = yith_wcfav_locate_template( $path, $var );


        if ( $var && is_array( $var ) )
            extract( $var );

        if( $return )
        { ob_start(); }

        // include file located
        include( $located );

        if( $return )
        { return ob_get_clean(); }
    }
}

if( !function_exists( 'ywcfav_video_type_by_url' ) ) {
    /**
     * Retrieve the type of video, by url
     *
     * @param string $url The video's url
     * @return mixed A string format like this: "type:ID". Return FALSE, if the url isn't a valid video url.
     *
     * @since 1.1.0
     */
    function ywcfav_video_type_by_url($url)
    {

        $parsed = parse_url(esc_url($url));

        switch( $parsed['host'] ) {

            case 'www.youtube.com' :
            case    'youtu.be':
                $id = ywcfav_get_yt_video_id($url);
                return "youtube:$id";

            case 'vimeo.com' :
            case 'player.vimeo.com' :
                preg_match('/.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/', $url, $matches);
                $id = $matches[5];
                return "vimeo:$id";

            default :
                return apply_filters('yith_woocommerce_featured_video_type', false, $url);

        }
    }
}
if( !function_exists( 'ywcfav_get_yt_video_id' ) ) {
    /**
     * Retrieve the id video from youtube url
     *
     * @param string $url The video's url
     * @return string The youtube id video
     *
     * @since 1.1.0
     */
    function ywcfav_get_yt_video_id($url)
    {

        $pattern =
            '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';
        $result = preg_match($pattern, $url, $matches);
        if (false !== $result) {
            return $matches[1];
        }
        return false;
    }
}