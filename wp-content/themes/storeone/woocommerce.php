<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package storeone
 */
get_header();
$page_class = (is_shop() && is_active_sidebar( 'sidebar-shop' ))?'col-md-9':'col-md-12';

?>
<div class="container-fluid bgs-space bgs-blog">
    <div class="container">
        <div class="row">
            <div class="<?php echo esc_attr($page_class); ?> col-md-9 bgs-blog-left">
                <div class="row blog-gallery bgs-posts">
                <?php //bgs-products
                //product-gallery bgs-woocommerce left-sidebar
                //row blog-gallery bgs-posts
                //bgs-page bps-slingle
                    if(is_shop() && !is_search()){
                        get_template_part('template-parts/slider-shop');
                    }
                ?>
                <?php if ( have_posts() ) : ?>
                    <?php woocommerce_content(); ?>
                <?php endif; ?> 
                </div>
                <div class="clearfix"></div>
                <div class="bgs-pagination col-md-12">
                    <?php the_posts_pagination(); ?>
                </div>
            </div>
            <?php 
                get_sidebar(); 
                
                //if(!is_product() && is_active_sidebar( 'sidebar-shop' )){
                //get_sidebar('shop'); 
                //}
            ?>
           
        </div>
    </div>
</div>
<?php
get_footer();
