<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package storeone
 */
get_header(); 

?>
<div class="container-fluid bgs-space bgs-blog">
	<div class="container">
		<div class="row">
			<div class="col-md-9 bgs-blog-right">
					<?php
					if ( have_posts() ) : ?>

						<div class="page-header">
							<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'storeone' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</div><!-- .page-header -->

						<div id="bgs-blog-content" class="row blog-gallery bgs-posts search-result">
						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

						endwhile;
						?>
						</div>
						<div class="row bgs-pagination">
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
