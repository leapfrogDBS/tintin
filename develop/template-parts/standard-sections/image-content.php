<?php
// Retrieve custom field values
$bg_colour = get_sub_field('ci_background_colour');
$bg_image = get_sub_field('ci_background_image');
$bg_fixed = get_sub_field('ci_background_fixed') ? 'bg-fixed' : '';
$content_image = get_sub_field('ci_image');
$desktop_order = get_sub_field('ci_desktop_order');
$ci_content = get_sub_field('ci_content');
$ci_text_colour = get_sub_field('ci_text_colour');

// Determine the background style
$background_style = '';
if ($bg_image) {
    $background_style = "background-image: url('".$bg_image['url']."');";
} elseif ($bg_colour) {
    $background_style = "background-color: ".$bg_colour.";";
}

// Determine the text color class
$text_color_class = '';
if ($ci_text_colour === 'Blue') {
    $text_color_class = 'text-shop-front-blue';
} elseif ($ci_text_colour === 'White') {
    $text_color_class = 'text-white';
}

// Apply the bg-fixed class if set
$background_class = $bg_fixed;

// Determine the order classes based on the selection
$content_order_class = $desktop_order === 'Image Right' ? 'md:order-1 mr-0 ml-auto' : 'md:order-2';
$image_order_class = $desktop_order === 'Image Right' ? 'md:order-2' : 'md:order-1';
?>
<section class="<?php echo $background_class; ?>" style="<?php echo $background_style; ?>">
    <div class="container grid md:grid-cols-2 items-center gap-x-20 gap-y-10">
        <div class="content-area flex flex-col <?php echo $content_order_class; ?> lg:max-w-[450px]">
            <div class="wysiwyg <?php echo $text_color_class; ?>">
                <?php echo $ci_content; ?>
            </div>
            <?php if (have_rows('ci_buttons')): ?>
                <div class="flex gap-3 md:gap-x-6 flex-wrap mt-6">
                    <?php while (have_rows('ci_buttons')) : the_row();
                        $ci_button_text = get_sub_field('ci_button_text');
                        $ci_button_bg_color = get_sub_field('ci_button_bg_color');
                        $ci_button_link = get_sub_field('ci_button_link');

                         // Determine button background and border class
                        switch ($ci_button_bg_color) {
                            case 'Orange':
                                $button_class = 'bg-covers-orange';
                                break;
                            case 'Blue':
                                $button_class = 'bg-shop-front-blue';
                                break;
                            case 'Transparent':
                                $button_class = 'bg-transparent border-2 border-white';
                                break;
                            default:
                                $button_class = '';
                        }
                        // Get link details
                        $button_url = $ci_button_link['url'];
                        $button_title = $ci_button_link['title'];
                        $button_target = $ci_button_link['target'] ? $ci_button_link['target'] : '_self';
                    ?>
                        <div class="btn-container w-auto">
                            <a href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>" class="btn btn-medium <?php echo $button_class; ?>">
                                <?php echo esc_html($ci_button_text); ?>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
        <img class="<?php echo $image_order_class; ?> w-full" src="<?php echo esc_url($content_image['url']); ?>" alt="<?php echo esc_attr($content_image['alt']); ?>">
    </div>
</section>
