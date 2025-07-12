<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package storeone
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url', 'display' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div  class="wrapper site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'storeone' ); ?></a>
	
	<header id="masthead" class="site-header nav-down" role="banner">
		<div class="header-topbar">
			<div class="container">
				<div class="pull-left">
					<?php storeone_get_social_block(); ?>
				</div>
				<div class="pull-right">
					<?php echo storeone_get_page_links_html(); ?>
				</div>
			</div>
		</div>
		<div class="header-middle">
			<div class="container">
				<div class="col-md-3 site-branding">
					<?php
						if ( function_exists( 'the_custom_logo' ) && function_exists( 'has_custom_logo' ) && has_custom_logo()) :
							
							if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title"><?php the_custom_logo();?></h1>
							<?php else : ?>
								<p class="site-title"><?php the_custom_logo();?></p>
							<?php
							endif;
						else :
							if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php
							endif;
							$description = get_bloginfo( 'description', 'display' );
							if ( $description || is_customize_preview() ) : ?>
								<p class="site-description"><?php echo $description; ?></p>
							<?php
							endif; 
						endif;
					?>	
				</div><!-- .site-branding -->
				<div class="col-md-6 search-container">
					<?php 
						if(storeone_is_wc()){
							get_template_part('searchform-product');
						}else{
							get_search_form();
						}
					 ?>
				</div>
				<div class="col-md-3 info-banner">
					<div class="contact-info">
						<?php $top_phone = get_theme_mod('storeone_top_phone'); if(!empty($top_phone)): ?>
						<div class="call-info">
							<a href="callto:<?php echo esc_attr($top_phone); ?>" class="info-link call-us-link"><i class="fa fa-phone"></i> <?php esc_html_e('Call Us:','storeone'); ?> <?php echo esc_html($top_phone); ?> </a>
						</div>
						<?php endif; ?>
						<?php $top_email = get_theme_mod('storeone_top_email'); if(!empty($top_email)): ?>
						<div class="mail-info">
							<a href="mailto:<?php echo esc_attr($top_email); ?>" class="info-link mail-us-link"><i class="fa fa-envelope"></i> <?php esc_html_e('Mail Us:','storeone'); ?> <?php echo esc_html($top_email); ?> </a>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="header-bottom">
				<!-- Primary Nav Start-->
				<div class="container">
				    <div id="tf-bgs-cart-container" class="bgs-cart-container pull-right">
						<?php storeone_mini_cart(); ?>
					</div>
				    <div class="bgs-menu-container pull-left">
					    <nav class="navbar navbar-default bgs-menu">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#TF-Navbar">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>                        
								</button>
								
							</div>			
							<?php 
								$args = array(
												'theme_location'    => 'primary',
												'depth'             =>  0,
												'container'         => 'div',
												'container_class'   => 'collapse navbar-collapse',
												'container_id'      => 'TF-Navbar',
												'menu_class'        => 'nav navbar-nav',
												'fallback_cb'       => 'storeone_fallback_page_menu',
												'walker'            => new storeone_nav_walker()
									  );
								wp_nav_menu($args);
							?>
						</nav>
					</div>
				</div>
				<!-- Primary Nav End-->
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
