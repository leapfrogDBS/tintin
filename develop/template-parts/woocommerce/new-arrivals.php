<section class="bg-covers-yellow text-shop-front-blue">
    <div class="container">
        <div class="flex justify-center sm:justify-between items-center">
            <h2 class="heading-two text-center sm:text-left">New arrivals</h2>
            <div class="btn-container">
                <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn btn-medium bg-shop-front-blue hidden sm:flex shop-link">Shop all</a>
            </div>
        </div>

        <div id="new-arrivals-splide" class="splide" data-splide='{
            "type": "loop",
            "perPage": 4,
            "perMove": 1,
            "gap": "2vw",
            "pagination": false,
            "arrows": false,
            "pauseOnHover": true,
            "autoplay": true,
            "breakpoints": {
                "1200": {"perPage": 3},
                "880": {"perPage": 2},
                "680": {"perPage": 1, "pagination": true}
            }
            }'>
            <div class="splide__track">
                <ul class="splide__list">
                    <?php
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'date', 
                        'order' => 'DESC',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                'terms' => 'tintin-products' 
                            ),
                        ),
                    );
                    $query = new WP_Query($args);

                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            global $product;
                            ?>
                                <li class="splide__slide flex flex-col bg-covers-white text-center group">
                                    <a href="<?php echo get_permalink(); ?>">
                                        <div class="overflow-hidden">
                                            <?php echo get_the_post_thumbnail($product->get_id(), 'product_previews', array( 'class' => 'w-full h-auto transition-transform duration-500 ease-in-out transform xs:group-hover:scale-110' )); ?>
                                        </div>
                                    </a>
                                    <div class="flex flex-col gap-y-2 justify-start h-full p-5">
                                        <p class="p-one italic text-[14px]">
                                            <?php
                                            // Fetch product categories
                                            $product_categories = get_the_terms($product->get_id(), 'product_cat');
                                            if (!empty($product_categories) && !is_wp_error($product_categories)) {
                                                $links = array();
                                                foreach ($product_categories as $category) {
                                                    // Check if the category is a top-level category
                                                    if ($category->parent === 0) {
                                                        // Generate the URL to the shop page with a category filter
                                                        $category_link = get_permalink(wc_get_page_id('shop')) . '?filter_category=' . $category->term_id;
                                                        $links[] = '<a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a>';
                                                    }
                                                }
                                                // Join the links with commas and echo
                                                echo implode(', ', $links);
                                            }
                                            ?>
                                        </p>
                                        <p class="p-two"><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></p> 
                                    </div>
                                </li>
                            <?php
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
        </div>
        <div class="btn-container">
            <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn btn-medium bg-shop-front-blue sm:hidden shop-link">Shop all products</a>
        </div>

    </div>
</section>      