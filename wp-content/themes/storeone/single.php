<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package storeone
 */
get_header(); 

?>
<div class="container-fluid bgs-space bgs-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-9 bgs-blog-right">
                <div class="bps-slingle"> 
                <?php
                    while ( have_posts() ) : the_post();
                    ?>
                        <?php get_template_part('template-parts/content','single'); ?>
                        <div class="clearfix"></div>
                        <div class="bgs-pagination col-md-12">
                            <?php the_post_navigation(); ?>
                        </div>
                        <div class="clearfix"></div>
                    <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                    endwhile; // End of the loop.
                ?>
                </div>
               
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php
get_footer();
