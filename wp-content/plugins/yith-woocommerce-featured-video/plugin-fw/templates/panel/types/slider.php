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
 * Slider Plugin Admin View
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
<div id="<?php echo $id ?>-container" class="slider_container yit_options rm_option rm_input slider_control slider" <?php if ( isset( $option['deps'] ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $this->get_id_field( $option['deps']['ids'] ) ?>" data-value="<?php echo $option['deps']['values'] ?>" <?php endif ?>>
    <div class="option">
        <div class="ui-slider">
            <span class="minCaption"><?php echo $option['min']  ?></span>
            <span class="maxCaption"><?php echo $option['max']  ?></span>
            <span id="<?php echo $id ?>-feedback" class="feedback"><strong><?php echo $db_value ?></strong></span>

            <div id="<?php echo $id ?>-div" data-step="<?php echo isset( $option['step'] ) ? $option['step'] : 1 ?>" data-labels="<?php echo '' ?>" data-min="<?php echo $option['min'] ?>" data-max="<?php echo $option['max'] ?>" data-val="<?php echo $db_value; ?>" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                <input id="<?php echo $id ?>" type="hidden" name="<?php echo $name ?>" value="<?php echo esc_attr( $db_value ); ?>" />
            </div>
        </div>
    </div>

    <span class="description"><?php echo $option['desc'] ?></span>
</div>