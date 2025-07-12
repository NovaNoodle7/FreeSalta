<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



    $sku = apply_filters( 'wcps_filter_sku', $sku );
	
	$html.= '<div class="wcps-items-sku" >'.$sku.'</div>';