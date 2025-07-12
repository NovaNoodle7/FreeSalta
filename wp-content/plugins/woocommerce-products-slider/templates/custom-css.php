<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access  
	
	if(!empty($wcps_items_custom_css)){
		
		$html.= '<style type="text/css">'.$wcps_items_custom_css.'</style>';
	}
	








	$html.= '<style type="text/css">';

	$html.= '
	
	.wcps-container-'.$post_id.'{
		padding:'.$wcps_container_padding.';
		background: '.$wcps_container_bg_color.' url('.$wcps_bg_img.') repeat scroll 0 0;
	}
	';


	$html.= '
	#wcps-'.$post_id.' .wcps-items{
		padding:'.$wcps_items_padding.';
		background: '.$wcps_items_bg_color.' repeat scroll 0 0;
	}
	';



	$html.= '
	
	#wcps-'.$post_id.' .wcps-items .wcps-items-title{
		text-align:'.$wcps_items_title_text_align.';

		}
	';
	
	
	$html.= '
	
	#wcps-'.$post_id.' .wcps-items .wcps-items-excerpt, #wcps-'.$post_id.' .wcps-items .wcps-items-excerpt a{
		text-align:'.$wcps_items_excerpt_text_align.';
		font-size:'.$wcps_items_excerpt_font_size.';
		color:'.$wcps_items_excerpt_font_color.';		
		}
	';	



	$html.= '
	
	#wcps-'.$post_id.' .wcps-items .wcps-items-category, #wcps-'.$post_id.' .wcps-items .wcps-items-category a{
		font-size:'.$wcps_items_cat_font_size.';
		text-align:'.$wcps_items_cat_text_align.';
		color:'.$wcps_items_cat_font_color.';
		}
	';


$html.= '
	
	#wcps-'.$post_id.' .wcps-items .wcps-items-tag, #wcps-'.$post_id.' .wcps-items .wcps-items-tag a{
		font-size:'.$wcps_items_tag_font_size.';
		text-align:'.$wcps_items_tag_text_align.';
		color:'.$wcps_items_tag_font_color.';
		}
	';

$html.= '
	
	#wcps-'.$post_id.' .wcps-items .wcps-items-sku{
		font-size:'.$wcps_items_sku_font_size.';
		text-align:'.$wcps_items_sku_text_align.';
		color:'.$wcps_items_sku_font_color.';
		}
	';






	$html.= '
	
	#wcps-'.$post_id.' .wcps-items .wcps-items-price{
		font-size:'.$wcps_items_price_font_size.';
		text-align:'.$wcps_items_price_text_align.';
		}
	';		
	
	$html.= '
	
	#wcps-'.$post_id.' .wcps-items .wcps-items-cart{
		text-align:'.$wcps_cart_text_align.';
		}
	';
	
	$html.= '
	
	#wcps-'.$post_id.' .wcps-items .wcps-items-rating{
		font-size:'.$wcps_items_ratings_font_size.';
		text-align:'.$wcps_ratings_text_align.';
		color:'.$wcps_items_ratings_color.';		
		}
	';	
	


	if($wcps_slider_navigation_position == 'middle-fixed'){
		$html.= '.wcps-container {padding: 0 50px;}';		
		}
	
	if(!empty($wcps_items_thumb_max_hieght)){
		
		$html.= '.wcps-container #wcps-'.$post_id.' .wcps-items-thumb {max-height:'.$wcps_items_thumb_max_hieght.';}';
		
		}
		
	$html.= '</style>';	






	
	$html.= '<style type="text/css">
	.wcps-container #wcps-'.$post_id.' div.wcps-items-cart.custom a.add_to_cart_button,
	.wcps-container #wcps-'.$post_id.' div.wcps-items-cart.custom a.added_to_cart
		{
		 background: '.$wcps_cart_bg .';
		 color:'.$wcps_cart_text_color.';
		} 
		
	.wcps-container #wcps-'.$post_id.' div.owl-pagination span.owl-numbers
		{
		 background: '.$wcps_slider_pagination_bg .';
		 color:'.$wcps_slider_pagination_text_color.';
		}
		
	.wcps-container #wcps-'.$post_id.' .owl-controls .owl-page span
		{
		 background: '.$wcps_slider_pagination_bg .';
		}			
	</style>';