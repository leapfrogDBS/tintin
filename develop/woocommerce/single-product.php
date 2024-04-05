<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 
get_template_part('template-parts/hero-sections/standard-hero');
?>
	<div class="container md:flex justify-between gap-x-12 pt-1 md:py-[60px]">
		<div class="product-view md:w-9/12">
		<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action( 'woocommerce_before_main_content' );
		?>

			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>
			<?php
				/**
				 * woocommerce_after_main_content hook.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' );
			?>

		</div>
		<aside class="sidebar mt-12 md:mt-0 md:w-3/12">

			<?php 
			if ( isset( $_COOKIE['woocommerce_recently_viewed'] ) ) {
				$viewed_products = explode( ',', $_COOKIE['woocommerce_recently_viewed'] );
				
				if ( ! empty( $viewed_products ) ) { ?>
					<div class="best-sellers border-b-2 custom-border">
						<div class="accordion-button">
							<span class="chevron">
								<?php include(locate_template('assets/img/global/chevron.svg'));?>
							</span>
						<h3 class="title">Recently Viewed</h3>
						</div>
						<ul class="list-products hidden grid md:block">
							<?php
							// Reverse the array of viewed products
							$viewed_products = array_reverse( $viewed_products );
							
							foreach ( $viewed_products as $product_id ) {
								$product = wc_get_product( $product_id );
								
								if ( $product ) {
									setup_postdata( $GLOBALS['post'] = get_post( $product_id ) );
									get_template_part( 'woocommerce/content', 'sidebar-product' );
									wp_reset_postdata();
								}
							} ?>
						</ul>
					</div>
				<?php }
			}

			
				if ( function_exists( 'woocommerce_output_related_products' ) ) {
					woocommerce_output_related_products();
				}
			?>
			<?php
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 3,
				'post_status' => 'publish',
				'meta_key' => 'total_sales',
				'orderby' => 'meta_value_num',
				'order' => 'DESC',
			);

			$best_sellers_query = new WP_Query($args);

			if ($best_sellers_query->have_posts()) : ?>

				<div class="best-sellers border-b-2 custom-border">
					<div class="accordion-button">
							<span class="chevron">
								<?php include(locate_template('assets/img/global/chevron.svg'));?>
							</span>
						<h3 class="title">Best Sellers</h3>
					</div>
					<ul class="list-products hidden grid md:block">

						<?php while ($best_sellers_query->have_posts()) : $best_sellers_query->the_post(); ?>
							<?php get_template_part('woocommerce/content', 'sidebar-product'); ?>
						<?php endwhile; ?>

					</ul>
				</div>

				<?php wp_reset_postdata(); ?>

			<?php endif; ?>	
		</aside>

	</div>
	<div class="product-add-to-cart sticky bottom-0 left-0 right-0 w-full bg-white p-2 z-20 sm:hidden">
		<?php woocommerce_template_single_add_to_cart(); ?>
	</div>

<?php
get_template_part('template-parts/page-modules');
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
