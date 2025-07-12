<?php

function storeone_settings_control($wp_customize) {
	
	$wp_customize->add_section('storeone_setup_info', array(
		'title'    => __('Theme Setup Info', 'storeone'),
		'priority'   => 1,
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_setting('storeone_homepage_setup', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'storeone_sanitize_html',

	));

	$wp_customize->add_control(new StoreOne_Info_Text($wp_customize, 'storeone_homepage_setup',
		array(
			'label'    => __('Home Page Setup', 'storeone'),
			'description' => __('1. Create or Edit page with name Home -> Select Template "Home Page" -> Publish. <br><br>
    							2. Go To Appearance -> Customize -> Static Front Page -> Front page displays set it to "A static page" -> for Front page select Home. <a class="storeone_go_to_section" href="#accordion-section-static_front_page"> Switch To "A Static Page"</a>', 'storeone'),
			'priority' => 1,
			'section'  => 'storeone_setup_info',
	)));

	$wp_customize->add_setting('storeone_theme_info_page', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'storeone_sanitize_html',

	));

	$wp_customize->add_control(new StoreOne_Info_Text($wp_customize, 'storeone_theme_info_page',
		array(
			'label'    => __('StoreOne Info Page', 'storeone'),
			'description' => sprintf('<a class="button button-default" href="%1$s">%2$s</a>', esc_url(admin_url('themes.php?page=storeone')), esc_html__('See Theme Info Page', 'storeone')),
			'priority' => 1,
			'section'  => 'storeone_setup_info',
	)));
	
	$wp_customize->add_panel( 'storeone_homepage', array(
		'priority'	 => 2,
		'title'		 => __( 'Homepage Options', 'storeone' ),
	));

/** Social **/
	$wp_customize->add_section('storeone_socials_section', array(
		'title'      => __('Social Options', 'storeone'),
		'priority'   => 10,
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_setting('storeone_social_new_tab', array(
			'default'           => true,
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'storeone_sanitize_checkbox',
	));

	$wp_customize->add_control('storeone_social_new_tab', array(
		'type'     => 'checkbox',
		'priority' => 200,
		'section'  => 'storeone_socials_section',
		'label'    => __('Open social links in new tab', 'storeone'),
	));

	$wp_customize->add_setting('storeone_social_link_facebook', array(
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'storeone_sanitize_url',
	));

	$wp_customize->add_control('storeone_social_link_facebook', array(
		'type'     => 'url',
		'priority' => 200,
		'section'  => 'storeone_socials_section',
		'label'    => __('Facebook Page URL', 'storeone'),
	));

	$wp_customize->add_setting('storeone_social_link_google', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'storeone_sanitize_url',
	));

	$wp_customize->add_control('storeone_social_link_google', array(
		'type'     => 'url',
		'priority' => 200,
		'section'  => 'storeone_socials_section',
		'label'    => __('Google Page URL', 'storeone'),
	));

	$wp_customize->add_setting('storeone_social_link_youtube', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'storeone_sanitize_url',
	));

	$wp_customize->add_control('storeone_social_link_youtube', array(
		'type'     => 'url',
		'priority' => 200,
		'section'  => 'storeone_socials_section',
		'label'    => __('Youtube Page URL', 'storeone'),
	));

	$wp_customize->add_setting('storeone_social_link_twitter', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'storeone_sanitize_url',
	));

	$wp_customize->add_control('storeone_social_link_twitter', array(
		'type'     => 'url',
		'priority' => 200,
		'section'  => 'storeone_socials_section',
		'label'    => __('Twitter Page URL', 'storeone'),
	));

	$wp_customize->add_setting('storeone_social_link_instagram', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'storeone_sanitize_url',
	));

	$wp_customize->add_control('storeone_social_link_instagram', array(
		'type'     => 'url',
		'priority' => 200,
		'section'  => 'storeone_socials_section',
		'label'    => __('Instagram Page URL', 'storeone'),
	));

	$wp_customize->add_setting('storeone_social_link_linkedin', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'storeone_sanitize_url',
	));

	$wp_customize->add_control('storeone_social_link_linkedin', array(
		'type'     => 'url',
		'priority' => 200,
		'section'  => 'storeone_socials_section',
		'label'    => __('Linkedin Page URL', 'storeone'),
	));

/** Social **/

