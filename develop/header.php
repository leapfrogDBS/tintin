<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site bg-covers-white">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'tintin' ); ?></a>
    
        <header id="masthead" class="site-header">
          <?php get_template_part('template-parts/announcement'); ?>
          <div class="header-container">
            <nav class="left-site-navigation">
                <!-- Left Menu -->
                <?php wp_nav_menu( 
                    array( 
                        'theme_location' => 'menu-left',
                        'menu_id' => 'left-menu',
                        'container' => false,
                        'items_wrap' => '<ul class="desktop menu-links">%3$s</ul>',
                        
                    ) 
                ); ?>
                <div class="lg:hidden">
                    <a href="#search-container" data-fancybox class="relative [&_svg]:transition-opacity outline-0 float-left">
                        <?php include(locate_template('assets/img/nav/search.svg'));?>
                    </a>
                </div>
            </nav>

            <div class="site-branding">
                <!-- Logo -->
                <div class="logo-container">
                    <?php the_custom_logo(); ?>
                </div>
            </div>

            <nav class="right-site-navigation">
                <!-- Right Menu -->
                <?php wp_nav_menu( 
                    array( 
                        'theme_location' => 'menu-right', 
                        'menu_id' => 'right-menu', 
                        'container' => false,
                        'items_wrap' => '<ul class="desktop menu-links">%3$s</ul>', 
                        'walker' => new Custom_Walker_Nav_Menu(),
                    ) 
                ); ?>

                <div id="nav-toggle" data-navtoggle class="mobile-menu-icon">
                    <?php include(locate_template('assets/img/nav/hamburger.svg'));?>
                </div>

                <div class="desktop basket-search">
                <?php 
                    // Basket icon
                    if ( function_exists('wc_get_cart_url') ) :?>
                        <div>
                            <a class="relative block" href="<?php echo wc_get_cart_url();?>">
                                <?php include(locate_template('assets/img/nav/basket.svg'));?>

                                <div class="cart-contents text-shop-front-blue header-cart-count transition-opacity rounded-sm px-1 font-sans absolute text-[10px] font-bold right-1/2 translate-x-1/2 -mr-[4px] bottom-full leading-none
                                    <?php echo ( WC()->cart->get_cart_contents_count() > 0 ) ? 'opacity-100' : 'opacity-0';?>
                                    "><?php echo WC()->cart->get_cart_contents_count(); ?>
                                </div>
                            </a>
                            
                        </div>
                    <?php endif;?>

                    <div>
                        <a href="#search-container" data-fancybox  class="relative [&_svg]:transition-opacity outline-0 float-left">
                            <?php include(locate_template('assets/img/nav/search.svg'));?>
                        </a>
                    </div>
                </div>

                <div id="menu-flyout-blocker" data-navtoggle class="fixed cursor-pointer inset-0 z-30 bg-covers-white invisible opacity-0 transition-[opacity,visibility] duration-300"></div>
                <div id="menu-flyout" class="pointer-events-auto fixed transition-transform duration-300 ease-in-out flex top-0 right-0 h-full w-full bg-background text-black pt-[120px] font-wsans translate-x-full z-30">
                    <div class="container flex flex-col items-center pt-28 justify-center">
                        <div class="basket-search flex gap-x-5">
                            <?php 
                                // Basket icon
                                if ( function_exists('wc_get_cart_url') ) :?>
                                    <div>
                                        <a class="relative block pb-6" href="<?php echo wc_get_cart_url();?>">
                                            <?php include(locate_template('assets/img/nav/basket.svg'));?>

                                            <div class="cart-contents text-shop-front-blue header-cart-count transition-opacity rounded-sm px-1 font-sans absolute text-[10px] font-bold right-1/2 translate-x-1/2 -mr-[4px] bottom-full leading-none
                                                <?php echo ( WC()->cart->get_cart_contents_count() > 0 ) ? 'opacity-100' : 'opacity-0';?>
                                                "><?php echo WC()->cart->get_cart_contents_count(); ?>
                                            </div>
                                        </a>
                                        
                                    </div>
                                <?php endif;?>
                        </div>
                        <div class="menu !mt-0">
                            <?php wp_nav_menu( 
                                array( 
                                    'theme_location' => 'menu-left', 
                                    'menu_id' => 'left-menu', 
                                    'container' => false,
                                    'items_wrap' => '<ul class="mobile menu-links justify-start">%3$s</ul>', 
                                ) 
                            ); ?>
                            <?php wp_nav_menu( 
                                array( 
                                    'theme_location' => 'menu-right', 
                                    'menu_id' => 'right-menu', 
                                    'container' => false,
                                    'items_wrap' => '<ul class="mobile menu-links justify-end">%3$s</ul>', 
                                ) 
                            ); ?>
                        </div>

                    </div>
                </div>

            </nav>
        </div>
        <?php get_template_part('template-parts/mega-menu'); ?>
        </header><!-- #masthead -->
        
    

