<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package storeone
 */
?>
	</div><!-- #content -->
	<!-- Footer Start -->
    <footer class="site-footer footer" role="contentinfo">
        <div class="container-fluid footer-widgets">
            <div class="container">
				<div class="row bgs-footer">
					<?php 
						$footer_widget  = array(
							'name' 			=> esc_html__( 'Footer Widget Area', 'storeone' ),
							'id' 			=> 'footer-widget-area',
							'description' 	=> esc_html__( 'footer widget area', 'storeone' ),
							'before_widget' => '<div id="%1$s" class="col-md-3 col-sm-6 widget footer-widget" style="float:left">',
							'after_widget'  => '</div>',
							'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
							'after_title'   => '</h3></div>',
						);

					   if ( is_active_sidebar( 'footer-widget-area' ) ) {
							 dynamic_sidebar( 'footer-widget-area'); 
						 }else{ 
							//the_widget('WP_Widget_Calendar', 'title='.esc_attr__('Calendar', 'storeone'), $footer_widget);
							
							the_widget('WP_Widget_Categories', null, $footer_widget);
							the_widget('WP_Widget_Pages', null, $footer_widget);
							the_widget('applinks_widget', null, $footer_widget);
							//the_widget('WP_Widget_Archives', null, $footer_widget);
						} 
					?>
				</div>
            </div>
        </div>
        <div class="conatainer-fluid footer-bar">
            <div class="container">
                <div class="col-md-4 col-sm-4 footer-copy">
                    <p>&copy; <?php echo esc_html(date_i18n(__('Y', 'storeone'))).' '; bloginfo( 'name' ); ?> </p>
                </div>
                <div class="col-md-8 col-sm-8 footer-right">
                    <?php storeone_get_social_block(); ?>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->
</div><!-- .wrapper -->
<?php wp_footer(); ?>
</body>
</html>
