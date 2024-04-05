<?php
// Retrieve the ID of the current post
$post_modules_id = get_the_ID();

// Check if the flexible content field has rows of data for the current post
if (have_rows('post_modules', $post_modules_id)) :
    // Loop through the rows of data
    while (have_rows('post_modules', $post_modules_id)) : the_row();

        // Use a switch statement to handle different layouts for the post
        switch (get_row_layout()) {
            // Define cases for each layout in your 'Post Modules'
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
    // No layouts found
endif;
?>
