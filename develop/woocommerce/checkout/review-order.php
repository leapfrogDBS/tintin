<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

 defined( 'ABSPATH' ) || exit;
 ?>
 <div class="shop_table woocommerce-checkout-review-order-table">

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
		<div class="border border-shop-front-blue py-6 px-10 mb-10 shipping-selection">
	 		<h3 class="heading-three mb-6">Shipping</h3>
			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
		</div>
	<?php endif; ?>
 
 <div class="border border-shop-front-blue py-6 px-10">
	 <h3 class="heading-three mb-6">Your Order</h3>
	 <div class="flex flex-col">
 
		 <?php
		 do_action( 'woocommerce_review_order_before_cart_contents' );
 
		 foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			 $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
 
			 if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				 ?>
				 <div class="flex mb-4 gap-4 flex-col sm:flex-row border-b border-shop-front-blue border-opacity-20 pb-6 <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					 <div class="product-thumbnail max-w-[70px] flex-none">
						 <?php
						 $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
						 if ( ! $_product->is_visible() ) {
							 echo $thumbnail; 
						 } else {
							 printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
						 }
						 ?>
					 </div>
					 <div class="product-name flex-grow">
						 <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
						 <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
						 <?php echo '<div class="mt-4">' . tg_get_formatted_product_variations( $cart_item ) . '</div>';?>
					 </div>
					 <div class="product-total flex-none">
						 <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
					 </div>
				 </div>
				 <?php
			 }
		 }
 
		 do_action( 'woocommerce_review_order_after_cart_contents' );
		 ?>
 
		 <!-- Footer Section (Subtotal, Shipping, etc.) -->
		 <div class="flex flex-col checkout-totals">
			 
		 	<div class="flex justify-between cart-subtotal">
				 <div><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
				 <div><?php wc_cart_totals_subtotal_html(); ?></div>
			 </div>

			 <div class="flex justify-between shipping-total">
				<div><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></div>
				<div>
					<?php if ( WC()->cart->needs_shipping() && WC()->cart->get_cart_shipping_total() ) : ?>
						<?php echo WC()->cart->get_cart_shipping_total(); ?>
					<?php else : ?>
						<?php esc_html_e( 'To be calculated', 'woocommerce' ); ?>
					<?php endif; ?>
				</div>
			</div>


 
			 <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				 <div class="flex justify-between cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					 <div><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
					 <div><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
				 </div>
			 <?php endforeach; ?>
 
			 
 
			 <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
				 <div class="flex justify-between fee">
					 <div><?php echo esc_html( $fee->name ); ?></div>
					 <div><?php wc_cart_totals_fee_html( $fee ); ?></div>
				 </div>
			 <?php endforeach; ?>
 
			 <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
				 <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
					 <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
						 <div class="flex justify-between tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
							 <div><?php echo esc_html( $tax->label ); ?></div>
							 <div><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
						 </div>
					 <?php endforeach; ?>
				 <?php else : ?>
					 <div class="flex justify-between tax-total">
						 <div><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></div>
						 <div><?php wc_cart_totals_taxes_total_html(); ?></div>
					 </div>
				 <?php endif; ?>
			 <?php endif; ?>
 
			 <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
 
			 <div class="flex justify-between order-total">
				 <div><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
				 <div><?php wc_cart_totals_order_total_html(); ?></div>
			 </div>
 
			 <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
		 </div>
	 </div>
 </div>
 
</div>