/* Contact */
	$wp_customize->add_section('storeone_contacts_section', array(
		'title'      => __('Contact Options', 'storeone'),
		'priority'   => 10,
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_setting('storeone_top_email', array(
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'storeone_sanitize_email',
	));

	$wp_customize->add_control('storeone_top_email', array(
		'type'     => 'email',
		'priority' => 200,
		'section'  => 'storeone_contacts_section',
		'label'    => __('Email', 'storeone'),
	));

	$wp_customize->add_setting('storeone_top_phone', array(
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('storeone_top_phone', array(
		'type'     => 'text',
		'priority' => 200,
		'section'  => 'storeone_contacts_section',
		'label'    => __('Phone', 'storeone'),
	));
/* Contact */


/** Recent Products **/

	$wp_customize->add_section('storeone_home_recent_product_section', array(
		'title'      => __('Recent Products', 'storeone'),
		'priority'   => 30,
		'panel'		 => 'storeone_homepage',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_setting('storeone_home_recent_product_heading', array(
		'default'           => __('Latest In Product', 'storeone'),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('storeone_home_recent_product_heading', array(
		'type'     => 'text',
		'priority' => 1,
		'section'  => 'storeone_home_recent_product_section',
		'label'    => __('Heading', 'storeone'),
	));

	$wp_customize->add_setting('storeone_home_recent_product_desc', array(
		'default'           => __('Description Latest Product', 'storeone'),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('storeone_home_recent_product_desc', array(
		'type'     => 'text',
		'priority' => 2,
		'section'  => 'storeone_home_recent_product_section',
		'label'    => __('Description', 'storeone'),
	));

	$wp_customize->add_setting('storeone_home_recent_product_count', array(
		'default'           => 15,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control('storeone_home_recent_product_count', array(
		'type'     => 'number',
		'priority' => 3,
		'section'  => 'storeone_home_recent_product_section',
		'label'    => __('Product Count', 'storeone'),
	));

/** Recent Products **/

/** Product Tabs **/

	$wp_customize->add_section('storeone_home_product_tabs_section', array(
		'title'      => __('Product Tabs', 'storeone'),
		'priority'   => 40,
		'panel'		 => 'storeone_homepage',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_setting('storeone_home_product_tabs_heading', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('storeone_home_product_tabs_heading', array(
		'type'     => 'text',
		'priority' => 1,
		'section'  => 'storeone_home_product_tabs_section',
		'label'    => __('Heading', 'storeone'),
	));

	$wp_customize->add_setting('storeone_home_product_tabs_desc', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('storeone_home_product_tabs_desc', array(
		'type'     => 'text',
		'priority' => 2,
		'section'  => 'storeone_home_product_tabs_section',
		'label'    => __('Description', 'storeone'),
	));

	$wp_customize->add_setting('storeone_home_product_tabs_count', array(
		'default'           => 8,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control('storeone_home_product_tabs_count', array(
		'type'     => 'number',
		'priority' => 3,
		'section'  => 'storeone_home_product_tabs_section',
		'label'    => __('Product Count', 'storeone'),
	));

/** Product Tabs **/

/** Latest Posts **/

	$wp_customize->add_section('storeone_home_blog_section', array(
		'title'      => __('Latest Posts', 'storeone'),
		'priority'   => 70,
		'panel'		 => 'storeone_homepage',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_setting('storeone_home_blog_heading', array(
		'default'           => __('Our Blog', 'storeone'),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('storeone_home_blog_heading', array(
		'type'     => 'text',
		'priority' => 1,
		'section'  => 'storeone_home_blog_section',
		'label'    => __('Heading', 'storeone'),
	));

	$wp_customize->add_setting('storeone_home_blog_desc', array(
		'default'           => __('Be updated with latest news', 'storeone'),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('storeone_home_blog_desc', array(
		'type'     => 'text',
		'priority' => 2,
		'section'  => 'storeone_home_blog_section',
		'label'    => __('Description', 'storeone'),
	));

	$wp_customize->add_setting('storeone_home_blog_count', array(
		'default'           => 3,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control('storeone_home_blog_count', array(
		'type'     => 'number',
		'priority' => 3,
		'section'  => 'storeone_home_blog_section',
		'label'    => __('Post Count', 'storeone'),
	));

/** Latest Posts **/

	$wp_customize->add_section(new StoreOne_Upsale_Customize_Control($wp_customize, 'storeone-upsell', array(
		'priority' => '200',
	)));

	$wp_customize->get_section('title_tagline')->priority     = 10;
	$wp_customize->get_section('static_front_page')->priority = 30;
	$wp_customize->get_section('header_image')->priority      = 50;

	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
	$wp_customize->get_setting('background_color')->transport = 'postMessage';
}

add_action('customize_register', 'storeone_settings_control');

function storeone_customize_preview_js() {
	wp_enqueue_script( 'storeone-customizer-preview-script', get_template_directory_uri() . '/js/customizer.js', array('jquery', 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'storeone_customize_preview_js' );

function storeone_custmizer_style() {
	wp_enqueue_style('storeone-customizer-style', get_template_directory_uri() . '/css/customizer-style.css');
}
add_action('customize_controls_print_styles', 'storeone_custmizer_style');

function storeone_customize_controls_scripts(){
	wp_enqueue_script( 'storeone-customizer-controls', get_template_directory_uri() . '/js/customizer-controls.js', array('jquery'), '20151215', true );
}
add_action( 'customize_controls_enqueue_scripts',   'storeone_customize_controls_scripts' );

if (class_exists('WP_Customize_Control')):
	class StoreOne_Info_Text extends WP_Customize_Control {

		public function render_content() {
			?>
			    <span class="customize-control-title">
					<?php echo esc_html($this->label); ?>
				</span>

				<?php if ($this->description) {?>
					<span class="description customize-control-description">
					<?php echo wp_kses_post($this->description); ?>
					</span>
				<?php }
		}

	}

	class StoreOne_Upsale_Customize_Control extends WP_Customize_Section {
		public $type = 'themefarmer-upsell';
		public function render() {
			$classes = 'accordion-section control-section-' . $this->type;
			$id      = 'themefarmer-upsell-buttons-section';
			?>
		    <li id="accordion-section-<?php echo esc_attr($this->id); ?>"class="<?php echo esc_attr($classes); ?>">
		        <div class="themefarmer-upsale">
		          	<a href="<?php echo esc_url('https://www.themefarmer.com/product/storeone-pro/'); ?>" target="_blank" class="themefarmer-upsale-bt" id="themefarmer-pro-button"><?php esc_html_e('VIEW PRO VERSION ', 'storeone');?></a>
		        </div>
		    </li>
		    <?php
		}
	}

endif;

?>
