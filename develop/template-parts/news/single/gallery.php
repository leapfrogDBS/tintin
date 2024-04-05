<section>
    <div class="container">
        <h3 class="heading-three">Gallery</h3>

        <?php 
        $gallery_images = get_sub_field('post_gallery');
        if ($gallery_images):
            // Determine the number of columns for the desktop grid
            $image_count = count($gallery_images);
            $desktop_grid_class = 'grid-cols-1';
            if ($image_count >= 5) {
                $desktop_grid_class = 'lg:grid-cols-5';
            } elseif ($image_count == 4) {
                $desktop_grid_class = 'lg:grid-cols-4';
            } elseif ($image_count == 3) {
                $desktop_grid_class = 'lg:grid-cols-3';
            }
        ?>
            <div class="gallery grid <?php echo $desktop_grid_class; ?> xs:grid-cols-2 md:grid-cols-3 gap-10">
                <?php foreach ($gallery_images as $image): ?>
                    <img class="aspect-square" data-fancybox data-src="<?php echo esc_url($image['url']); ?>" src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
