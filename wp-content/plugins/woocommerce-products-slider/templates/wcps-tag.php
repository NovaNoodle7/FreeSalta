<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access  
	
	$product_cats = wp_get_post_terms( get_the_ID(), 'product_tag' );
	$cat_link = array();
	$cat_name = array();

    $cat_html = '';

    if(!empty($product_cats))
	foreach($product_cats as $key => $cat){
		
		$cat_link = get_term_link( $cat->term_id, 'product_cat' );					
		$cat_name = $cat->name;
			
		$cat_html.= '<a href="'.$cat_link.'">'.$cat_name.'</a>, ';
		}
		
	$html.= '<div class="wcps-items-tag" >'.$cat_html.'</div>';