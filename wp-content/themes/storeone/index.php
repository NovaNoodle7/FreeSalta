<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package storeone
 */
get_header();

?>
<div class="container-fluid bgs-space bgs-blog">
	<div class="container">
		<div class="row">			
			<div id="bgs-blog-content" class="col-md-9 bgs-blog-right">
				<?php get_template_part('template-parts/slider', 'blog'); ?>
				<?php if ( have_posts() ) : ?>
					<div class="row blog-gallery bgs-posts">
					<?php 
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content', 'index' );
						endwhile;
					?>
					</div>
					<div class="clearfix"></div>
					<div class="bgs-pagination col-md-12">
						<?php the_posts_pagination(); ?>
					</div>
				<?php
					else :
						get_template_part( 'template-parts/content', 'none' );
				endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php
get_footer();
