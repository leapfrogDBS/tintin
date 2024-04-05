<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tintin
 */

get_header();
?>




<?php get_template_part('template-parts/hero-sections/standard-hero'); ?>
<?php get_template_part('template-parts/news/single/full-width'); ?>

<?php get_template_part('template-parts/post-modules'); ?>

<?php get_template_part('template-parts/news/single/pagination'); ?>
<?php get_template_part('template-parts/news/single/related-posts'); ?>




<?php
get_footer();
