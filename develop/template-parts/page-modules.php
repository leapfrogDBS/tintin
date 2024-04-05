<?php
// Determine the correct context for the modules
if (is_singular('product')) {
    $page_modules_id = 'option';
} elseif (is_home() && get_option('page_for_posts')) {
    $page_modules_id = get_option('page_for_posts');
} elseif (is_shop()) {
    $page_modules_id = wc_get_page_id('shop');
} else {
    $page_modules_id = get_the_ID();
}

// Check if the flexible content field has rows of data
if (have_rows('page_modules', $page_modules_id)) :
    // Loop through the rows of data
    while (have_rows('page_modules', $page_modules_id)) : the_row();

        // Use a switch statement to handle different layouts
        switch (get_row_layout()) {
            case 'page_modules_quotation_image_section':
                get_template_part('template-parts/standard-sections/quote');
                break;
            case 'page_modules_new_arrivals':
                get_template_part('template-parts/woocommerce/new-arrivals');
                break;
            case 'page_modules_best_sellers':
                get_template_part('template-parts/woocommerce/best-sellers');
                break;
            case 'page_modules_shop_by_category':
                get_template_part('template-parts/woocommerce/woocommerce-categories');
                break;
            case 'page_modules_latest_news':
                get_template_part('template-parts/news/latest-news');
                break;
            case 'page_modules_image_and_content_section':
                get_template_part('template-parts/standard-sections/image-content');
                break;
            case 'post_modules_slider_copy':
                get_template_part('template-parts/news/single/slider-copy');
                break;
            case 'post_modules_fullwidth_image':
                get_template_part('template-parts/news/single/fullwidth-image');
                break;
            case 'post_modules_contained_image':
                get_template_part('template-parts/news/single/contained-image');
                break;
            case 'post_modules_video':
                get_template_part('template-parts/news/single/video');
                break;
            case 'post_modules_quotation':
                get_template_part('template-parts/news/single/quotation');
                break;
            case 'post_modules_gallery':
                get_template_part('template-parts/news/single/gallery');
                break;      
            case 'post_modules_full_width_text':
                get_template_part('template-parts/news/single/full-width-text');
                break; 
            case 'post_modules_dashed_line':
                get_template_part('template-parts/news/single/dashed-line');
                break;         

        }

    endwhile;
else :
    
endif;
?>