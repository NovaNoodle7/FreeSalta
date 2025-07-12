<?php if(get_theme_mod('storeone_blog_slider_enable', true)): ?>
<!-- Slider Start  -->
<div class="bps-slider blog-slider">
	<div class="owl-carousel owl-theme blog-swiper">
		<?php
			$args = array( 'post_type' => 'tf_blog_slider', 'posts_per_page' => 20, 'order'=> 'ASC');
			$query = new WP_Query( $args );
			$i = 1;
			if($query->have_posts()):
			while($query->have_posts()){
				$query->the_post();
				$slider_data 	= get_post_meta(get_the_ID(), 'tf_slider_data', true);
				$slide_link     = isset($slider_data['button_one_link'])?$slider_data['button_one_link']:'';
				?>
	        	<div class="owl-slide">
	        		<?php 
						if(has_post_thumbnail()){
							the_post_thumbnail('full', array('class' => 'img-responsive img-slide'));
						}else{
							$slide_img = get_template_directory_uri().'/images/slide'.$i.'.jpg';
							?> <img src="<?php echo esc_url($slide_img); ?>" class="img-responsive img-slide"/> <?php
						}
					?>
					<div class="overlay"></div>
	                <div class="carousel-caption">
						<?php the_title('<h2 class="bgs-slider-heading animation animated-item-1">', '</h2>'); ?>
						<div class="bgs-slider-desc animation animated-item-2"><?php echo wp_strip_all_tags(get_the_content()); ?></div>
						<?php if(!empty($slide_link)): ?>
						<a href="<?php echo esc_url($slide_link); ?>" class="btn animation animated-item-3 banner-link"> <?php echo esc_html_e('Read More', 'storeone'); ?> </a>
						<?php endif; ?>
					</div>
				</div>
				<?php
				if($i == 4){ $i = 0; }
				$i++;
			}
			wp_reset_postdata();
			else:
				get_template_part('template-parts/recent-post', 'slides');
			endif;
		?>
	</div>			
</div>
<!-- Slider End -->
<?php endif; ?>