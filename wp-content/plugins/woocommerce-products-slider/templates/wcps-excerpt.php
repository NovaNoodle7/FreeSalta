<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	
	//global $post;
	$excerpt_text = wp_trim_words( get_the_excerpt() , $wcps_items_excerpt_count, ' <a class="read-more" href="'.get_permalink(get_the_ID()).'"> '.$wcps_items_excerpt_read_more.'</a>' );
	//$excerpt_text = wp_trim_words( $post->post_excerpt , $wcps_items_excerpt_count, ' <a class="read-more" href="'.get_permalink(get_the_ID()).'"> '.$wcps_items_excerpt_read_more.'</a>' );
	
	$excerpt_text = apply_filters( 'wcps_filter_excerpt', $excerpt_text );
	
	$html.= '<div class="wcps-items-excerpt" >'.$excerpt_text.'</div>';