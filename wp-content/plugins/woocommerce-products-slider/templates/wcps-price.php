<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	$price_text = apply_filters( 'wcps_filter_price', $price );
	
	$html.= '<div class="wcps-items-price" style="color:'.$wcps_items_price_color.';font-size:'.$wcps_items_price_font_size.'">'.$price_text .'</div>';