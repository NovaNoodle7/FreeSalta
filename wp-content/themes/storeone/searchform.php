<form role="search" method="get" class="search-form storeone-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="col-md-12 form-group">
		<label  class="search-label">
			<span class="screen-reader-text"><?php esc_html_e('Search for:','storeone'); ?></span>
			<input type="search" class="blog-search input-search" placeholder="<?php esc_attr_e('Search ','storeone'); ?>" value="<?php the_search_query(); ?>" name="s" title="<?php esc_attr_e('Search for:','storeone'); ?>">
		</label>
	</div>
</form>