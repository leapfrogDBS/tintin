<section id="best-sellers" class="bg-covers-yellow text-shop-front-blue">
    <div class="container">
        <div class="flex justify-center sm:justify-between items-center">
            <h2 class="heading-two text-center sm:text-left">Best Sellers</h2>
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
                    // Check if the repeater field has rows of data
                    if (have_rows('best_selling_products')):

                        // Loop through the rows of data
                        while (have_rows('best_selling_products')) : the_row();

                            // Get the post object
                            $post_object = get_sub_field('best_selling_product');

                            if ($post_object):
                                // Setup the post data
                                $post = $post_object;
                                setup_postdata($post);

                                // Now you can use $post as usual
                                global $product;
                                ?>
                                <li class="splide__slide flex flex-col bg-covers-white text-center group">
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="overflow-hidden">
                                            <?php echo get_the_post_thumbnail($product->get_id(), 'product_previews', array('class' => 'w-full h-auto transition-transform duration-500 ease-in-out transform xs:group-hover:scale-110')); ?>
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
                                                        $category_link = get_permalink(wc_get_page_id('shop')) . '?filter_category=' . $category->term_id;
                                                        $links[] = '<a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a>';
                                                    }
                                                }
                                                echo implode(', ', $links);
                                            }
                                            ?>
                                        </p>
                                        <p class="p-two"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                                    </div>
                                </li>
                                <?php
                                // Reset the global post object so that the rest of the page works correctly
                                wp_reset_postdata();
                            endif;

                        endwhile;
                    endif;
                    ?>
                </ul>
            </div>
        </div>
        <div class="btn-container">
            <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn btn-medium bg-shop-front-blue sm:hidden shop-link">Shop all products</a>
        </div>

    </div>
</section>      