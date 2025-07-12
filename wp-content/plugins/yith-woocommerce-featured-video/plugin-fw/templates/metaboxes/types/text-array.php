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

$size = isset( $size ) ? " style=\"width:{$size}px;\"" : '';
?>
<div id="<?php echo $id ?>-container" <?php if ( isset( $deps ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?>>
    <label for="<?php echo $id ?>"><?php echo $label ?>
        <small><?php echo $desc ?></small>
    </label>

    <p>
        <?php foreach ( $fields as $field_name => $field_label ) : ?>
            <?php echo $field_label ?>:
            <input type="text" name="<?php echo $name ?>[<?php echo $field_name ?>]" id="<?php echo $id ?>_<?php echo $field_name ?>" value="<?php echo isset( $value[$field_name] ) ? esc_attr( $value[$field_name] ) : '' ?>"<?php echo $size ?> /> &nbsp; &nbsp;
        <?php endforeach ?>
    </p>
</div>