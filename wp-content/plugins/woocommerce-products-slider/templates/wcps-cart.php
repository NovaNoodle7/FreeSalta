<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access  
	
	$html_cart = apply_filters( 'wcps_filter_cart', do_shortcode('[add_to_cart id="'.get_the_ID().'"]') );
	
	$html.= '<div class="wcps-items-cart '.$wcps_cart_style.'">'.$html_cart.'</div>';