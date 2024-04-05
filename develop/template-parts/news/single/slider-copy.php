<section>
    <div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-6">
        <div class="lg:col-span-1">
            <?php if (have_rows('sc_slide_images')): ?>
                <div id="splide" class="splide" data-splide='{"type": "loop", "perPage": 1, "perMove": 1, "pagination": true, "arrows": false, "pauseOnHover": true, "autoplay": true}'>
                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php while (have_rows('sc_slide_images')) : the_row(); 
                                $slide_image = get_sub_field('sc_slide_image');
                            ?>
                                <li class="splide__slide">
                                    <img src="<?php echo esc_url($slide_image['url']); ?>" alt="<?php echo esc_attr($slide_image['alt']); ?>">
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="lg:col-span-2">
            <div class="container p-0">
                <div class="wysiwyg">
                    <?php the_sub_field('sc_content'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
