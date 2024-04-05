<?php
/**
 * Cart errors page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/cart-errors.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="container">
<h2 class="heading-two">There are some issues with the items in your cart.</h2>
<p><?php esc_html_e( 'Please go back to the cart page and resolve these issues before checking out.', 'woocommerce' ); ?></p>


<?php do_action( 'woocommerce_cart_has_errors' ); ?>

    <p><a class="btn btn-small text-shop-front-blue bg-white pb-[10px] px-[24px] pt-[14px]" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Return to cart', 'woocommerce' ); ?></a></p>

</div>