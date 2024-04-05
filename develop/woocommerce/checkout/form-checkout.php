	<?php
	/**
	 * Checkout Form
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
	 *
	 * HOWEVER, on occasion WooCommerce will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * the readme will list any important changes.
	 *
	 * @see https://docs.woocommerce.com/document/template-structure/
	 * @package WooCommerce\Templates
	 * @version 3.5.0
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	do_action( 'woocommerce_before_checkout_form', $checkout );

	// If checkout registration is disabled and not logged in, the user cannot checkout.
	if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
		echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
		return;
	}

	?>
	<section>
		<div class="container">
			
	
			
			<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

				<?php if ( $checkout->get_checkout_fields() ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
					<div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-16 xl:gap-x-32">
					<div id="customer_details">
						<div class="flex justify-between items-center mb-10 flex-col md:flex-row gap-6">
							<h2 class="heading-two">Secure Checkout</h2>
							<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="p-one underline text-right">Continue Shopping</a>
						</div>

						<?php if ( ! is_user_logged_in() ) : ?>
							<div class="woocommerce-form-login-toggle">
								<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox flex justify-between items-center mb-6">
									<span class="heading-three">Returning customer?</span>
									<input id="toggle-login-form-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox w-5 h-5" type="checkbox" />
								</label>

								<div id="woocommerce-login-form-wrapper" style="display: none;">
									<div class="woocommerce-form-login-form">
										<?php woocommerce_login_form(
											array(
												'message'  => '', // Moved the label to outside the form
												'redirect' => wc_get_checkout_url(),
												'hidden'   => false,
											)
										); ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						

						
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						
					</div>
					
					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

					<?php endif; ?>
					<div id="order-summary-container">
					
						<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
																		
						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

						<div id="order_review" class="woocommerce-checkout-review-order">
							<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						</div>

						<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

					</div>
				</div>

			</form>
		</div>
	</section>

	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
    var loginCheckbox = document.getElementById('toggle-login-form-checkbox');
    var loginFormWrapper = document.getElementById('woocommerce-login-form-wrapper');

    if (loginCheckbox) {
        loginCheckbox.addEventListener('change', function() {
            if (this.checked) {
                loginFormWrapper.style.display = 'block';
            } else {
                loginFormWrapper.style.display = 'none';
            }
        });
    }
});

	</script>