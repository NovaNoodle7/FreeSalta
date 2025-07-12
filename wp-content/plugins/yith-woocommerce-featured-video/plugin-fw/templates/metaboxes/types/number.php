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

extract( $args );

$min_max_attr = $step_attr = '';

if( isset( $min ) ){
    $min_max_attr .= " min='{$min}'";
}

if( isset( $max ) ){
    $min_max_attr .= " max='{$max}'";
}

if( isset( $step ) ){
    $step_attr .= "step='{$step}'";
}
?>
<div id="<?php echo $id ?>-container" <?php if ( isset($deps) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?>>
        <div class="rm_number">
            <label for="<?php echo $id ?>"><?php echo $label ?></label>
            <span class="field">
                <input class="number" type="text" id="<?php echo $id ?>" name="<?php echo $name ?>" <?php echo $step_attr ?> <?php echo $min_max_attr ?> value="<?php echo esc_attr( $value ) ?>" <?php if( isset( $std ) ) : ?>data-std="<?php echo $std ?>"<?php endif ?>" />
                <?php yit_string( '<span class="description">', $desc, '</span>' ); ?>
            </span>
        </div>            
</div>
        <script type="text/javascript" charset="utf-8">
            jQuery(document).ready( function( $ ) {
            	$('#<?php echo $id ?>').spinner({
            		<?php if( isset( $min )): ?>min: <?php echo $min ?>, <?php endif ?>
            		<?php if( isset( $max )): ?>max: <?php echo $max ?>, <?php endif ?> 
            		showOn: 'always',
					upIconClass: "ui-icon-plus",
					downIconClass: "ui-icon-minus"
            	});
            });
        </script>
