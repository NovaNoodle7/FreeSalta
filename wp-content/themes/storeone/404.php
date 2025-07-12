<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package storeone
 */
get_header(); 
?>
<div class="container-fluid bgs-space bgs-404-page">
	<div class="container">
		<div class="col-md-12 bgs-error">
				<section class="error-404 not-found">
					<div class="col-md-12 page-header error">
							<h2 class="code-404"><?php esc_html_e('404', 'storeone') ?></h4>
							<h2 class="title-404"><span class="fa fa-exclamation-circle"></span><?php esc_html_e('ERROR','storeone'); ?></h2>
							<h3><?php esc_html_e('Page cannot be found','storeone'); ?></h3>
							<p><?php esc_html_e('The Page you requested is not be found. This could be spelling error in the url.','storeone'); ?></p>
							<a href="<?php echo esc_url(home_url()); ?>" class="btn btn-theme"><?php esc_html_e('Go back to homepage','storeone'); ?></a>
					</div><!-- .page-header -->	
				</section><!-- .error-404 -->
		</div><!-- #primary -->
	</div>
</div>
<?php
get_footer();
