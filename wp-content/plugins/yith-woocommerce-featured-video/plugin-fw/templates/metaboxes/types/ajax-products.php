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
wp_enqueue_script( 'woocommerce_admin' );
extract( $args );
$is_multiple = isset( $multiple ) && $multiple;
$multiple = ( $is_multiple ) ? ' multiple' : '';
?>
<div id="<?php echo $id ?>-container" <?php if ( isset( $deps ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $deps['ids'] ?>" data-value="<?php echo $deps['values'] ?>" <?php endif ?>>

    <label for="<?php echo $id ?>"><?php echo $label ?></label>

    <select id="<?php echo $id ?>" name="<?php echo $name ?><?php if( $is_multiple ) echo "[]" ?>" class="ajax_chosen_select_products" multiple="multiple" data-placeholder="<?php _e('Search for a product','yith-plugin-fw') ?>">
        <?php
            if ( $value ) {
                foreach ( $value as $product_id ) {
                    $product = wc_get_product( $product_id );
                    if ( $product ) {
                        echo '<option value="' . esc_attr( $product_id ) . '" selected="selected">' . esc_html( $product->get_formatted_name() ) . '</option>';
                    }
                }
            }
            ?>
    </select>

    <span class="desc inline"><?php echo $desc ?></span>
</div>
<script>

    (function ($) {
        $(document).ready(function(){
            $("select.ajax_chosen_select_products").ajaxChosen({
                method: 	'GET',
                url: 		'<?php echo  admin_url('admin-ajax.php') ?>',
                dataType: 	'json',
                afterTypeDelay: 100,
                data:		{
                    action: 		'woocommerce_json_search_products',
                    security: 		'<?php echo wp_create_nonce("search-products") ?>'
                }
            }, function (data) {
                var terms = {};

                $.each(data, function (i, val) {
                    terms[i] = val;
                });

                return terms;
            });
        })

    })(jQuery);
</script>