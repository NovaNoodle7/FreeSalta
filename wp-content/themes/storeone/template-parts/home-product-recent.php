<?php if(storeone_is_wc()): ?>
<!-- Product  Start -->
<div class="container-fluid bgs-recent-products bgs-products bgs-space">
	<div class="container">
		<div class="row bgs-heading">
			<h2 class="section-heading"><span> <?php echo esc_html(get_theme_mod('storeone_home_recent_product_heading')); ?></span></h2>
			<p class="section-description"> <?php echo esc_html(get_theme_mod('storeone_home_recent_product_desc')); ?> </p>
		</div>
		<div class="bgs-home-products bgs-recents woocommerce">
			<div class="row bgs-product-carasol products owl-carousel">
			<?php
				$product_count = absint(get_theme_mod('storeone_home_recent_product_count', 15));
				$query_args = array( 'post_type' => 'product', 'stock' => 1, 'posts_per_page' => $product_count, 'orderby' =>'date','order' => 'DESC' );
				$products = new WP_Query( $query_args );
				$catorgies = array();
				while($products->have_posts()){
					$products->the_post();
					$cats = get_the_terms(get_the_ID(), 'product_cat');
					if($cats){
						foreach ($cats as $key => $cat) {
							$catorgies[$cat->slug] = $cat->name;
						}
					}
					wc_get_template_part( 'home-carousel-product' ); 
				}
				wp_reset_postdata();
			?>
			</div>
			<?php if($catorgies): ?>
			<div class="cat-nav">
				<button class="btn btn-theme btn-active btn-filter" data-filter="*"><?php esc_html_e('All', 'storeone') ?></button>
				<?php 
					foreach($catorgies as $key => $category) {
						printf(' <button class="btn btn-theme btn-filter" data-filter="%1$s">%2$s</button>', esc_attr($key), esc_html($category));
					} 
				?>
			</div>
			<?php endif; ?>
			<div class="clearfix"></div>
            <div class="bgs-pagination col-md-12">
                <?php the_posts_pagination(); ?>
            </div>
		</div>
	</div>
</div>
<!-- Product End -->
<?php endif; ?>