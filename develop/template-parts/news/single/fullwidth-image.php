<section>
    <?php 
    $fullwidth_image = get_sub_field('fullwidth_image');
    if ($fullwidth_image) : ?>
        <img class="w-full h-full" src="<?php echo esc_url($fullwidth_image['url']); ?>" alt="<?php echo esc_attr($fullwidth_image['alt']); ?>">
    <?php endif; ?>
</section>
