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
			
			items : '.$wcps_column_number.',


			responsiveClass:true,
			
			responsive:{
				0:{
					items:'.$wcps_column_number_mobile.',
					
				},
				600:{
					items:'.$wcps_column_number_tablet.',
					
				},
				
				900:{
					items:'.$wcps_column_number_tablet.',
					
				},				
				
				1000:{
					items:'.$wcps_column_number.',
					
					
				}
			},



			
			';
			
	//var_dump($wcps_auto_play);
	
			$html.= 'loop: '.$wcps_loop.',';
			$html.= 'rewind: '.$wcps_rewind.',';
			$html.= 'center: '.$wcps_center.',';
			$html.= 'rtl: '.$wcps_slider_rtl.',';
			$html.= 'animateOut: "'.$wcps_slider_animateout.'",';	
			$html.= 'animateIn: "'.$wcps_slider_animatein.'",';						
							

	if($wcps_auto_play=="true")
		{
			
				
		$html.= 'autoplay: true,';
		//$html.= 'autoplayTimeout: 500,';
		$html.= 'autoplayHoverPause: '.$wcps_stop_on_hover.',';
        $html.= 'autoplaySpeed: '.$wcps_auto_play_speed.',';
        $html.= 'autoplayTimeout: '.$wcps_auto_play_timeout.',';

		}	
	
				
			
	if($wcps_slider_navigation=="true"){
			
		$html.= '
		navText : ["",""],
		nav: true,';
	
		}	
			
			
	if(($wcps_slider_pagination=="true")){
			
		$html.= 'dots: true,';
	
		}
	else{
		$html.= 'dots: false,';
		}
			
	if(!empty($wcps_slide_speed)){
			
		$html.= 'navSpeed: '.$wcps_slide_speed.',';
	
		}	


	if(!empty($wcps_pagination_slide_speed)){
			
		$html.= 'dotsSpeed: '.$wcps_pagination_slide_speed.',';
	
		}	
			
			
	if(($wcps_slider_touch_drag=="true")){
			
		$html.= 'touchDrag : true,';
	
		}			
	else
		{
		$html.= 'touchDrag: false,';
		}	
			
			
			
	if(($wcps_slider_mouse_drag=="true" )){
			
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
				$(".owl-nav").addClass("topright");
				
				
			})';
		}
	elseif($wcps_slider_navigation_position == 'middle')
		{
			$html.=  'jQuery(document).ready(function($)
			{
				$(".owl-nav").addClass("middle");
				
				
			})';	
		}
	elseif($wcps_slider_navigation_position == 'middle-fixed')
		{
			$html.=  'jQuery(document).ready(function($)
			{
				$(".owl-nav").addClass("middle-fixed");
							
				
				
			})';	
		}
	
	$html.=  '</script>';






if($wcps_slider_navigation_position == 'topright') {

	$html.=  '<style>

.wcps-container .owl-carousel {
    padding-top: 60px;
}

</style>';

}














