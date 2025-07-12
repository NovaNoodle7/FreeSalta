<?php

/**
 *Exit if Kirki not exist
 */
if (!class_exists('Kirki')) {
	return;
}

Kirki::add_config('storeone_settings', array(
	'capability'  => 'edit_theme_options',
	'option_type' => 'theme_mod',
));

Kirki::add_section('storeone_homepage_layout_section', array(
	'title'    => __('Homepage Layout', 'storeone'),
	'panel'    => 'storeone_homepage',
	'priority' => 10,
));

/**
 * Homepage Layout
 */
Kirki::add_field('storeone_settings', array(
	'type'     => 'sortable',
	'section'  => 'storeone_homepage_layout_section',
	'settings' => 'storeone_homepage_layout',
	'label'    => esc_attr__('Homepage Sections', 'storeone'),
	'help'     => esc_attr__('Drag and Drop to change order of section and enable/disable any section.', 'storeone'),
	'default'  => array('slider', 'product-recent', 'product-tabs', 'testimonial', 'blog'),
	'priority' => 10,
	'choices'  => function_exists('storeone_extension')?array(
		'slider'         => esc_attr__('Slider', 'storeone'),
		'product-recent' => esc_attr__('WooCommerce Recent Products', 'storeone'),
		'product-tabs'   => esc_attr__('WooCommerce Tabs', 'storeone'),
		'testimonial'    => esc_attr__('Testimonial', 'storeone'),
		'blog'           => esc_attr__('Blog', 'storeone'),):array(
		'product-recent' => esc_attr__('WooCommerce Recent Products', 'storeone'),
		'product-tabs'   => esc_attr__('WooCommerce Tabs', 'storeone'),
		'blog'           => esc_attr__('Blog', 'storeone'),
	),
));


Kirki::add_field('storeone_settings', array(
	'type'     => 'sortable',
	'section'  => 'storeone_home_product_tabs_section',
	'settings' => 'storeone_product_tabs',
	'label'    => esc_attr__('Manage Product Tabs', 'storeone'),
	'help'     => esc_attr__('Drag and Drop to change order of tab and enable/disable any tab.', 'storeone'),
	'priority' => 10,
	'default'  => array('best_selling_products', 'sale_products', 'featured_products', 'recent_products', 'top_rated_products'),
	'choices'  => array(
		'best_selling_products' => esc_html__('Best Selling Products', 'storeone'),
		'sale_products'         => esc_html__('Sale Products', 'storeone'),
		'featured_products'     => esc_html__('Featured Products', 'storeone'),
		'recent_products'       => esc_html__('Recent Products', 'storeone'),
		'top_rated_products'    => esc_html__('Top Rated Products', 'storeone'),
	),
));



/**
 * StoreOne Customizer UI Configuration.
 */
function storeone_configuration_sample() {

	$config['color_back']   = '#192429';
	$config['color_accent'] = '#008ec2';
	$config['width']        = '25%';

	return $config;
}

add_filter('kirki/config', 'storeone_configuration_sample');