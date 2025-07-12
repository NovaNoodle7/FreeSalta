<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	

class class_wcps_functions  {
	
	
    public function __construct(){

		}
		
		
		
	public function skins(){
		
		$skins = array(
		
						'flat'=> array(
										'slug'=>'flat',									
										'name'=>'Flat',
										'thumb_url'=>'',
										),		

						'zoomin'=>array(
										'slug'=>'zoomin',
										'name'=>'ZoomIn',
										'thumb_url'=>'',
										),							

						'spinleft'=>array(
										'slug'=>'spinleft',
										'name'=>'SpinLeft',
										'thumb_url'=>'',
										),

						'contentbottom'=>array(
										'slug'=>'contentbottom',
										'name'=>'ContentBottom',
										'thumb_url'=>'',
										),
																								
					
						
						);
		
		$skins = apply_filters('post_grid_filter_skins', $skins);	
		
		return $skins;
		
		}
		

		
	public function wcps_grid_items($grid_items = array()){
		
			$grid_items = array(
							'thumb'=>__('Thumbnail','woocommerce-products-slider'),
							'title'=>__('Title','woocommerce-products-slider'),
							'excerpt'=>__('Excerpt','woocommerce-products-slider'),
							'category'=>__('Category','woocommerce-products-slider'),
                            'tag'=>__('Tags','woocommerce-products-slider'),
							'price'=>__('Price','woocommerce-products-slider'),
							'rating'=>__('Rating','woocommerce-products-slider'),
							'cart'=>__('Cart','woocommerce-products-slider'),
							'sale'=>__('Sale','woocommerce-products-slider'),
							'featured'=>__('Featured', 'woocommerce-products-slider'),
                            'sku'=>__('SKU', 'woocommerce-products-slider'),
							);
			return $grid_items;
		}		
		
		
		
		
		
		
		
	
}