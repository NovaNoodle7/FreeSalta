<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

global $post;

extract( $args );

if ( empty( $value ) || ! is_array( $value ) )
    $value = array();
    
//$categories = yit_get_model('cpt_unlimited')->get_setting( 'categories', $post->ID );
?>
<div id="<?php echo $id ?>-container" <?php if ( isset($deps) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?>>
<label for="<?php echo $id ?>"><?php echo $label ?></label>
<span class="desc inline"><?php echo $desc ?></span>  
<ul id="<?php echo $id ?>-extra-images" class="slides-wrapper extra-images ui-sortable clearfix" style="">
    <?php if ( ! empty( $value ) ) : foreach ( $value as $image_id ) : ?>
    <li>
        <a href="#">
            <?php
            if( function_exists( 'yit_image' ) ) :
                yit_image( "id=$image_id&size=admin-post-type-thumbnails" );
            else:
                echo wp_get_attachment_image( $image_id, array( 80, 80 ) );
            endif; ?>
            <input type="hidden" name="<?php echo $name ?>[]" value="<?php echo esc_attr( $image_id ) ?>" />
        </a>
        <a href="#" title="<?php _e( 'Delete image', 'yith-plugin-fw' ) ?>" class="delete">X</a>
    </li>   
    <?php endforeach; endif; ?>
</ul>         
<a href="#" class="button-secondary upload-extra-images" id="<?php echo $id ?>-upload-extra-images"><?php _e( 'Upload new images', 'yith-plugin-fw' ) ?></a>    
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#<?php echo $id ?>-upload-extra-images').on( 'click', function(){
            tb_show('', 'media-upload.php?post_id=0&TB_iframe=1&width=700');
            
            window.send_to_editor = function(html) {
                
                var imgurl = $('a', '<div>' + html + '</div>').attr('href');
                var image_id = $('img', html).attr('class').replace(/(.*?)wp-image-/, '');   
        
            	var data = {
            		action: 'generate_preview_image_post_type',
            		item_id: image_id
            	};
            	
            	$.post(ajaxurl, data, function(response) {
            	    var thumburl = imgurl.split('.').reverse();
                    var baseurl = imgurl.replace( '.' + thumburl[0], '' );
                    thumburl = baseurl + '-140x100.' + thumburl[0];

                    $('#<?php echo $id ?>-extra-images.slides-wrapper').append('<li><a href="#"><img src="'+thumburl+'" width="140" height="100" /> <input type="hidden" name="<?php echo $name ?>[]" value="'+image_id+'" /></a><a href="#" title="<?php echo addslashes( __( 'Delete image', 'yith-plugin-fw' ) ) ?>" class="delete">X</a></li>');
                });
            	
            	tb_remove();
                
            }  
            
            return false;
        });    
        
        $('#<?php echo $id ?>-extra-images a.delete').on( 'click', function(){ 
            if ( confirm( "<?php _e( 'Are you sure you want to remove this image?', 'yith-plugin-fw' ) ?>" ) ) {
                $(this).parent().remove();    
            }
            
            return false;
        });                    
       
        // SORTABLE
        $('#<?php echo $id ?>-extra-images').sortable({
            axis: 'x',
            stop: function(e, ui) {}
        }); 
        
        $('.extra-images a:not(.delete)').click(function(){ return false; });
    });
</script>