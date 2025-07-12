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

$options = yit_get_responsive_sliders();
?>
<div id="<?php echo $id ?>-container" <?php if ( isset( $deps ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?>>
    <label for="<?php echo $id ?>"><?php echo $label ?></label>

    <div class="select_wrapper">
        <select id="<?php echo $id ?>" name="<?php echo $name ?>" <?php if ( isset( $std ) ) : ?>data-std="<?php echo $std ?>"<?php endif ?>>
            <option></option>
            <option value="none"><?php _e( 'None', 'yith-plugin-fw' ) ?></option>
            <?php foreach ( $options as $key => $item ) : ?>
                <option value="<?php echo esc_attr( $key ) ?>"<?php selected( $key, $value ) ?>><?php echo $item ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <span class="desc inline"><?php echo $desc ?></span>
</div>