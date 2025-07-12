<?php


extract( $args );

$current_options = wp_parse_args( $args['value'], $args['std'] );

?>
<div id="<?php echo $id ?>-container" <?php if ( isset( $deps ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?> class="select_icon">

    <label for="<?php echo $id ?>"><?php echo $label ?></label>

    <div class="option">

        <div class="select_wrapper icon_type">
            <select id="<?php echo $id ?>[select]" name="<?php echo $name ?>[select]" <?php if ( isset( $std['select'] ) ) : ?>data-std="<?php echo $std['select']; ?>"<?php endif; ?>>
                <?php foreach ( $options['select'] as $val => $option ) : ?>
                    <option value="<?php echo $val ?>" <?php selected( $current_options['select'], $val ); ?> ><?php echo $option ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="select_wrapper awesome_icon" style="font-family: 'FontAwesome'">
            <select style="font-family: 'FontAwesome'" id="<?php echo $id ?>[icon]" name="<?php echo $name ?>[icon]">
                <?php foreach ( $options['icon'] as $val => $option ) : $esc_icon = ! empty( $val ) ? '&#x' . $val . '; ' : ''; ?>
                    <option value="<?php echo $option ?>" <?php selected( $current_options['icon'], $option ); ?> ><?php echo $esc_icon . $option; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="input_wrapper custom_icon">
            <input type="text" name="<?php echo $name ?>[custom]" id="<?php echo $id ?>[custom]" value="<?php echo $current_options['custom'] ?>" class="upload_img_url upload_custom_icon" />
            <input type="button" value="<?php _e( 'Upload', 'yith-plugin-fw' ) ?>" id="<?php echo $id; ?>-custom-button" class="upload_button button" />

            <div class="upload_img_preview" style="margin-top:10px;">
                <?php
                $file = $current_options['custom'];
                if ( preg_match( '/(jpg|jpeg|png|gif|ico)$/', $file ) ) {
                    echo __( 'Image preview', 'yith-plugin-fw' ) . ': ' . "<img src=\"" . YIT_CORE_ASSETS_URL . "/images/sleep.png\" data-src=\"$file\" />";
                }
                ?>
            </div>

        </div>
    </div>

    <div class="clear"></div>

    <div class="description">
        <?php echo $desc ?>
    </div>

</div>

<script>

    jQuery(document).ready( function($){

        $('.select_wrapper.icon_type').on('change', function(){
            var t       = $(this);
            var parents = $('#' + t.parents('div.select_icon').attr('id'));
            var option  = $('option:selected', this).val();
            var to_show = option == 'none' ? '' : option == 'icon'  ? '.awesome_icon' : '.custom_icon';

            parents.find('.option > div:not(.icon_type)').addClass('hidden').removeClass( 'show' );
            parents.find( to_show ).removeClass( 'hidden' ).addClass( 'show' );
        });

        $('.select_wrapper.icon_type').trigger('change');
    });

</script>