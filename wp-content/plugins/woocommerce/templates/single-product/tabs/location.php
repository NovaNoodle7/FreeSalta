<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
//global $product;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) ) );

function the_content_map_olny() {
		global $post;
		global $wp_current_filter;

		// Get maps associated with post
		$mapids = Mappress_Map::get_list($post->ID, 'ids');
		//var_export($mapids);
		if (empty($mapids))
			return $content;

		// Add the shortcode once for each map
		$shortcodes = "";
		foreach($mapids as $mapid)
			$shortcodes .= '<p>[mappress mapid="' . $mapid . '" zoom="15"]</p>';
		if ($autodisplay == 'top')
			return $shortcodes . $content;
		else
			return $shortcodes;
	}
?>

<?php if ( $heading ) : ?>
  <h2>Ubicaci&oacute;n</h2>
<?php endif; ?>

<?php 
echo do_shortcode(the_content_map_olny());

//the_content("",1);
//echo  the_content_map_olny();
?>
