<?php	

/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



	if(empty($_POST['wcps_hidden']))
		{
		
			$wcps_track_product_view = get_option( 'wcps_track_product_view' );
			
			
			
		}
	else
		{
					
				
		if($_POST['wcps_hidden'] == 'Y') {
			//Form data sent


			$wcps_track_product_view = sanitize_text_field($_POST['wcps_track_product_view']);
			update_option('wcps_track_product_view', $wcps_track_product_view);
			
		
			
					

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.','woocommerce-products-slider' ); ?></strong></p></div>

			<?php
		} 
	}
	

	
	
	
	
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".wcps_plugin_name.' '.__(' Settings','woocommerce-products-slider')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="wcps_hidden" value="Y">
        <?php settings_fields( 'wcps_plugin_options' );
				do_settings_sections( 'wcps_plugin_options' );
			
		?>
        
        
	<div class="para-settings">
        <ul class="tab-nav">
            <li nav="1" class="nav1 active"><i class="fa fa-cogs"></i> <?php _e('Options','woocommerce-products-slider'); ?></li>
            <li nav="2" class="nav2"><i class="fa fa-hand-o-right"></i> <?php _e('Help','woocommerce-products-slider'); ?></li>
        </ul> <!-- tab-nav end -->
    
		<ul class="box">
            
            
            <li style="display: block;" class="box1 tab-box active">
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Track product View','woocommerce-products-slider'); ?></p>
                    <p class="option-info"></p>

                    <select name="wcps_track_product_view"  >
                        <option value="no" <?php if($wcps_track_product_view=="no")echo "selected"; ?>><?php _e('No','woocommerce-products-slider'); ?></option>
                        <option value="yes" <?php if($wcps_track_product_view=="yes")echo "selected"; ?>><?php _e('Yes','woocommerce-products-slider'); ?></option>
                                        
                  
                    </select> 

                </div>
                
                
            </li>           
            
            <li style="display: none;" class="box2 tab-box">
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Need Help ?','woocommerce-products-slider'); ?></p>
                    <p class="option-info">
                    <?php _e('Feel free to contact with any issue for this plugin, Ask any question via forum','woocommerce-products-slider'); ?> <a href="<?php echo wcps_qa_url; ?>"><?php echo wcps_qa_url; ?></a> <strong style="color:#139b50;"><?php _e('(free)','woocommerce-products-slider'); ?></strong><br />

    <?php

    if(wcps_customer_type=="free")
        {
    		
			_e(sprintf('You are using <strong>%s version %s </strong> of <strong>%s</strong> To get more feature you could try our premium version.',wcps_customer_type, wcps_plugin_version, wcps_plugin_name),'woocommerce-products-slider');
			
           // echo 'You are using <strong> '.wcps_customer_type.' version  '.wcps_plugin_version.'</strong> of <strong>'.wcps_plugin_name.'</strong>, To get more feature you could try our premium version. ';
            
            echo '<br /><a href="'.wcps_pro_url.'">'.wcps_pro_url.'</a>';
            
        }
    else
        {
    		_e(sprintf('Thanks for using <strong> premium version %s </strong> of <strong>%s</strong>.', wcps_plugin_version, wcps_plugin_name),'woocommerce-products-slider');
            //echo 'Thanks for using <strong> premium version  '.wcps_plugin_version.'</strong> of <strong>'.wcps_plugin_name.'</strong> ';	
            
            
        }
    
     ?>       

                    
                    </p>

                </div>
				<div class="option-box">
                    <p class="option-title"><?php _e('Submit Reviews.','woocommerce-products-slider'); ?></p>
                    <p class="option-info">
					<?php _e('We are working hard to build some awesome plugins for you and spend thousand hour for plugins. we wish your three(3) minute by submitting five star reviews at wordpress.org. if you have any issue please submit at forum','woocommerce-products-slider'); ?>
                    .</p>
                	<img src="<?php echo wcps_plugin_url."assets/admin/images/five-star.png";?>" /><br />
                    <a target="_blank" href="<?php echo wcps_wp_reviews; ?>">
                		<?php echo wcps_wp_reviews; ?>
               		</a>
                    
                    
                    
                </div>
				<div class="option-box">
                    <p class="option-title"><?php _e('Please Share','woocommerce-products-slider'); ?></p>
                    <p class="option-info"><?php _e('If you like this plugin please share with your social share network.','woocommerce-products-slider'); ?></p>
                    <?php
                    
						echo wcps_share_plugin();
					?>
                </div>
            
            </li>  

        </ul>
    
    
    
    </div>    




<p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
                </p>
		</form>


</div>
