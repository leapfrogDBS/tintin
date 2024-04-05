
<section style="background-image: url(<?php echo esc_url( get_template_directory_uri()); ?>/assets/img/bg-example2.jpg);">
    <div class="container !w-full">
        <div class="flex justify-center sm:justify-between items-center text-white">
            <h2 class="heading-two text-center sm:text-left">Related Posts</h2>
            <div class="btn-container">
                <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="btn btn-medium bg-covers-orange hidden sm:flex">View all</a>
            </div>
        </div>

        <div class="grid sm:grid-cols-3 gap-8 lg:gap-9">
        <?php
            // Get category IDs of the current post
            $categories = get_the_category($post->ID);
            $category_ids = array();

            if (!empty($categories)) {
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }
            }

            // Only proceed if there are category IDs
            if (!empty($category_ids)) {
                $args = array(
                    'category__in' => $category_ids, 
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'post__not_in' => array($post->ID),
                    'orderby' => 'rand' 
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        global $post;
                        ?>
                        <a href="<?php the_permalink(); ?>" class="flex flex-col bg-covers-white text-shop-front-blue">
                            <?php the_post_thumbnail('news_previews', array( 'class' => 'w-full h-auto object-cover aspect-[2/1]' )); ?>
                            
                            <div class="flex flex-col gap-y-3 justify-around pt-6 pb-10 px-5">
                                <h4 class="heading-four"><?php the_title(); ?></h4>
                                <p class="p-one"><?php echo wp_strip_all_tags(get_the_excerpt()); ?></p>                                    
                            </div>
                        </a>
                        <?php
                    }
                }
            }
            wp_reset_postdata();
            ?>
        </div>
        
        <div class="btn-container">
            <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="btn btn-medium bg-covers-orange sm:hidden">View all</a>
        </div>

    </div>
</section>