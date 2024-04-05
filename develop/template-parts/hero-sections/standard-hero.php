<section id="standard-hero">
    <?php
    $title = '';
    $bg_image_url = '';

    if (is_shop() || is_product_category() || is_product()) {
        // Shop Page
        $title = get_the_title(wc_get_page_id('shop'));
        $bg_image_url = get_the_post_thumbnail_url(wc_get_page_id('shop'));
    } elseif (is_page()) {
        // Regular Page
        $title = get_the_title(get_queried_object_id());
        $bg_image_url = get_the_post_thumbnail_url(get_queried_object_id());
    } elseif (is_single()) {
        // Single Post
        $title = get_the_title();
        $bg_image_url = get_the_post_thumbnail_url(get_the_ID());
    } elseif (is_home() && get_option('page_for_posts')) {
        // Posts Page
        $title = get_the_title(get_option('page_for_posts'));
        // You can set a fallback image for the posts page here if needed
        $bg_image_url = get_the_post_thumbnail_url(get_queried_object_id());
    }

    // Fallback image URL
    $fallback_image_url = get_template_directory_uri() . '/assets/img/global/hero-fallback.jpeg';

    // Use fallback image if $bg_image_url is empty
    if (empty($bg_image_url)) {
        $bg_image_url = $fallback_image_url;
    }

    ?>

    <div class="bg-image" style="background-image: url(<?php echo esc_url($bg_image_url); ?>)"></div>
    <div class="container pt text-white text-center">
    <?php 
        if (is_product()) {
            // For single product pages, display WooCommerce breadcrumbs
            woocommerce_breadcrumb();
        } else {
            // For other pages, display custom breadcrumbs
            custom_breadcrumbs();
        }
        ?>
        <h1 class="heading-one"><?php echo esc_html($title); ?></h1>
    </div>
</section>
