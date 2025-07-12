<?php if (function_exists('storeone_extension')): ?>
<!-- Testimonial Start -->
<div class="container-fluid bgs-testimonial bgs-space">
	<div class="container">
		<div class="row bgs-heading">
			<h2 class="section-heading"><span> <?php echo esc_html(get_theme_mod('storeone_testimonial_heading')); ?></span></h2>
			<p class="section-description"> <?php echo esc_html(get_theme_mod('storeone_testimonial_desc')); ?> </p>
		</div>
		<div class="bgs-home-testimonial">
			<div class="owl-carousel owl-theme testimonial-swiper">
			<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array( 'post_type' => 'tf_testimonials', 'paged'=>$paged, 'posts_per_page' => 20, 'order' => 'ASC');
				$query = new WP_Query( $args );
				while($query->have_posts()){
					$query->the_post();
					$tf_testimonials_data       = get_post_meta($post->ID, 'tf_testimonials_data', true);
	                $testimonial_website        = ((isset($tf_testimonials_data['wesite'])) ? $tf_testimonials_data['wesite'] : '');
					?>
					<div class="owl-slide home-testimonial">
						<div class="testimonial-inner">
							<div class="name-img">
							<?php 
								if(has_post_thumbnail()){
									?> <div class="testi-img-con"> <?php
									the_post_thumbnail('thumbnail', array('class' => 'img-responsive testi-img'));
									?> </div> <?php
								}
							?>
							<?php the_title('<div class="testi-name">', '</div>') ?>
							</div>
							<?php if(!empty($testimonial_website)): ?>
							<div class="testi-link"><?php echo esc_html($testimonial_website); ?></div>
							<?php endif; ?>
							<div class="testi-desc"><?php echo wp_strip_all_tags(get_the_content()); ?></div>
						</div>
					</div>
					<?php
				}
				wp_reset_postdata();
			?>
			</div>
		</div>
	</div>
</div>
<!-- Testimonial End -->
<?php endif; ?>