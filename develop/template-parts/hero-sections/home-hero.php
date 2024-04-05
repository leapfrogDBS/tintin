<section class="relative">
    <div class="overlay bg-shop-front-blue opacity-95 absolute left-0 top-0 right-0 bottom-0 z-10"></div>
    <div class="container md:py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-24 gap-y-12 items-center">
            
            <div class="md:order-2 flex flex-col items-stretch md:w-[80%] h-full md:justify-around">
                <div class="relative space-y-[40px] text-white">
                    <h3 class="heading-three text-center md:text-left"><?php echo the_field('pre_title'); ?></h3>
                    <h1 class="heading-one text-center md:text-left"><?php echo the_field('main_title'); ?></h1>
                    <div class="btn-container flex justify-center md:justify-start">
                        <a href="<?php echo get_permalink( get_option( 'woocommerce_shop_page_id' ) ); ?>" class="btn btn-large bg-covers-orange w-auto shop-link">Shop now</a>
                    </div>
                </div>
            </div>

            <?php if( have_rows('products_showcase') ):
                    $hide_product_titles = get_field('hide_product_titles');
             ?>
                <div id="home-hero-splide" class="splide md:order-1" data-splide='{"type": "loop", "autoplay": true, "interval": 3000, "pagination": false, "arrows": false}'>
                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php
                            while ( have_rows('products_showcase') ) : the_row();
                                $product_post = get_sub_field('hero_product');
                                $custom_image = get_sub_field('custom_image');
                                if( $product_post ):
                                    setup_postdata($product_post);
                                    ?>
                                    <li class="splide__slide">
                                        <a href="<?php echo get_permalink($product_post->ID); ?>" class="product-image">
                                            <?php if( $custom_image) : ?>
                                                <img src="<?php echo esc_url($custom_image['url']); ?>" alt="<?php echo esc_attr($custom_image['alt']); ?>" class="w-full aspect-square">
                                            <?php else: ?>
                                                <?php echo get_the_post_thumbnail($product_post->ID, 'full', ['class' => 'w-full aspect-square']); ?>
                                            <?php endif; ?>
                                            <?php if(!$hide_product_titles) : ?>
                                                <h3 class="heading-four text-white text-center mt-5"><?php echo get_the_title($product_post->ID); ?></h3>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    <?php
                                    wp_reset_postdata(); // Reset the global post object
                                endif;
                            endwhile;
                            ?>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="fallback-image">
                    <img src="<?php echo esc_url( get_template_directory_uri()); ?>/assets/img/hero/hero.png" alt="Fallback Image">
                </div>
            <?php endif; ?>


        </div>  
    </div>
    <div class="img-test absolute left-0 lg:left-[-15%] top-0 h-full w-full lg:w-[115%] bg-no-repeat bg-[length:150%] lg:bg-[length:80%]"></div>
</section>
                
            



