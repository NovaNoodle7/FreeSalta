<div id="post-<?php the_ID(); ?>" <?php post_class("col-md-12 bgs-page bgs-post-page"); ?>>
	<?php if(has_post_thumbnail()): ?>
	<div class="img-thumbnail">
		<?php the_post_thumbnail('storeone-blog', array( 'class' => 'img-responsive' )); ?>
	</div>
	<?php endif; ?>
	<div class="bgs-page-content">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-content">
			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'storeone' ),
					'after'  => '</div>',
				) );
			?>
			<div class="clearfix"></div>
		</div><!-- .entry-content -->
	</div>
</div>
<div class="clearfix"></div>