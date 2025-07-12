<div id="post-<?php the_ID(); ?>" <?php post_class("col-md-4 col-sm-6 bgs-post home-post"); ?>>
	<div class="post-inner">
		<div class="img-thumbnail">
			<?php if(has_post_thumbnail()): ?>
			<?php the_post_thumbnail('storeone-thumb', array( 'class' => 'img-responsive' )); ?>
			<?php else: ?>
				<img src="<?php echo esc_url(get_template_directory_uri().'/images/featured-image-340x225.png'); ?>" class="img-responsive">
			<?php endif; ?>
			<div class="overlay">
				<a class="bgs-blog-more" href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Read More', 'storeone'); ?>"><i class="fa fa-angle-right"></i></a>
			</div>
		</div>
		<div class="bgs-post-content">
			<?php if ( 'post' === get_post_type() ): ?>
			<time class="bgs-date entry-date published" datetime="<?php echo esc_attr( get_the_date( 'c' )); ?>">
				<div class="bds-date-block bds-day"><?php the_time( 'd',  get_the_ID()); ?></div>
				<div class="bds-date-block bds-month"><?php the_time( 'M, Y',  get_the_ID()); ?></div>
			</time>
			<?php endif; ?>
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<div class="entry-summary"><?php the_excerpt(); ?></div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>