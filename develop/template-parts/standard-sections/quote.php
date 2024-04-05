<?php
    $link_to_product = get_sub_field('link_to_product');
    $quotation_link = get_sub_field('quotation_link');
    $quotation_link_url;
    if($link_to_product && $quotation_link) {
        $quotation_link_url = get_permalink($quotation_link->ID);
    }
?>

<div <?php if (!empty($quotation_link_url)) : ?>onclick="window.location.href='<?php echo esc_url($quotation_link_url); ?>'"<?php endif; ?> class="bg-covers-turquoise text-white <?php if (!empty( $quotation_link_url)) : ?>cursor-pointer<?php endif; ?>">
    <div class="container grid grid-cols-1 gap-y-10 sm:grid-cols-2 items-center pb-0 sm:py-0">
        <?php 
        $image_right = get_sub_field('image_right');
        $quotation_image = get_sub_field('quotation_image');
        $image_order_class = $image_right ? 'sm:order-2' : 'sm:order-1';
        $text_order_class = $image_right ? 'sm:order-1' : 'sm:order-2';
        ?>

        <div class="quotation <?php echo $text_order_class; ?>">
            <div class="quote">
                <?php echo get_sub_field('quotation_quote'); ?>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                <div class="source">
                    <?php echo get_sub_field('quotation_source'); ?>
                </div>
                <?php if (get_sub_field('quotation_title')): ?>
                    <svg class="hidden sm:block" xmlns="http://www.w3.org/2000/svg" width="6" height="7" viewBox="0 0 6 7" fill="none">
                        <circle cx="3" cy="3.5" r="3" fill="white"/>
                    </svg>
                    <div class="title">
                        <?php echo get_sub_field('quotation_title'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($quotation_image)): ?>
            <img src="<?php echo esc_url($quotation_image['url']); ?>" alt="<?php echo esc_attr($quotation_image['alt']); ?>" class="w-full h-auto <?php echo $image_order_class; ?>">
        <?php endif; ?>
    </div>
</div>
