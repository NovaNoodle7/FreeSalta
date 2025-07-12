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

do_action( 'yit_before_metaboxes_tab' ) ?>
<div class="metaboxes-tab">
    <?php do_action( 'yit_before_metaboxes_labels' ) ?>
    <ul class="metaboxes-tabs clearfix"<?php if ( count( $tabs ) <= 1 ) : ?> style="display:none;"<?php endif; ?>>
        <?php
        $i = 0;
        foreach ( $tabs as $tab ) :
            if ( ! isset( $tab['fields'] ) || empty( $tab['fields'] ) ) {
                continue;
            }
            ?>
            <li<?php if ( ! $i ) : ?> class="tabs"<?php endif ?>>
            <a href="#<?php echo urldecode( sanitize_title( $tab['label'] ) ) ?>"><?php echo $tab['label'] ?></a></li><?php
            $i ++;
        endforeach;
        ?>
    </ul>
    <?php do_action( 'yit_after_metaboxes_labels' ) ?>
    <?php if( isset(  $tab['label'] ) ) : ?>
        <?php do_action( 'yit_before_metabox_option_' . urldecode( sanitize_title( $tab['label'] ) ) ); ?>
    <?php endif ?>

    <?php
    // Use nonce for verification
    wp_nonce_field( 'metaboxes-fields-nonce', 'yit_metaboxes_nonce' );
    ?>
    <?php foreach ( $tabs as $tab ) :

        ?>
        <div class="tabs-panel" id="<?php echo urldecode( sanitize_title( $tab['label'] ) ) ?>">
            <?php
            if ( ! isset( $tab['fields'] ) ) {
                continue;
            }

            $tab['fields'] = apply_filters( 'yit_metabox_' . sanitize_title( $tab['label'] ) . '_tab_fields', $tab['fields'] );

            foreach ( $tab['fields'] as $id_tab=>$field ) :
                $value           = yit_get_post_meta( $post->ID, $field['id'] );
                $field['value'] = $value != '' ? $value : ( isset( $field['std'] ) ? $field['std'] : '' );
                ?>
                <div class="the-metabox <?php echo $field['type'] ?> clearfix<?php if ( empty( $field['label'] ) ) : ?> no-label<?php endif; ?>">
                    <?php $args = apply_filters('yit_fw_metaboxes_type_args', array(
                            'basename' => YIT_CORE_PLUGIN_PATH,
                            'path' => '/metaboxes/types/',
                            'type' => $field['type'],
                            'args' => array('args' => $field)
                        )
                    );
                    extract( $args );
                    ?>
                    <?php yit_plugin_get_template( $basename, $path . $type . '.php' , $args ) ?>
                </div>
            <?php endforeach ?>
        </div>
    <?php endforeach ?>
</div>