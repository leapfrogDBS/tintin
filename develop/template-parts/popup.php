<?php
// Fetch ACF field values
$selected_popup = get_field('select_popup_to_show', 'option');
$time_delay = get_field('time_delay_seconds', 'option');
$cookie_duration = get_field('hide_for_repeat_visitors_days', 'option');

// Map the ACF 'select_popup_to_show' values to popup IDs
$popup_map = array(
    'Subscribe' => '#popup-content-1',
    'Student Discount' => '#popup-content-2'
);

// Determine which popup ID to show based on ACF field
$popup_id_to_show = isset($popup_map[$selected_popup]) ? $popup_map[$selected_popup] : '';
?>



<div class="!bg-[#FDEEE4] max-h-[80vh] lg:max-w-[60%]" id="popup-content-1" style="display:none;">
    <div class="py-6 md:px-12 lg:px-24 flex flex-col items-center gap-y-4">
        <h2 class="heading-two text-shop-front-blue text-center">Subscribe to our newsletter</h2>
        <p class="p-one text-shop-front-blue text-center">Sign up for a 10% discount on your next order!</p>
        <?php 
            // Fetch the shortcode from ACF field
            $subscribe_form_shortcode = get_field('subscribe_form_shortcode', 'option');
            // Check if the shortcode exists and then execute it
            if (!empty($subscribe_form_shortcode)) {
                echo do_shortcode($subscribe_form_shortcode);
            }
        ?>
    </div>
    <div class="newsletter-image h-64 bg-cover bg-[15%] md:bg-center  sm:bg-zoom md:bg-no-repeat" style="background-image: url('<?php echo esc_url( get_template_directory_uri()); ?>/assets/img/popups/newsletter-popup.jpg');"></div>
</div>

<div class="!bg-white !p-0 max-h-[80vh] lg:max-w-[60%]" id="popup-content-2" style="display:none;">
    <div class="grid grid-cols-1 sm:grid-cols-2">
        <div class="sm:order-2 py-24 px-12 flex flex-col items-center gap-y-6">
            <h2 class="heading-two text-shop-front-blue text-center">Student Discount</h2>
            <p class="p-one text-shop-front-blue text-center">Use coupon code <span class="font-bold">MILOU10</span> and enter your academic email address at checkout to benefit from a 10% discount.</p>
            <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn btn-small bg-shop-front-blue shop-link">Shop Now</a>
        </div>
        <div class="sm:order-1 h-64 sm:h-full student-discont-image bg-cover  sm:bg-right bg-no-repeat" style="background-image: url('<?php echo esc_url( get_template_directory_uri()); ?>/assets/img/popups/student-discount.jpeg');"></div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {

    // Function to check if a cookie exists
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    // Function to set a cookie
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    // Function to handle popup logic
    function handlePopup(popupId, cookieName, delay, duration) {
        if (!getCookie(cookieName)) {
            setTimeout(function() {
                Fancybox.show([{ src: popupId, type: "inline" }]);
                setCookie(cookieName, 'yes', duration);
            }, delay * 1000); // Convert to milliseconds
        }
    }

    // PHP Variables
    var selectedPopup = "<?php echo $popup_id_to_show; ?>";
    var timeDelay = <?php echo $time_delay ?: 5; ?>;
    var cookieDuration = <?php echo $cookie_duration ?: 30; ?>;

    // Handle the selected popup
    if (selectedPopup) {
        handlePopup(selectedPopup, "seenPopup", timeDelay, cookieDuration);
    }

});
</script>
