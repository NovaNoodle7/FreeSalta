<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	if(empty($wcps_sale_icon_url)){
		$wcps_sale_style = '';
		}
	else{
		$wcps_sale_style = 'style="background-image: url('.$wcps_sale_icon_url.');"';
		}
	
	if(!empty($sale_price))
		{
		$html.= '<div '.$wcps_sale_style.' title="'.__('Sale Product', 'woocommerce-products-slider').'" class="wcps-items-sale"></div>';
		}