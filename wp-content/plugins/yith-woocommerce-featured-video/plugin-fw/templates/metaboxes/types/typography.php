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

$defaults = array(
    'size'   => 12,
    'unit'   => 'px',
    'family' => '',
    'style'  => 'regular',
    'color'  => '#000000'
);
$value = wp_parse_args( $value, $defaults );
?>
<div id="<?php echo $id ?>-container" <?php if ( isset( $deps ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?> >
    <div id="<?php echo $id ?>" class="rm_typography rm_option">
        <div class="option">
            <label for="<?php echo $id ?>"><?php echo $label ?>
                <small><?php echo $desc ?></small>
            </label>

            <?php if ( strpos( $style['properties'], 'font-size' ) !== false ) : ?>
                <!-- Size -->
                <div class="spinner_container">
                    <input class="number" type="text" name="<?php echo $name ?>[size]" id="<?php echo $id ?>-size" value="<?php echo esc_attr( $value['size'] ) ?>" />
                </div>

                <!-- Unit -->
                <div class="select_wrapper font-unit">
                    <select name="<?php echo $name ?>[unit]" id="<?php echo $id ?>-unit">
                        <option value="px" <?php selected( $value['unit'], 'px' ) ?>><?php _e( 'px', 'yith-plugin-fw' ) ?></option>
                        <option value="em" <?php selected( $value['unit'], 'em' ) ?>><?php _e( 'em', 'yith-plugin-fw' ) ?></option>
                        <option value="pt" <?php selected( $value['unit'], 'pt' ) ?>><?php _e( 'pt', 'yith-plugin-fw' ) ?></option>
                        <option value="rem" <?php selected( $value['unit'], 'rem' ) ?>><?php _e( 'rem', 'yith-plugin-fw' ) ?></option>
                    </select>
                </div>
            <?php endif; ?>

            <?php if ( strpos( $style['properties'], 'font-family' ) !== false ) : ?>
                <!-- Family -->
                <div class="select_wrapper font-family">
                    <select name="<?php echo $name ?>[family]" id="<?php echo $id ?>-family">
                        <?php
                        $web_fonts = yit_get_web_fonts();
                        $google_fonts = yit_get_google_fonts();

                        if ( ! empty( $web_fonts ) ) {
                            echo '<optgroup label="' . __( 'Web fonts', 'yith-plugin-fw' ) . '">';

                            foreach ( $web_fonts as $font_name => $rule ) {
                                ?>
                                <option value='<?php echo esc_attr( $rule ) ?>' <?php selected( stripslashes( $value['family'] ), $rule ) ?>><?php echo $font_name ?></option>
                            <?php
                            }

                            echo '</optgroup>';
                        }

                        if ( ! empty( $google_fonts ) ) {
                            echo '<optgroup label="' . __( 'Google fonts', 'yith-plugin-fw' ) . '">';

                            foreach ( $google_fonts->items as $font ) {
//                     $font_human = trim( stripslashes( end( array_slice( explode( ',', $font ), 0, 1 ) ) ), "'" );
//                     $std_human  = trim( stripslashes( end( array_slice( explode( ',', $value['family'] ), 0, 1 ) ) ), "'" );

                                //if( isset($font->family) ):
                                //Only me and god know what happen on this line...
                                ?>
                                <option value="<?php echo stripslashes( $font ) ?>" <?php selected( $value['family'], $font ) ?>><?php echo $font ?></option>
                                <?php
                                //endif;
                            }

                            echo '</optgroup>';
                        }
                        ?>
                    </select>
                </div>
            <?php endif; ?>

            <?php if ( strpos( $style['properties'], 'font-style' ) !== false ) : ?>
                <!-- Style -->
                <div class="select_wrapper font-style">
                    <select name="<?php echo $name ?>[style]" id="<?php echo $id ?>-style">
                        <option value="regular" <?php selected( $value['style'], 'regular' ) ?>><?php _e( 'Regular', 'yith-plugin-fw' ) ?></option>
                        <option value="bold" <?php selected( $value['style'], 'bold' ) ?>><?php _e( 'Bold', 'yith-plugin-fw' ) ?></option>
                        <option value="extra-bold" <?php selected( $std['style'], 'extra-bold' ) ?>><?php _e( 'Extra bold', 'yith-plugin-fw' ) ?></option>
                        <option value="italic" <?php selected( $value['style'], 'italic' ) ?>><?php _e( 'Italic', 'yith-plugin-fw' ) ?></option>
                        <option value="bold-italic" <?php selected( $value['style'], 'bold-italic' ) ?>><?php _e( 'Italic bold', 'yith-plugin-fw' ) ?></option>
                    </select>
                </div>
            <?php endif; ?>

            <?php if ( strpos( $style['properties'], 'color' ) !== false ) : ?>
                <!-- Color -->
                <div id="<?php echo $id ?>_container" class="colorpicker_container">
                    <div style="background-color: <?php echo $value['color'] ?>"></div>
                </div>
                <input type="text" name="<?php echo $name ?>[color]" id="<?php echo $id ?>-color" style="width:150px" value="<?php echo esc_attr( $value['color'] ) ?>" />
            <?php endif; ?>
        </div>
        <div class="clear"></div>
        <div class="font-preview">
            <p>The quick brown fox jumps over the lazy dog</p>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
    jQuery(document).ready(function ($) {
        var container = $('#<?php echo $id ?>');
        var preview = container.children('.font-preview').children('p');

        //Set current value, before trigger change event

        //Color
        preview.css('color', '<?php echo $value['color'] ?>');
        //Font size
        var size = $('#<?php echo $id ?>-size').val();
        var unit = $('#<?php echo $id ?>-unit').val();

        preview.css('font-size', size + unit);
        preview.css('line-height', ( unit == 'em' || unit == 'rem' ? Number(size) + 0.4 : Number(size) + 4 ) + unit);
        //Font style
        var style = $('#<?php echo $id ?>-style').val();

        if (style == 'italic') {
            preview.css({ 'font-weight': 'normal', 'font-style': 'italic' });
        } else if (style == 'bold') {
            preview.css({ 'font-weight': 'bold', 'font-style': 'normal' });
        } else if (style == 'extra-bold') {
            preview.css({ 'font-weight': '800', 'font-style': 'normal' });
        } else if (style == 'bold-italic') {
            preview.css({ 'font-weight': 'bold', 'font-style': 'italic' });
        } else {
            preview.css({ 'font-weight': 'normal', 'font-style': 'normal' });
        }

        //Font Family
        var group = $('#<?php echo $id ?>-family').find('option:selected').parent().attr('label');

        if ($('#<?php echo $id ?>-family').length > 0) {
            if (group == '<?php _e( 'Web fonts', 'yith-plugin-fw' ) ?>') {
                //Web font
                preview.css('font-family', $('#<?php echo $id ?>-family').val());
            } else {
                //Google font
                WebFontConfig = {
                    google: { families: [ $('#<?php echo $id ?>-family :selected').text() ] }
                };
                (function () {
                    var wf = document.createElement('script');
                    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                    wf.type = 'text/javascript';
                    wf.async = 'true';

                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(wf, s);
                })();

                var preview_font = $('#<?php echo $id ?>-family').val()
                preview.css('font-family', preview_font.replace(/:(.*)?/g, ''));
            }
        }

        $('#<?php echo $id ?>-size').spinner({
            <?php if( isset( $min )): ?>min: <?php echo $min ?>, <?php endif ?>
            <?php if( isset( $max )): ?>max: <?php echo $max ?>, <?php endif ?>
            showOn                         : 'always',
            upIconClass                    : "ui-icon-plus",
            downIconClass                  : "ui-icon-minus",
        });

        $('#<?php echo $id ?>_container').ColorPicker({
            color   : '<?php echo $value['color'] ?>',
            onShow  : function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide  : function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#<?php echo $id ?>_container div').css('backgroundColor', '#' + hex);
                $('#<?php echo $id ?>_container').next('input').attr('value', '#' + hex);

                //Preview color change
                preview.css('color', '#' + hex);
            }
        });

        //Font Size Change
        $('#<?php echo $id ?>-size, #<?php echo $id ?>-unit').change(function () {
            var size = $('#<?php echo $id ?>-size').val();
            var unit = $('#<?php echo $id ?>-unit').val();

            preview.css('font-size', size + unit);
            preview.css('line-height', ( unit == 'em' || unit == 'rem' ? Number(size) + 0.4 : Number(size) + 4 ) + unit);
        });

        //Font Family Change
        $('#<?php echo $id ?>-family').change(function () {
            var group = $(this).find('option:selected').parent().attr('label');

            if (group == '<?php _e( 'Web fonts', 'yith-plugin-fw' ) ?>') {
                //Web font
                preview.css('font-family', $(this).val());
            } else {
                //Google font
                WebFontConfig = {
                    google: { families: [ $(':selected', this).text() ] }
                };
                (function () {
                    var wf = document.createElement('script');
                    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                    wf.type = 'text/javascript';
                    wf.async = 'true';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(wf, s);
                })();

                var preview_font = $(this).val();
                preview.css('font-family', preview_font.replace(/:(.*)?/g, ''));
            }
        });

        //Font Style Change
        $('#<?php echo $id ?>-style').change(function () {
            var style = $(this).val();

            if (style == 'italic') {
                preview.css({ 'font-weight': 'normal', 'font-style': 'italic' });
            } else if (style == 'bold') {
                preview.css({ 'font-weight': 'bold', 'font-style': 'normal' });
            } else if (style == 'bold-italic') {
                preview.css({ 'font-weight': 'bold', 'font-style': 'italic' });
            } else {
                preview.css({ 'font-weight': 'normal', 'font-style': 'normal' });
            }
        });
    });
</script>