<div class="hidden left-0 right-0 absolute mega-menu-content bg-covers-white shadow-custom border-t-2 custom-border">
    <div class="container grid grid-cols-5">
        <div class="col-span-4 columns-4">
            <?php
            $menu_name = 'mega-menu-categories'; // Replace with your menu's slug
            $locations = get_nav_menu_locations();
            $menu = wp_get_nav_menu_object($locations[$menu_name]);
            $menu_items = wp_get_nav_menu_items($menu->term_id);

            foreach ($menu_items as $item) {
                if ('product_cat' === $item->object) {
                    $category = get_term($item->object_id, 'product_cat');
                    if (!$category) continue;
                    $category_link = get_permalink(wc_get_page_id('shop')) . '?filter_category=' . $category->term_id;

                    echo '<div class="mb-6 break-inside-avoid">';
                    echo '<a href="' . esc_url($category_link) . '" class="p-one font-bold pb-3">' . esc_html($category->name) . '</a>';

                    // Get and display subcategories
                    $subcategories = get_terms('product_cat', array(
                        'parent' => $category->term_id,
                        'hide_empty' => false,
                    ));
                    echo '<ul class="!mt-0">';
                    foreach ($subcategories as $subcategory) {
                        $subcategory_link = get_permalink(wc_get_page_id('shop')) . '?filter_category=' . $category->term_id . '&filter_subcategory=' . $subcategory->term_id;
                        echo '<li><a class="p-one font-normal text-[14px] mb-1" href="' . esc_url($subcategory_link) . '">' . esc_html($subcategory->name) . '</a></li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <div class="col-span-1">
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>/#best-sellers">
                <img class="w-full h-auto" src="<?php echo esc_url( get_template_directory_uri()); ?>/assets/img/global/bestsellers.jpg" alt="best-sellers">
            </a>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var shopMenuItem = document.querySelector('.shop-item');
    var megaMenu = document.querySelector('.mega-menu-content');
    var hideTimeout;

    shopMenuItem.addEventListener('mouseenter', function() {
        clearTimeout(hideTimeout);
        megaMenu.classList.remove('hidden');
        shopMenuItem.classList.add('mega-menu-open'); 
    });

    shopMenuItem.addEventListener('mouseleave', function() {
        hideTimeout = setTimeout(function() {
            if (!megaMenu.matches(':hover')) {
                megaMenu.classList.add('hidden');
                shopMenuItem.classList.remove('mega-menu-open');
            }
        }, 300); // Delay in milliseconds
    });

    megaMenu.addEventListener('mouseenter', function() {
        clearTimeout(hideTimeout);
    });

    megaMenu.addEventListener('mouseleave', function() {
        megaMenu.classList.add('hidden');
        shopMenuItem.classList.remove('mega-menu-open');
    });
});

</script>