<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	

	$html.='<div class="layer-media">';
	
		foreach($wcps_grid_items as $item_key=>$item){
			if(empty($wcps_grid_items_hide[$item_key])){
				
				if($item_key=='thumb')
				include wcps_plugin_dir.'/templates/wcps-'.$item_key.'.php';
				}
			}

		//include wcps_plugin_dir.'/templates/wcps-thumb.php';
	$html.='</div>';