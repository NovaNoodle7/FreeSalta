<?php
/**
 * Template Name: Full Width
 * 
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
 * 
 */
get_header();
?>
<div class="container-fluid bgs-space bgs-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12 bgs-blog-right">
                <div class="bgs-page bps-slingle">
                <?php
                    while ( have_posts() ) : the_post();
                    ?>
                            <?php get_template_part('template-parts/content','page'); ?>
                    <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                    endwhile; // End of the loop.
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
