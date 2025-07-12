<?php

/* * *
 * Theme Info
 *
 * Adds a simple Theme Info page to the Appearance section of the WordPress Dashboard.
 *
 */


// Display Theme Info page.
function storeone_theme_info_page() {
	// Get Theme Details from style.css.
	$theme = wp_get_theme();
	?>
	<div class="wrap theme-info-wrap">
		<div class="row">
			<div class="theme-left">
				<div class="theme-info-inner">
					<img src="<?php echo esc_url(get_template_directory_uri().'/screenshot.png'); ?>" class="img-responsive theme-screenshot">
				</div>
			</div>
			<div class="theme-right">
				<div class="theme-info-inner">
					<h1 class="theme-heading"> <?php esc_html_e( 'Welcome to', 'storeone'); ?> <span class="theme-name"> <?php echo esc_html($theme->get( 'Name' )) ?> </span> <span class="theme-version"> <?php echo esc_html($theme->get( 'Version' )) ?> </span> </h1>
					<div class="theme-description"><?php echo esc_html( $theme->get( 'Description' ) ); ?></div>
					<br>
					<hr>
					<div class="info-links">
							<strong><?php esc_html_e( 'Theme Links', 'storeone' ); ?></strong>
							<br>
							<br>
							<a class="button button-default" href="<?php echo esc_url( 'https://demo.themefarmer.com/storeone/' ); ?>" target="_blank"><?php esc_html_e( 'Theme Demo', 'storeone' ); ?></a>
							<a class="button button-default" href="<?php echo esc_url( 'https://www.themefarmer.com/documentation/documentation-storeone/' ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'storeone' ); ?></a>
							<a class="button button-default" href="<?php echo esc_url( 'https://www.themefarmer.com/free-themes/storeone-e-commerce-wordpress-theme/' ); ?>" target="_blank"><?php esc_html_e( 'Theme Page', 'storeone' ); ?></a>
							<a class="button button-default" href="<?php echo esc_url( 'http://wordpress.org/support/view/theme-reviews/storeone' ); ?>" target="_blank"><?php esc_html_e( 'Rate this theme', 'storeone' ); ?></a>
							<hr>
							<a class="button button-orange" href="<?php echo esc_url( 'https://www.themefarmer.com/product/storeone-pro/' ); ?>" target="_blank"><?php esc_html_e( 'View Pro Version', 'storeone' ); ?></a>
							<a class="button button-primary" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customize', 'storeone' ); ?></a>
					</div>
					<hr>
				</div>
			</div>
		</div>
	</div>
	<?php
}

// Add Theme Info page to admin menu.
function storeone_add_theme_info_page() {
	// Get Theme Details from style.css
	$theme = wp_get_theme();
	add_theme_page(sprintf( esc_html__( 'Welcome to %1$s %2$s', 'storeone' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ), esc_html__( 'Theme Info', 'storeone' ), 'edit_theme_options', 'storeone', 'storeone_theme_info_page');
}
add_action( 'admin_menu', 'storeone_add_theme_info_page' );

function storeone_theme_info_page_css( $hook ) {

	if ( 'appearance_page_storeone' != $hook ) {
		return;
	}
	wp_enqueue_style( 'storeone-theme-info-style', get_template_directory_uri() . '/css/theme-info.css' );
}
add_action( 'admin_enqueue_scripts', 'storeone_theme_info_page_css' );
