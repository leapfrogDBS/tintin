<?php
/**
 * The blog page template
 *
 * This template is used to display a page that shows blog posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tintin
 */

get_header();
get_template_part('template-parts/hero-sections/standard-hero');
?>

<section>
    <div id="news-posts-container" class="container text-shop-front-blue grid-layout">

        <div class="filters flex flex-col md:flex-row gap-y-10 md:items-center justify-between pb-8 border-b-2 custom-border">
            <div class="categories flex flex-col sm:flex-row items-center gap-x-10 gap-y-4">
                <h4 class="heading-four leading-none">Filter by:</h4>
                
                <select id="categoryDropdown" class="md:hidden mobile-category-dropdown bg-white py-2 px-4 border-2 border-shop-front-blue outline-none" onchange="handleCategoryChange()">
                    <option value="all">All</option>
                    <?php 
                    $categories = get_categories();
                    foreach ($categories as $category) {
                        echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                    }
                    ?>
                </select>
                
                <?php 
                $categories = get_categories();
                echo '<div class="category-filter items-center gap-x-8 p-one hidden md:flex">';
                echo '<button class="active" data-category="all">All</button>';
                foreach ($categories as $category) {
                    echo '<button data-category="' . $category->slug . '">' . $category->name . '</button>';
                }
                echo '</div>';
                ?>
            </div>
        
            <div class="view-as flex flex-col sm:flex-row items-center gap-x-10 gap-y-4">
                <h4 class="heading-four leading-none">View as:</h4>
                <div class="layout-filter flex items-center gap-x-8 p-one">
                    <button id="list-view" class="filter-btn">List</button>
                    <button id="grid-view" class="filter-btn active">Grid</button>
                </div>
            </div>
        </div>
        <?php

    $args = array(
        'posts_per_page' => -1,
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1
    );
    $the_query = new WP_Query($args);

    echo '<div id="content-area">';

    if ($the_query->have_posts()) :
        echo '<div id="posts-container" class="grid-layout">';
        while ($the_query->have_posts()) : $the_query->the_post();

            get_template_part('template-parts/news/news-card');

        endwhile;
        echo '</div>';

        // Add pagination
        echo '<div class="pagination">';
        echo paginate_links(array(
            'total' => $the_query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
        ));
        echo '</div>';

    endif;

    wp_reset_postdata();

    echo '</div>';
    ?>
    </div>
</section>


<?php 

get_template_part('template-parts/page-modules');

get_footer(); ?>

