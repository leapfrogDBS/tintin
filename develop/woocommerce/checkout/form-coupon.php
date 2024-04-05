<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>

<div class="container py-0">
	<div class="mt-10">

		<div class="woocommerce-form-coupon-toggle heading-four mb-2">
			<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'woocommerce' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' ); ?>
		</div>

		<form class="checkout_coupon woocommerce-form-coupon border border-shop-front-blue py-6 px-10" method="post">

			<h3 class="heading-three mb-6 mt-4"><?php esc_html_e( 'Discount Codes', 'woocommerce' ); ?></h3>

			<div class="flex items-center justify-between gap-x-10 gap-y-4 mb-6 flex-wrap">
				<input type="text" name="coupon_code" class="input-text !mb-0 !w-full" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
				<button type="submit" class="btn btn-small bg-shop-front-blue <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
			</div>
			<p class="p-one text-shop-front-blue opacity-50 text-[12px] tracking-[0.12px] leading-[1.5]">Please note: You must enter the code above AND use your academic email address at checkout to qualify for student discount.</p>
		</form>
	</div>
</div>

