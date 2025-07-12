<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Select Plugin Admin View
 *
 * @package    Yithemes
 * @author     Emanuela Castorina <emanuela.castorina@yithemes.it>
 * @since      1.0.0
 */

extract( $args );
//
//$layout = ! isset( $value['layout'] ) ? 'sidebar-right' : $value['layout'];
//$sidebar1 = ! isset( $value['sidebar1'] ) ? '-1' : $value['sidebar1'];
//$sidebar2 = ! isset( $value['sidebar2'] ) ? '-1' : $value['sidebar2'];


$layout = ! isset(  $value['layout'] ) ? 'sidebar-no' : $value['layout'];
$sidebar_left = ! isset(  $value['sidebar-left'] ) ? '-1' :  $value['sidebar-left'];
$sidebar_right = ! isset( $value['sidebar-right'] ) ? '-1' :  $value['sidebar-right'];

?>
<div class="yit-sidebar-layout">
    <div class="option">
        <label for="_slider_name"><?php echo $label ?></label>

        <input type="radio" name="<?php echo $name ?>[layout]" id="<?php echo $id . '-left' ?>" value="sidebar-left" <?php checked( $layout, 'sidebar-left' ) ?> />
        <img src="<?php echo YIT_CORE_PLUGIN_URL ?>/assets/images/sidebar-left.png" title="<?php _e( 'Left sidebar', 'yith-plugin-fw' ) ?>" alt="<?php _e( 'Left sidebar', 'yith-plugin-fw' ) ?>" class="<?php echo $id . '-left' ?>" />

        <input type="radio" name="<?php echo  $name ?>[layout]" id="<?php echo $id . '-right' ?>" value="sidebar-right" <?php checked( $layout, 'sidebar-right' ) ?> />
        <img src="<?php echo YIT_CORE_PLUGIN_URL ?>/assets/images/sidebar-right.png" title="<?php _e( 'Right sidebar', 'yith-plugin-fw' ) ?>" alt="<?php _e( 'Right sidebar', 'yith-plugin-fw' ) ?>" class="<?php echo $id . '-right' ?>" />

        <input type="radio" name="<?php echo  $name ?>[layout]" id="<?php echo $id . '-double' ?>" value="sidebar-double" <?php checked( $layout, 'sidebar-double' ) ?> />
        <img src="<?php echo YIT_CORE_PLUGIN_URL ?>/assets/images/double-sidebar.png" title="<?php _e( 'No sidebar', 'yith-plugin-fw' ) ?>" alt="<?php _e( 'No sidebar', 'yith-plugin-fw' ) ?>" class="<?php echo $id . '-double' ?>" />

        <input type="radio" name="<?php echo  $name ?>[layout]" id="<?php echo $id . '-no' ?>" value="sidebar-no" <?php checked( $layout, 'sidebar-no' ) ?> />
        <img src="<?php echo YIT_CORE_PLUGIN_URL ?>/assets/images/no-sidebar.png" title="<?php _e( 'No sidebar', 'yith-plugin-fw' ) ?>" alt="<?php _e( 'No sidebar', 'yith-plugin-fw' ) ?>" class="<?php echo $id . '-no' ?>" />
    </div>
    <div class="clearfix"></div>
    <div class="option" id="choose-sidebars">
        <div class="side">
            <div class="select-mask" <?php if ( $layout != 'sidebar-double' && $layout != 'sidebar-left' ) { echo 'style="display:none"'; } ?> id="<?php echo $id ?>-sidebar-left-container">
                <label for ="<?php echo $id ?>-sidebar-left"><?php _e('Left Sidebar','yith-plugin-fw') ?></label>
                <select name="<?php echo  $name ?>[sidebar-left]" id="<?php echo $id ?>-sidebar-left">
                    <option value="-1"><?php _e( 'Choose a sidebar', 'yith-plugin-fw' ) ?></option>
                    <?php foreach ( yit_registered_sidebars() as $val => $option ) { ?>
                        <option value="<?php echo esc_attr( $val ) ?>" <?php selected( $sidebar_left, $val ) ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="side"  style="clear: both">
            <div class="select-mask"  <?php if ( $layout != 'sidebar-double' && $layout != 'sidebar-right' ) { echo 'style="display:none"'; } ?> id="<?php echo $id ?>-sidebar-right-container">
                <label for ="<?php echo $id ?>-sidebar-right"><?php _e('Right Sidebar','yith-plugin-fw') ?></label>
                <select name="<?php echo  $name ?>[sidebar-right]" id="<?php echo $id ?>-sidebar-right">
                    <option value="-1"><?php _e( 'Choose a sidebar', 'yith-plugin-fw' ) ?></option>
                    <?php foreach ( yit_registered_sidebars() as $val => $option ) { ?>
                        <option value="<?php echo esc_attr( $val ) ?>" <?php selected( $sidebar_right, $val ) ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    (function ($){

        $(document).on('click', '.yit-sidebar-layout img' , function(e) {

            $( this ).parent().children( ':radio' ).attr( 'checked', false );
            $( this ).prev( ':radio' ).attr( 'checked', true );
        });

        $(document).on('click', 'img._sidebars-no' , function(e) {
            $( '#_sidebars-sidebar-left-container, #_sidebars-sidebar-right-container' ).hide();
        });

        $(document).on('click', 'img._sidebars-left' , function(e) {
            $('#_sidebars-sidebar-right-container' ).hide();
            $('#_sidebars-sidebar-left-container' ).show();
        });

        $(document).on('click', 'img._sidebars-right' , function(e) {
            $('#_sidebars-sidebar-right-container' ).show();
            $('#_sidebars-sidebar-left-container' ).hide();
        });

        $(document).on('click', 'img._sidebars-double' , function(e) {
            $( '#_sidebars-sidebar-right-container, #_sidebars-sidebar-left-container' ).show();
        });
        
//
//        $(document).on('click', '.yit-sidebar-layout img' , function() {
//
//            $( this ).parent().children( ':radio' ).attr( 'checked', false );
//            $( this ).prev( ':radio' ).attr( 'checked', true );
//        });
//
//        $('img._sidebar-no').click( function() {
//            $( '#_sidebar-sidebar1-container, #_sidebar-sidebar2-container' ).hide();
//        });
//
//        $( 'img._sidebar-left, img._sidebar-right').click( function() {
//            $('#_sidebar-sidebar2-container' ).hide();
//            $('#_sidebar-sidebar1-container' ).show();
//        });
//
//        $('img._sidebar-double').click( function() {
//            $( '#_sidebar-sidebar1-container, #_sidebar-sidebar2-container' ).show();
//        });


    })(jQuery);
</script>
