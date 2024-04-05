<?php
/**
 * Single Product Image
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
    return;
}

global $product;

$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();
$default_image_thumb_src = wp_get_attachment_image_url($post_thumbnail_id, 'thumb-400x400');
$default_image_full_src = wp_get_attachment_image_url($post_thumbnail_id, 'full');
?>

<div class="!mt-0" 
     data-default-image="<?php echo esc_url($default_image_thumb_src); ?>" 
     data-default-image-full="<?php echo esc_url($default_image_full_src); ?>">
    <?php if ( $attachment_ids ) : ?>
        <div class="splide space-y-9" role="group" aria-label="Product Images" 
             data-splide='{"arrows": false, "pagination": true, "type": "loop", "perPage": 1,
                           "breakpoints": {"768": {"gap": "0"}}}'>
            <div class="splide__track">
                <ul class="splide__list product-image-splide-list">
                    <?php if ( $post_thumbnail_id ) : ?>
                        <li class="splide__slide w-full">
                            <a class="pt-[100%] relative block" data-fancybox data-src="<?php echo wp_get_attachment_image_url($post_thumbnail_id, 'full');?>">
                                <?php echo wp_get_attachment_image($post_thumbnail_id, 'thumb-400x400', false, ['class' => 'w-full h-full object-cover absolute inset-0']); ?>
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="splide__slide w-full">
                            <div class="pt-[100%] relative">
                                <img class="w-full h-full object-cover absolute inset-0" src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="400" height="400" alt=""/>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php foreach ( $attachment_ids as $attachment_id ) : ?>
                        <li class="splide__slide w-full">
                            <a class="pt-[100%] relative block" data-fancybox data-src="<?php echo wp_get_attachment_image_url($attachment_id, 'full');?>">
                                <?php echo wp_get_attachment_image($attachment_id, 'thumb-400x400', false, ['class' => 'w-full h-full object-cover absolute inset-0']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php else : ?>
        <figure class="single-image relative pt-[100%]" <?php echo $post_thumbnail_id ? 'data-fancybox data-src="'.esc_url($default_image_full_src).'"' : ''; ?>>
            <?php
                if ($post_thumbnail_id) {
                    echo wp_get_attachment_image($post_thumbnail_id, 'thumb-400x400', false, ['class' => 'w-full h-full object-cover absolute inset-0']);
                } else {
                    echo '<img class="w-full h-full object-cover absolute inset-0" src="'.esc_url(wc_placeholder_img_src()).'" alt="Placeholder" width="400px" height="400px" />';
                }
            ?>
        </figure>
    <?php endif; ?>
</div>
