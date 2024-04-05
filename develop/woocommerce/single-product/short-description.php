<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );


?>
<div class="woocommerce-product-details__short-description space-y-2 my-4">
	<?php echo $short_description; // WPCS: XSS ok. ?>
</div>

<?php
global $product;
$terms = wc_get_product_terms($product->get_id(), 'pa_character', array('fields' => 'all'));
if($terms) : ?>
<div class="featuring my-10">
	<h4 class="heading-four">Featuring:</h4>
	<div class="flex gap-2 flex-wrap mt-2 5">
		<?php
		foreach ($terms as $term) {
			$image_url = get_term_meta($term->term_id, 'character-image', true);
			if ($image_url) {
				echo '<img class="w-[45x] h-[45px] rounded-full border border-shop-front-blue" src="' . esc_url($image_url) . '" alt="' . esc_attr($term->name) . '">';
			}
		}
		?>
	</div>
</div>
<?php endif; ?>