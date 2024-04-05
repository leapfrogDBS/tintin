jQuery(document).ready(function($) {
    // Function to load posts based on category and page
    function loadPosts(category, page) {
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_posts',
                category: category,
                page: page
            },
            success: function(response) {
                $('#content-area').html(response);
            },
            error: function(error) {
                console.log('AJAX error:', error);
            }
        });
    }

    // Event listener for category buttons (Desktop)
    $('.category-filter button').on('click', function() {
        var category = $(this).data('category');
        $('.category-filter button').removeClass('active');
        $(this).addClass('active');
        loadPosts(category, 1);
    });

    // Event listener for category dropdown (Mobile)
    $('#categoryDropdown').on('change', function() {
        var category = $(this).val();
        loadPosts(category, 1);

        // Optional: Update active class on buttons for consistency
        $('.category-filter button').removeClass('active');
        $('.category-filter button[data-category="' + category + '"]').addClass('active');
    });
});
