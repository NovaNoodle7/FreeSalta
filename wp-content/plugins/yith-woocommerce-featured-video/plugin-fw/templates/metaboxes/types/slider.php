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

if ( ! isset( $labels ) ) {
    $labels = '';
}

?>
<div id="<?php echo $id ?>-container" class="slider_container" <?php if ( isset( $deps ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?>>
    <label for="<?php echo $id ?>"><?php echo $label ?></label>
        <div class="ui-slider">
            <span class="minCaption"><?php echo $min  ?></span>
            <span class="maxCaption"><?php echo $max  ?></span>
            <span id="<?php echo $id ?>-feedback" class="feedback"><strong><?php echo $value ?></strong></span>

            <div id="<?php echo $id ?>-div" data-step="<?php echo isset( $step ) ? $step : 1 ?>" data-labels="<?php echo '' ?>" data-min="<?php echo $min ?>" data-max="<?php echo $max ?>" data-val="<?php echo $value; ?>" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                <input id="<?php echo $id ?>" type="hidden" name="<?php echo $name ?>" value="<?php echo esc_attr( $value ); ?>" />
            </div>
        </div>
    <span class="description"><?php echo $desc ?></span>
</div>