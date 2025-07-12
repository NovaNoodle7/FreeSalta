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

$categories = yit_get_model('cpt_unlimited')->get_setting( 'categories', $post->ID );
?>
<div id="<?php echo $id ?>-container" <?php if ( isset( $deps ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?>>
<label for="<?php echo $id ?>"><?php echo $label ?></label>   
<div class="categories-panel">
    <div class="box">			
        <ul id="<?php echo $id ?>-category-list" class="category-list">
            <?php if ( ! empty( $categories ) ) : ?>
                <?php foreach ( $categories as $cat_slug => $cat_name ) : ?>
        		<li>
                    <label class="selectit"><input type="checkbox" name="<?php echo $name ?>[]" value="<?php echo esc_attr( $cat_slug ) ?>"<?php checked( in_array( $cat_slug, $value ) ) ?> /> <?php echo $cat_name ?> <a class="remove_cat" href="#">X</a></label>
                </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li class="remove-after-add"><i><?php _e( 'No categories.', 'yith-plugin-fw' ); ?></i></li>
            <?php endif; ?>
    	</ul>
    </div>
	<div class="wp-hidden-children">
		<h4>
			<a tabindex="3" class="hide-if-no-js" href="#category-add" id="<?php echo $id ?>-category-add"><?php _e( '+ Add New Category', 'yith-plugin-fw' ); ?></a>
		</h4>   
		<p class="category-add-field" id="<?php echo $id ?>-category-field">
		    <input type="text" class="newcategory" name="newcategory" style="width:100%;" id="<?php echo $id ?>-new-category" />
            <input type="button" value="<?php esc_attr_e( 'Add', 'yit' ); ?>" class="add:categorychecklist:category-add button category-add-submit" id="<?php echo $id ?>-category-add-submit" />
        </p>
	</div>
</div>                   
<span class="desc inline"><?php echo $desc ?></span>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#<?php echo $id ?>-category-field').hide();
        $(document).on('click', '#<?php echo $id ?>-category-add', function(){
            $('#<?php echo $id ?>-category-field').toggle();
            return false;    
        });   
        
        $(document).on('click', '#<?php echo $id ?>-category-add-submit', function(){
        	var t = $(this);
            var new_category = $('#<?php echo $id ?>-new-category').val();
            
        	var data = {
        		action: 'add_category_post_type',
        		post_id: <?php echo $post->ID; ?>,
        		new_category: new_category
        	};                            
        	
			$.post(ajaxurl, data, function(response) {
				t.prev().val('');
			    var new_cat = response;
                
                $('.remove-after-add').hide();
                $('.category-list').each(function(){
                    var this_post_id = $(this).attr('id');
                    var name = '<?php echo $name ?>';
                    this_post_id = this_post_id.match( /([0-9]+)/gi );
                    name = name.replace( /[0-9]+/g, this_post_id[0] );
                    $(this).prepend('<li><label class="selectit"><input type="checkbox" name="'+name+'[]" value="'+new_cat.slug+'" /> '+new_cat.name+' <a class="remove_cat" href="#">X</a></label></li>');
    			    $('#<?php echo $id ?>-category-list li:first-child .selectit input').attr('checked', true);
    			});
            }, 'json');
			
        });   
        
    });
</script>