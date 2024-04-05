<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<section>
	<div class="container">

		<div class="flex flex-col gap-y-3 sm:flex-row items-center justify-between">
			<h2 class="heading-two">Your basket</h2>
			<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="underline">Continue Shopping</a>
		</div>
		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>
			
				<table class="shop_table_items shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
					<thead class="hidden sm:table-header-group">
						<tr class="text-left p-one text-[14px] h-20">
							<th class="product-combined font-normal"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
							<th class="product-quantity font-normal"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
							<th class="product-subtotal font-normal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							// Skip if the product doesn't exist or isn't visible.
							if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) {
								continue;
							}

							?>
							<tr class="flex flex-col sm:table-row pb-6 sm:pb-0 <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

								<!-- Product (Thumbnail, Name, and Price) -->
								<td class="product-combined" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
									<div class="flex flex-col md:flex-row md:items-center gap-x-9 py-4 sm:pb-10">	
										<?php
										// Thumbnail
										echo $_product->get_image('custom_cart_thumbnail');
										echo '<div class="product-info flex flex-col gap-y-5 w-full pr-6">';
											
											// Product Name
											echo '<div>' .apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '</div>';
											
											// Product Variations
											echo tg_get_formatted_product_variations( $cart_item );

											// Product Price
											echo '<div>' .apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) . '</div>';
										echo '</div>';
										?>
									</div>
								</td>

								<!-- Quantity + Remove -->
								<td class="product-quantity " data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
									<div class="flex gap-x-6 items-center">
										<?php
										// Quantity input
										if ( ! $_product->is_sold_individually() ) {
											echo woocommerce_quantity_input( array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $_product->get_max_purchase_quantity(),
												'min_value'    => '0',
												'product_name' => $_product->get_name(),
											), $_product, false );
										}

										// Remove link
										// Remove link
										echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
											'<a href="%s" class="remove pr-6" aria-label="%s" data-product_id="%s" data-product_sku="%s">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M19 7L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 7M10 11V17M14 11V17M15 7V4C15 3.44772 14.5523 3 14 3H10C9.44772 3 9 3.44772 9 4V7M4 7H20" stroke="#133C94" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_attr__( 'Remove this item', 'woocommerce' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										), $cart_item_key );

										?>
									</div>
								</td>

								<!-- Subtotal -->
								<td class="product-subtotal text-[20px] tracking-[0.2px] mt-3 sm:mt-0" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
									<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
									?>
								</td>

							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				<button type="submit" class="btn-primary hidden" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
		
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</form>
	</div>
</section>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
