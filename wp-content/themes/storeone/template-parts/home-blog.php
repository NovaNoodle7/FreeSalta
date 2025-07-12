<!-- Our Blog Start-->
<div class="container-fluid bgs-space bgs-blogs">
	<div class="container">
		<div class="row bgs-heading">
			<h2 class="section-heading"><span> <?php echo esc_html(get_theme_mod('storeone_home_blog_heading')); ?></span></h2>
			<p class="section-description"> <?php echo esc_html(get_theme_mod('storeone_home_blog_desc')); ?> </p>
		</div>
		<div class="row bgs-home-blog">
			<?php 
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array( 'post_type' => 'post', 'paged'=>$paged, 'posts_per_page' => 3, 'ignore_sticky_posts' => 1, );
				$query = new WP_Query( $args );
				while($query->have_posts()){
					$query->the_post();
					get_template_part('template-parts/content','home');
				}
				wp_reset_postdata(); 
			?>
		</div>
	</div>
</div>
<!-- Our Blog End -->