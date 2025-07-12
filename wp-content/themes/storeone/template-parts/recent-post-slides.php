<?php 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array( 'post_type' => 'post', 'paged'=>$paged, 'posts_per_page' => 4);
	$rp_query = new WP_Query( $args );
	$i =1;
	while($rp_query->have_posts()){
		$rp_query->the_post();
		?>
		<div class="owl-slide">
			<?php 
				if(has_post_thumbnail()): 
				the_post_thumbnail('full', array('class' => 'img-slide post-blog-slide'));
				else: ?>
    			<img src="<?php echo esc_url(get_template_directory_uri().'/images/shop-slide'.$i.'.jpg'); ?>" class="img-slide"/>
			<?php endif; ?>
			<div class="overlay"></div>
            <div class="carousel-caption">
            	<?php the_title( '<h2 class="bgs-slider-heading animation animated-item-1">', '</h2>' ); ?>
				<div class="bgs-slider-desc animation animated-item-2"><?php the_excerpt(); ?></div>
				<?php $slide_link = get_theme_mod('storeone_blog_slide_button_link'); if (!empty($slide_link)): ?>
				<a href="<?php echo esc_url($slide_link); ?>" class="btn banner-link animation animated-item-3"> <?php echo esc_html(get_theme_mod('storeone_blog_slide_button_text')); ?> </a>
				<?php endif; ?>
			</div>
		</div>
		<?php
		$i++;	
	}
	wp_reset_postdata(); 
?>