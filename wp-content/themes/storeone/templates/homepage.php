<?php 
/*
* Template Name: Home Page
*/

get_header();
$hompage_sections = get_theme_mod('storeone_homepage_layout', array( 'slider', 'product-recent', 'product-tabs',  'testimonial', 'blog' ));
foreach ($hompage_sections as $key => $section) {
	get_template_part('template-parts/home', $section);	
}
get_footer();
