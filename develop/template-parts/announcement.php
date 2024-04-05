<?php
// Check if the announcement bar should be shown
if (get_field('show_announcement_bar', 'option')): 
    // Get ACF field values
    $announcement_text = get_field('announcement_text', 'option');
    $announcement_discount_code = get_field('announcement_discount_code', 'option');
    $announcement_bg_image = get_field('announcement_background_image', 'option');
    $announcement_button_link = get_field('announcement_button_link', 'option');
    $background_overlay_colour = get_field('background_overlay_colour', 'option') ?: '#0D4E33'; // Default color if not set
    $hide_mobile = get_field('hide_on_mobile', 'option');
    $hide_class = $hide_mobile ? 'hidden md:block' : '';

    // Set background image style if available
    $background_style = '';
    if (!empty($announcement_bg_image) && isset($announcement_bg_image['url'])) {
        $background_style = "background-image: url(" . esc_url($announcement_bg_image['url']) . "); background-size: cover; background-position: center; background-repeat: no-repeat";
    }
    ?>

    <div id="announcement-bar" class="<?php echo $hide_class; ?> w-full z-40 shadow-announcement relative" style="background-color: <?php echo esc_attr($background_overlay_colour); ?>; <?php echo $background_style; ?>">
        <div class="container pt-4 pb-5 md:py-3 flex items-center justify-center md:gap-x-6 text-white mx-auto">
            <div class="promo-text flex flex-col items-center gap-y-2 md:flex-row gap-x-1">
                <p class="p-one font-bold text-[20px] md:text-[16px] text-center md:text-left"><?php echo esc_html($announcement_text); ?></p>
                <p class="p-one text-[12px] md:text-[16px] text-center md:text-left">when you use code <span class="font-bold"><?php echo esc_html($announcement_discount_code); ?></span> at checkout</p>
            </div>
            <div class="btn-container">
                <a href="<?php echo !empty($announcement_button_link) && isset($announcement_button_link['url']) ? esc_url($announcement_button_link['url']) : '#'; ?>" class="font-tintin text-[16px] border border-white pt-2 pb-1 px-3 hidden md:block">Shop Now</a>
            </div>
        </div>
    </div>

<?php endif; ?>
