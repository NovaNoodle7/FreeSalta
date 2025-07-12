<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	
	$rating = $product->get_average_rating();
	$rating = (($rating/5)*100);
	
	 /*

	if( $rating > 0 ){
		$html .= '<div title="'.$rating.'%" class="wcps-items-rating">';
		$html .= '<div class="stars-list">
		<span class="star-length" style="width:'.($rating).'%">
		<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
		
		</span>
		<span class="stars">
		<i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
		</span>		
		</div>';
		$html .= '</div>';
		}


		
	 
	 
	 
 */
	if( $rating > 0 )
		$html .= '<div class="wcps-items-rating">
		
		<div class="rating-list">		
		<div class="pg-rating woocommerce">
		<div class="woocommerce-product-rating"><div class="star-rating" style="padding-bottom:10px;" title="'.__('Rated', 'woocommerce-products-slider').' '.$rating.'"><span style="width:'.$rating.'%;"></span></div></div>
		</div>		
		</div>
		</div>';
	

	


	
	
	
	
	
	
	
	
	