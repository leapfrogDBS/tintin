<section class="bg-fixed" style="background-image: url(<?php echo esc_url( get_template_directory_uri()); ?>/assets/img/bg-example.jpg);">
    <div class="container grid md:grid-cols-2 items-center gap-x-20 gap-y-10">
        <div class="content-area text-shop-front-blue flex flex-col space-y-7 md:order-2 lg:max-w-[430px]">
            <h2 class="heading-two">The Tintin Shop</h2>
            <p class="p-one">Lorem ipsum dolor sit amet consectetur. Ut eu est fringilla odio duis ut varius sagittis in. Habitant pellentesque etiam in nulla. Quisque scelerisque condimentum semper cras sed diam et. Neque quis suspendisse nisi varius.</p>
            <p class="p-one">In semper in elit tortor. Tristque quis mauris nibh posuere. Euismod nam egestas id ante ornare pretium cras.</p>
            <div class="flex gap-3 md:gap-x-6 md:flex-wrap">
                <div class="btn-container w-full md:w-auto">
                    <a href="#" class="btn btn-medium bg-shop-front-blue">More about us</a>
                </div>
                <div class="btn-container w-full md:w-auto">
                    <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn btn-medium bg-covers-orange shop-link">Shop Now</a>
                </div>
            </div>
        </div>
        <img class="md:order-1 w-full" src="<?php echo esc_url( get_template_directory_uri()); ?>/assets/img/TintinShopFront1.png" alt="">
    </div>
</section>