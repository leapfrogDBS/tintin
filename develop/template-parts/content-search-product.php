<div <?php wc_product_class(); ?>>
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="search-product flex gap-x-5 mb-4">
        <div class="product-image flex-shrink-0 w-[72px]">
            <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
        </div>
        <div class="product-info text-[14px] block">
            <?php
            /**
             * Hook: woocommerce_shop_loop_item_title.
             * @hooked woocommerce_template_loop_product_title - 10
             */
            do_action( 'woocommerce_shop_loop_item_title' );

            /**
             * Hook: woocommerce_after_shop_loop_item_title.
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
        </div>
    </a>
</div>