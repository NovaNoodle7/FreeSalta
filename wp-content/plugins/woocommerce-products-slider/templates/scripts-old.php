<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access  


	$html.= '<script>
	jQuery(document).ready(function($)
	{
		$("#wcps-'.$post_id.'").owlCarousel({
			
			items : '.$wcps_column_number.', //10 items above 1000px browser width
			itemsDesktop : [1000,'.$wcps_column_number.'], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,'.$wcps_column_number_tablet.'], // betweem 900px and 601px
			itemsTablet: [600,'.$wcps_column_number_tablet.'], //2 items between 600 and 0
			itemsMobile : [479,'.$wcps_column_number_mobile.'], 
			navigationText : ["",""],
			';
			
		
	if($wcps_auto_play=="true")
		{
			
	$html.= 'autoPlay: '.$wcps_auto_play.',';
	
		}	
	
	if($wcps_stop_on_hover=="true")
		{
			
	$html.= 'stopOnHover: '.$wcps_stop_on_hover.',';
	
		}				
			
	if($wcps_slider_navigation=="true")
		{
			
	$html.= 'navigation: '.$wcps_slider_navigation.',';
	
		}				
			
	if(($wcps_slider_pagination=="true"))
		{
			
	$html.= 'pagination: '.$wcps_slider_pagination.',';
	
		}
	else
		{
		$html.= 'pagination: false,';
		}
			
			
	if(($wcps_slider_pagination_count=="true"))
		{
			
	$html.= 'paginationNumbers: true,';
	
		}
	else
		{
		$html.= 'paginationNumbers: false,';
		}				
			
			
			
	if(!empty($wcps_slide_speed))
		{
			
	$html.= 'slideSpeed: '.$wcps_slide_speed.',';
	
		}
		
			
	if(!empty($wcps_pagination_slide_speed))
		{
			
	$html.= 'paginationSpeed: '.$wcps_pagination_slide_speed.',';
	
		}			
		
		
	if(($wcps_slider_touch_drag=="true"))
		{
			
	$html.= 'touchDrag : true,';
	
		}			
	else
		{
		$html.= 'touchDrag: false,';
		}
		
		
		
	if(($wcps_slider_mouse_drag=="true" ))
		{
			
	$html.= 'mouseDrag  : true,';
	
		}			
	else
		{
		$html.= 'mouseDrag : false,';
		}			
		
		
		
		
						
			
			
			
	$html.= '});
	
	});';
	
	
	if($wcps_slider_navigation_position == 'topright')
		{
			$html.=  'jQuery(document).ready(function($)
			{
				$(".owl-buttons").addClass("topright");
				
				
			})';
		}
	elseif($wcps_slider_navigation_position == 'middle')
		{
			$html.=  'jQuery(document).ready(function($)
			{
				$(".owl-buttons").addClass("middle");
				
				
			})';	
		}
	elseif($wcps_slider_navigation_position == 'middle-fixed')
		{
			$html.=  'jQuery(document).ready(function($)
			{
				$(".owl-buttons").addClass("middle-fixed");
							
				
				
			})';	
		}
	
	$html.=  '</script>';