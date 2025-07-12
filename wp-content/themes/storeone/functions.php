<?php
/**
 * StoreOne functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package storeone
 */

if (!function_exists('storeone_setup')):
	function storeone_setup() {
		load_theme_textdomain('storeone', get_template_directory() . '/languages');
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('custom-background', array('default-color' => 'ffffff'));
		add_theme_support('customize-selective-refresh-widgets');
		register_nav_menus(array(
			'primary' => esc_html__('Primary', 'storeone'),
		));
		add_theme_support('html5', array(
			'gallery',
			'caption',
		));
		add_theme_support('custom-logo', array(
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array('site-title', 'site-description'),
		));
		add_theme_support('woocommerce');
		add_image_size('storeone-blog', '825', '350', true);
		add_image_size('storeone-thumb', '340', '225', true);
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

	}
endif;
add_action('after_setup_theme', 'storeone_setup');

function storeone_content_width() {
	$GLOBALS['content_width'] = apply_filters('storeone_content_width', 1170);
}
add_action('after_setup_theme', 'storeone_content_width', 0);

function storeone_widgets_init() {

	register_sidebar(array(
		'name'          => esc_html__('Sidebar', 'storeone'),
		'id'            => 'sidebar',
		'description'   => esc_html__('Sidebar Widget Area', 'storeone'),
		'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Sidebar Shop', 'storeone'),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__('Shop Sidebar Widget Area', 'storeone'),
		'before_widget' => '<div id="%1$s" class="widget sidebar-widget shop-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Footer Widget Area', 'storeone'),
		'id'            => 'footer-widget-area',
		'description'   => esc_html__('footer widget area', 'storeone'),
		'before_widget' => '<div id="%1$s" class="col-md-3 col-sm-6 widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	));

}
add_action('widgets_init', 'storeone_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function storeone_scripts() {

	wp_enqueue_style('font-awesome', get_template_directory_uri() . "/css/font-awesome.min.css");
	wp_enqueue_style('animate', get_template_directory_uri() . "/css/animate.min.css");
	wp_enqueue_style('bootstrap', get_template_directory_uri() . "/css/bootstrap.min.css");
	wp_enqueue_style('simplelightbox', get_template_directory_uri() . "/css/simplelightbox.min.css");
	wp_enqueue_style('owl-carousel', get_template_directory_uri() . "/css/owl.carousel.min.css");
	
	if (is_singular() && comments_open() && get_option('thread_comments')) {wp_enqueue_script('comment-reply');}
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '20170131', true);
	wp_enqueue_script('wow', get_template_directory_uri() . '/js/wow.min.js', array('jquery'), '20170131', true);
	wp_enqueue_script('simple-lightbox', get_template_directory_uri() . '/js/simple-lightbox.min.js', array('jquery'), '20170131', true);
	wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '20170131', true);
	wp_enqueue_script('storeone-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20170131', true);
	wp_enqueue_script('storeone-custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery', 'masonry'), '20170131', true);

	wp_enqueue_script('respond', get_template_directory_uri() . '/js/respond.min.js');
	wp_script_add_data('respond', 'conditional', 'lt IE 9');

	wp_enqueue_script('html5shiv', get_template_directory_uri() . '/js/html5shiv.js');
	wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');

}
add_action('wp_enqueue_scripts', 'storeone_scripts');

function storeone_register_custom_scripts() {
	wp_enqueue_style('storeone-google-fonts', 'https://fonts.googleapis.com/css?family=Lato:300,400,700,900');
    wp_enqueue_style('storeone-style', get_stylesheet_uri());
	wp_enqueue_style('storeone-media', get_template_directory_uri() . "/css/media-screen.css");
}
add_action('wp_enqueue_scripts', 'storeone_register_custom_scripts', 20);

require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/sanitize-cb.php';
require get_template_directory() . '/inc/menu-walker.php';
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/theme-info.php';
require get_template_directory() . '/inc/include-kirki.php';
require get_template_directory() . '/inc/kirki-config.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/jetpack.php';

function storeone_is_wc() {

	if (class_exists('WooCommerce')) {
		return true;
	} else {
		return false;
	}
}

function storeone_mini_cart() {
	if (storeone_is_wc()): ?>
		<div class="mini-cart-container pull-right">
			<div class="bgs-cart-nav">
				<div class="mini-cart-icon">
					<div class="mini-item-count"><?php echo esc_html(number_format_i18n(WC()->cart->get_cart_contents_count())); ?></div>
					<i class="fa fa-shopping-cart"></i>
				</div>
				<div class="mini-cart-details">
					<div class="mini-cart-title"><?php esc_html_e('TOTAL', 'storeone');?></div>
					<div class="mini-cart-total"><?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?></div>
				</div>
			</div>
			<div class="bgs-mini-cart">
				<?php wc_get_template_part('cart/mini-cart');?>
			</div>
		</div>
	<?php endif;
}

remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination');
function storeone_woocommerce_pagination() {
	?>
        <div class="clearfix"></div>
        <div class="bgs-pagination">
            <?php the_posts_pagination();?>
        </div>
    <?php
}
add_action('woocommerce_after_shop_loop', 'storeone_woocommerce_pagination', 10);

remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals');
add_action('storeone_woocommerce_cart_totals', 'woocommerce_cart_totals', 10);

function storeone_get_page_links_html() {
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
		$html = '<ul class="account-links">' . $html . '</ul>';
		return $html;
	}
}

function storeone_get_page_labels() {
	$lables = array(
		'myaccount' => '<i class="fa fa-user"></i> ' . __('My Account', 'storeone'),
		'login'     => '<i class="fa fa-sign-in"></i> ' . __('Login', 'storeone'),
		'register'  => '<i class="fa fa-user-plus"></i> ' . __('Register', 'storeone'),
		'cart'      => '<i class="fa fa-shopping-basket"></i> ' . __('Cart', 'storeone'),
		'checkout'  => '<i class="fa fa-check-circle-o"></i> ' . __('Checkout', 'storeone'),
		'wishlist'  => '<i class="fa fa-heart"></i> ' . __('Wishlist', 'storeone'),
		'logout'    => '<i class="fa fa-sign-out"></i> ' . __('Logout', 'storeone'),
	);

	$lables = apply_filters('storeone_page_labels', $lables);
	return $lables;
}

function storeone_get_product_tab_labels() {
	$product_tabs = array(
		'best_selling_products' => esc_html__('Best Selling Products', 'storeone'),
		'sale_products'         => esc_html__('Sale Products', 'storeone'),
		'featured_products'     => esc_html__('Featured Products', 'storeone'),
		'recent_products'       => esc_html__('Recent Products', 'storeone'),
		'top_rated_products'    => esc_html__('Top Rated Products', 'storeone'),
	);
	
	return apply_filters('storeone_product_tab_labels', $product_tabs);
}

function storeone_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    storeone_mini_cart();
    $fragments['#tf-bgs-cart-container > .mini-cart-container'] = ob_get_clean();
    return $fragments;
}
add_filter('add_to_cart_fragments', 'storeone_header_add_to_cart_fragment');