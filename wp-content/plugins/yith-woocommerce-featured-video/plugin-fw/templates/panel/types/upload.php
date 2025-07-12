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
 * Upload Plugin Admin View
 *
 * @package    Yithemes
 * @author     Emanuela Castorina <emanuela.castorina@yithemes.it>
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

$id = $this->get_id_field( $option['id'] );
$name = $this->get_name_field( $option['id'] );

?>
<div id="<?php echo $id ?>-container" >
    <div id="<?php echo $id ?>-container" class="yit_options rm_option rm_input rm_text rm_upload" <?php if ( isset( $option['deps'] ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $this->get_id_field( $option['deps']['ids'] ) ?>" data-value="<?php echo $option['deps']['values'] ?>" <?php endif ?>>
        <div class="option yit-upload">
            <input type="text" name="<?php echo $name ?>" id="<?php echo $id ?>" value="<?php echo $db_value == '1' ? '' : esc_attr( $db_value ) ?>" class="upload_img_url" />
            <input type="button" value="<?php _e( 'Upload', 'yith-plugin-fw' ) ?>" id="<?php echo $id ?>-button" class="upload_button button" />
            <input type="button" value="<?php _e( 'Reset', 'yith-plugin-fw' ) ?>" id="<?php echo $id ?>-button_reset" class="upload_button_reset button" data-default="<?php echo $option['std'] ?>"/>
        </div>
        <div class="clear"></div>
        <span class="description"><?php echo $option['desc'] ?></span>
    </div>
    <div class="upload_img_preview" style="margin-top:10px;">
        <?php
        $file = $db_value;
        if ( preg_match( '/(jpg|jpeg|png|gif|ico)$/', $file ) ) {
            echo isset( $this->settings['plugin-url'] ) ? "<img src=\"" . $this->settings['plugin-url'] . "/plugin-fw/assets/images/sleep.png\" data-src=\"$file\" />" : '';
        }
        ?>
    </div>
</div>

