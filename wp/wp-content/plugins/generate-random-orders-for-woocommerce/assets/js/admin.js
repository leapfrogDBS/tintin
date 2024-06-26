jQuery(document).ready(function($) {
    var batchSize = 5;
    $('#wpz-random-orders-form').on('submit', function() {
        var $form = $(this);
        $form.find('button:first').prop('disabled', true);
        $('#wpz-random-orders-progress').attr('value', 0);
        var count = $form.find('[name="orderCount"]:first').val();
        var batchCount = Math.ceil(count / batchSize);
        function doRequest(i, nonce) {
            $.post(
                ajaxurl,
                {
                    action: 'wpz_random_orders',
                    nonce: nonce,
                    n: (i === batchCount && (count % batchSize) ? (count % batchSize) : batchSize),
                    i: i,
                    deleteJson: $form.find('[name="deleteJson"]:checked').length
                },
                function(response) {
                    if (response.success) {
                        $('#wpz-random-orders-progress').attr('value', i / batchCount);
                        $('#wpz-random-orders-output').text( $('#wpz-random-orders-output').text() + response.data.output );
                        if (i < batchCount) {
                            doRequest(i + 1, response.data.nonce);
                        } else {
                            $form.find('button:first').prop('disabled', false);$('<p>')
                                .addClass('wpz-random-orders-success')
                                .text('Complete!')
                                .insertAfter($form);
                        }
                    } else {
                        alert('Something went wrong! Please try again.');
                        $form.find('button:first').prop('disabled', false);
                    }
                },
                'json'
            ).fail(function() {
                alert('Something went wrong! Please try again.');
                $form.find('button:first').prop('disabled', false);
            });
        }
        doRequest(1, $form.find('[name="nonce"]:first').val());
        return false;
    });
});


jQuery('#wpz-random-orders-form button').click(function() {
    jQuery('#wpz-random-orders-progress').show()
});

// Admin Page Tabs
var wpz_woocommerce_random_orderstabs_navigate = function () {
    jQuery('#wpz-woocommerce-random-orders-settings-tabs-content > div, #wpz-woocommerce-random-orders-settings-tabs > li').removeClass('wpz-woocommerce-random-orders-settings-active');
    jQuery('#wpz-woocommerce-random-orders-settings-' + location.hash.substr(1)).addClass('wpz-woocommerce-random-orders-settings-active');
    jQuery('#wpz-woocommerce-random-orders-settings-tabs > li:has(a[href="' + location.hash + '"])').addClass('wpz-woocommerce-random-orders-settings-active');
};

if (location.hash) {
    wpz_woocommerce_random_orderstabs_navigate();
}
jQuery(window).on('hashchange', wpz_woocommerce_random_orderstabs_navigate);