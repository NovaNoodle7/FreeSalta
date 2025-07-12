<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package storeone
 */?>
<div id="secondary" class="col-md-3 bgs-sidebar shop-sidebar" role="complementary">
<?php
	if (is_active_sidebar( 'sidebar-shop' ) ) {
		 dynamic_sidebar( 'sidebar-shop' ); 
	}
?>
</div><!-- #secondary -->