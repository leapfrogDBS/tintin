<section>
    <div class="container">
        <?php 
        $contained_image = get_sub_field('contained_image');
        if ($contained_image) : ?>
            <img class="w-full h-full" src="<?php echo esc_url($contained_image['url']); ?>" alt="<?php echo esc_attr($contained_image['alt']); ?>">
        <?php endif; ?>
    </div>
</section>
