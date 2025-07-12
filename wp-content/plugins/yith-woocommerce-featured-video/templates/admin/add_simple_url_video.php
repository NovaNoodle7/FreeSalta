<?php
if( !defined( 'ABSPATH' ) )
    exit;

echo '<div class="options_group">';

// Expirey
woocommerce_wp_text_input( array(
    'id' => $id,
    'label' => $label,
    'placeholder' => $placeholder,
    'desc_tip' => $desc_tip,
    'description' => $description )
) ;

echo '</div>';