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
$multiple = ( isset( $multiple ) && $multiple ) ? ' multiple' : '';
?>
<div id="<?php echo $id ?>-container" <?php if ( isset( $deps ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?>>

    <label for="<?php echo $id ?>"><?php echo $label ?></label>

    <div class="select_wrapper">
        <select<?php echo $multiple ?> id="<?php echo $id ?>" name="<?php echo $name ?>" <?php if ( isset( $std ) ) : ?>data-std="<?php echo $std ?>"<?php endif ?>>
            <?php foreach ( $options as $key => $item ) : ?>
                <option value="<?php echo $key ?>"<?php selected( $key, $value ) ?>><?php echo $item ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="button" class="button-secondary <?php echo $class?>" value="<?php echo $button_name?>"/>
    <span class="spinner"></span>
    <span class="desc inline"><?php echo $desc ?></span>
</div>