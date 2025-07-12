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
 * Select Mailchimp Plugin Admin View
 *
 * @package	Yithemes
 * @author Antonio La Rocca <antonio.larocca@yithemes.it>
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<div id="<?php echo $this->get_id_field( $option['id'] ) ?>-container" class="yit_options rm_option rm_input rm_text" <?php if ( isset( $option['deps'] ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $this->get_id_field( $option['deps']['ids'] ) ?>" data-value="<?php echo $option['deps']['values'] ?>" <?php endif ?>>
    <div class="option">
        <div class="select_wrapper">
            <select name="<?php echo $this->get_name_field( $option['id'] ) ?>" id="<?php echo $this->get_id_field( $option['id'] ) ?>" <?php echo $custom_attributes ?>>
                <?php foreach( $option['options'] as $key => $value ) : ?>
                    <option value="<?php echo esc_attr( $key ) ?>"<?php selected( $key, $db_value ) ?>><?php echo $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="button" class="button-secondary <?php echo $option['class']?>" value="<?php echo esc_attr( $option['button_name'] ) ?>"/>
        <span class="spinner"></span>
    </div>
    <span class="description"><?php echo $option['desc'] ?></span>
    <div class="clear"></div>
</div>