<?php

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	

class class_wcps_shortcodes{
	
	
    public function __construct(){
		
		add_shortcode( 'wcps', array( $this, 'wcps_display' ) );

   		}
	
	public function wcps_display($atts, $content = null ) {
			$atts = shortcode_atts(
				array(
					'id' => "",
	
					), $atts);
	
				$html = '';
				$post_id = $atts['id'];



				include wcps_plugin_dir.'/templates/variables.php';
				include wcps_plugin_dir.'/templates/custom-css.php';
				
				include wcps_plugin_dir.'/templates/query.php';

				//$class_wcps_functions = new class_wcps_functions();
				///$wcps_themes_dir = $class_wcps_functions->wcps_themes_dir();
				//$wcps_themes_url = $class_wcps_functions->wcps_themes_url();

				//$html.= '<link  type="text/css" media="all" rel="stylesheet"  href="'.$wcps_themes_url[$wcps_themes].'/style.css" >';				

				$html.= '<div  class="wcps-container wcps-container-'.$post_id.' '.$wcps_is_mobile.' " style="background-image:url('.$wcps_bg_img.')">';
				include wcps_plugin_dir.'/templates/wcps-ribbon.php';
				$html.= '<div  id="wcps-'.$post_id.'" class="owl-carousel ">';
			



				if ( $wp_query->have_posts() ) :
				
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
				
				
					$product_visibility = wp_get_post_terms( get_the_ID(), 'product_visibility' );
					//if(!empty($product_visibility->slug))
					//$is_featured = $product_visibility->slug;
					$product_is_featured = 'no';
					
					if(!empty($product_visibility)){
						
						foreach($product_visibility as $visibility){
							
							$is_featured = $visibility->slug;
							
							if($is_featured=='featured'){
								
								$product_is_featured = 'yes';
								//echo '<pre>'.var_export($_featured, true).'</pre>';
								}
							
							
							}
						
						}
				
				
				
				
				
				
				global $product;

                $sku = $product->get_sku();

                //echo var_export($sku, true);


				$wcps_featured = get_post_meta( get_the_ID(), '_featured', true );
				
				$wcps_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $wcps_items_thumb_size );
				$wcps_thumb_url = $wcps_thumb['0'];
				
				if(empty($wcps_thumb_url)){
						$wcps_thumb_url = $wcps_items_empty_thumb;
					}
			
				
				
				$currency = get_woocommerce_currency_symbol();
				
				$sale_price = get_post_meta( get_the_ID(), '_sale_price', true);
				
				if($wcps_items_price_format=='full'){
						$price = $product->get_price_html();	
					}
				elseif($wcps_items_price_format=='sale'){
			
						$price= $currency.get_post_meta( get_the_ID(), '_sale_price', true);
					}
				elseif($wcps_items_price_format=='regular'){
						$price = $currency.get_post_meta( get_the_ID(), '_regular_price', true);
					}
				else{
						$price = $product->get_price_html();
					}
			
			
				if($wcps_items_thumb_link_to == 'product'){
						$permalink = get_permalink();
					}
				else if($wcps_items_thumb_link_to == 'category'){
						
						if(empty($cat_link[0])){
							$permalink = get_permalink();
							}
						else{
							$permalink = $cat_link[0];
							}
					}
				else{
						$permalink = get_permalink();
					}
			
				$html.= '<div class="wcps-items skin '.$wcps_themes.'" >';
					include wcps_plugin_dir.'/templates/layer-media.php';
					include wcps_plugin_dir.'/templates/layer-content.php';
					
					$html_zoom = apply_filters( 'wcps_filter_zoom', '<i class="fa fa-search-plus"></i>' );
					
					if($wcps_items_thumb_zoom=='yes'){
						$html.= '<div class="wcps-zoom" slider-id="'.$post_id.'" product-id="'.get_the_ID().'">'.$html_zoom.'</div>';
						}
					
					
					
				$html.= '</div>'; // .wcps-items
			
			
/*

				$html.= '<div class="wcps-items" >';
				
				foreach($wcps_grid_items as $item_key=>$item){
					
					if(empty($wcps_grid_items_hide[$item_key])){
						include wcps_plugin_dir.'/templates/wcps-'.$item_key.'.php';
						}
			
					}
			
				$html.= '</div>'; // .wcps-items

*/
				
				
				endwhile;
				wp_reset_query();
				
				else :
					$html.= __('No Product to Slide','woocommerce-products-slider');
			
				endif;



	
				
				$html.=  '</div>';
						
				if($wcps_items_thumb_zoom=='yes'){
					include wcps_plugin_dir.'/templates/wcps-zoom.php';
					}		
						
				
				
				$html.=  '</div>';				
						
				include wcps_plugin_dir.'/templates/scripts.php';
	
	
	
				return $html;
	
	
		}
			
	
		
	}

new class_wcps_shortcodes();