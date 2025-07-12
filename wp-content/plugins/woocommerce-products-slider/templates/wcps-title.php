<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	

	
	$title_text = apply_filters( 'wcps_filter_title', get_the_title(get_the_ID()) );
	
	$html.= '<div class="wcps-items-title" ><a style="color:'.$wcps_items_title_color.';font-size:'.$wcps_items_title_font_size.'" href="'.$permalink.'">'.$title_text.'</a></div>';