<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	if($wcps_ribbon_name=='custom'){
		$ribbon_url = $wcps_ribbon_custom;
		}
	else{
		$ribbon_url = wcps_plugin_url.'assets/front/images/ribbons/'.$wcps_ribbon_name.'.png';
		}
	

	$html_ribbon = '<div class="wcps-ribbon wcps-ribbon-'.$wcps_ribbon_name.'" style="background:url('.$ribbon_url.') no-repeat scroll 0 0 rgba(0, 0, 0, 0);)"></div>';
	
	$html.= apply_filters( 'wcps_filter_ribbon', $html_ribbon );