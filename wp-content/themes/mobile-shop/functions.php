<?php
function mobile_shop_theme_setup() {
    load_child_theme_textdomain( 'mobile-shop', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'mobile_shop_theme_setup' );

function mobile_shop_register_scripts() {
    $parent_style = 'storeone-style';
    wp_enqueue_style('storeone-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,500,700,900');
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'mobile-shop-style', get_stylesheet_uri(), array( $parent_style ));
}
add_action('wp_enqueue_scripts', 'mobile_shop_register_scripts', 20);



function mobile_shop_get_page_links_html() {
	if (storeone_is_wc()) {

		global $woocommerce;

		$myaccount_page_id = get_option('woocommerce_myaccount_page_id');
		$links             = array();
		$account_link      = '#';
		if ($myaccount_page_id) {
			$account_link = get_permalink($myaccount_page_id);
		}

		if (is_user_logged_in()) {
			$links['myaccount'] = $account_link;
		} else {
			$links['login']    = $account_link;
			$links['register'] = $account_link;
		}

		$links['cart']     = $woocommerce->cart->get_cart_url();
		$links['checkout'] = $woocommerce->cart->get_checkout_url();

		if (is_user_logged_in()) {
			$links['logout'] = wp_logout_url(esc_url(home_url('/')));

			if (get_option('woocommerce_force_ssl_checkout') == 'yes') {
				$links['logout'] = str_replace('http:', 'https:', $links['logout']);
			}
		}

		$links  = apply_filters('storeone_page_links', $links);
		$lables = storeone_get_page_labels();
		$html   = '';

		foreach ($links as $key => $link) {
			$html .= sprintf('<li><a class="top-bl-%1$s" href="%2$s"> %3$s </a></li>',
				esc_attr($key),
				esc_url($link),
				wp_kses_post($lables[$key])
			);
		}
		$html = '<ul class="account-links dropdown-menu" aria-labelledby="MyAccountDropdown">' . $html . '</ul>';
		return $html;
	}
}