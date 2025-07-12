<form role="search" method="get" class="search-form storeone-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="col-md-12">
		<label  class="search-label">
			<span class="screen-reader-text"><?php esc_html_e('Search for:','storeone'); ?></span>
			<div class="bgs-search-group">				
				<?php 
					$swp_cat_dropdown_args = array(
						'taxonomy' 		   => 'product_cat',
						'show_option_all'  => esc_html__( 'All', 'storeone'),
						'name'             => 'product_cat',
						'class'            => 'bgs-search-cats',
						'value_field'	   => 'slug',
						'selected'         => (isset($_GET['product_cat']) && $_GET['product_cat'])?sanitize_text_field($_GET['product_cat']):false,
					);
					wp_dropdown_categories( $swp_cat_dropdown_args );
				 ?>
				<input type="search" class="input-search" placeholder="<?php esc_attr_e('Search ','storeone'); ?>" value="<?php the_search_query(); ?>" name="s" title="<?php esc_attr_e('Search for:','storeone'); ?>">
				<input type="hidden" name="post_type" value="product">
				<button type="submit" class="bgs-search-submit" ><i class="fa fa-search"></i></button>
			</div>
		</label>
	</div>
</form>