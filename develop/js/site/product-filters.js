jQuery(document).ready(function($) {
    var selectedCategoriesContainer = $('#selected-categories');
    var priceSlider = $('#price-range-slider')[0];
    var minPriceInput = $('#min-price');
    var maxPriceInput = $('#max-price');
    var currentPage = 1, totalPages = 1, isLoading = false;

    var onMobile = $(window).width() < 768;


    $('#product-filters').hide(); // Hide #product-filters initially

    if (!priceSlider) return; // Exit if not on the shop page

    // Initialize the price range slider
    noUiSlider.create(priceSlider, {
        start: [price_slider_params.min_price, price_slider_params.max_price],
        connect: true,
        range: {
            'min': parseFloat(price_slider_params.min_price),
            'max': parseFloat(price_slider_params.max_price)
        },
        format: wNumb({ decimals: 0 })
    });

    priceSlider.noUiSlider.on('update', function(values) {
        minPriceInput.text(values[0]);
        maxPriceInput.text(values[1]);
    });

     window.fetchSubcategories = function(categoryId, isMobile = false) {
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: isMobile ? 'get_mobile_subcategories' : 'get_subcategories',
                category_id: categoryId
            },
            success: function(response) {
                if (isMobile) {
                    $('#mobile-subcategory-filter').html(response).parent().removeClass('hidden');
                } else {
                    var container = $('#subcat-container-for-' + categoryId);
                    if (container.length) {
                        container.replaceWith(response);
                    } else {
                        $('#subcategories-container').append(response);
                    }
                }
                document.dispatchEvent(new CustomEvent('subcategoriesUpdated'));
                updateProductTypeVisibility();
            }
        });
    }

    function updateProductTypeVisibility() {
        var hasSelectedCategories = $('.product-category:checked').length > 0;
        $('#product-filters').toggle(hasSelectedCategories);
        updateSelectedCategories();
    }

    function updateSelectedCategories() {
        selectedCategoriesContainer.empty();
        $('.product-category:checked').each(function() {
            var categoryName = $(this).next('label').text();
            var categoryLabel = $('<div class="selected-category">' + categoryName + '<span class="remove-category"> x</span></div>');
            selectedCategoriesContainer.append(categoryLabel);
        });
    }

    $('#mobile-category-filter, .product-category').change(function() {
        var categoryId = $(this).val();
        var isMobile = $(this).is('#mobile-category-filter');
     
        if (isMobile) {
            // If it's a mobile category change, only fetch subcategories
            fetchSubcategories(categoryId, isMobile);
        } else {
            // For desktop or non-mobile changes
            if ($(this).is(':checked')) {
                fetchSubcategories(categoryId, isMobile);
            } else {
                // Remove corresponding subcategories when the main category is unchecked
                var subcategoryContainer = $('#subcat-container-for-' + categoryId);
                if (subcategoryContainer.length) {
                    subcategoryContainer.find('.product-subcategory').prop('checked', false); // Uncheck subcategories
                    subcategoryContainer.remove(); // Remove the subcategory container
                }
                updateProductTypeVisibility();
            }
            resetInfiniteScroll();
            updateProducts();
        }
    });
    
    

    $(document).on('click', '.remove-category', function() {
        var categoryName = $(this).parent().text().slice(0, -2);
        $('.product-category').filter(function() {
            return $(this).next('label').text() === categoryName;
        }).prop('checked', false).trigger('change');
    });

    window.updateProducts = function(page = 1, filters = null) {
        if (page === 1) $('.shop-products .products').empty();
        isLoading = true;
        showLoadingIcon();
    
        var baseFilters = {
            min_price: priceSlider.noUiSlider.get()[0],
            max_price: priceSlider.noUiSlider.get()[1],
            page: page
        };
    
        // Determine whether to use mobile or desktop filters
        var finalFilters = onMobile ? Object.assign({}, gatherMobileFilters(), baseFilters) : (filters || Object.assign({}, {
            categories: gatherFilters('.product-category:checked'),
            subcategories: gatherFilters('.product-subcategory:checked'), 
            characters: gatherFilters('.character-filter-image.active', true),
            languages: gatherFilters('.language-filter-checkbox:checked'),
            materials: gatherFilters('.material-filter-checkbox:checked'),
            order_by: $('#custom-ordering-select').val()
        }, baseFilters));

            
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: Object.assign({ action: 'filter_products' }, finalFilters),
            success: function(response) {
                hideLoadingIcon();
                $('.shop-products .products').append(response.html);
                totalPages = parseInt(response.max_num_pages);
                isLoading = false;

                // If there are more pages, show the "Load More" button. Otherwise, hide it.
                if (currentPage < totalPages) {
                    $('#load-more').show();
                } else {
                    $('#load-more').hide();
                }
            }
        });
    }

    function gatherMobileFilters() {
		var orderFilter = document.getElementById('mobile-order-filter').value;
		var categoryFilter = document.getElementById('mobile-category-filter').value;
		var subcategoryFilter = document.getElementById('mobile-subcategory-filter').value;
		var characterFilter = document.getElementById('mobile-character-filter').value;
		var languageFilter = document.getElementById('mobile-language-filter').value;
		var materialFilter = document.getElementById('mobile-material-filter').value;
		
		return {
			order_by: orderFilter || null,
			categories: categoryFilter ? [categoryFilter] : [],
			subcategories: subcategoryFilter ? [subcategoryFilter] : [],
			characters: characterFilter ? [characterFilter] : [],
			languages: languageFilter ? [languageFilter] : [],
			materials: materialFilter ? [materialFilter] : []
		};
	}

        
    function gatherFilters(selector, isData = false, onMobile = false) {
        return $(selector).map(function() {
            return isData ? $(this).closest('.character-filter-item').find('.character-filter-checkbox').val() : this.value;
        }).get();
    }

    function loadMoreProductsIfNeeded() {
        $('#load-more').click(function() {
            if (isLoading || currentPage >= totalPages) return;
            currentPage++;
            updateProducts(currentPage);
        });
    }

    function resetInfiniteScroll() {
        currentPage = 1; totalPages = 1;
    }

    function showLoadingIcon() {
        $('#loading-icon').removeClass('hidden').appendTo('.shop-products');
    }
    
    function hideLoadingIcon() {
        $('#loading-icon').addClass('hidden');
    }

    $('#subcategories-container').on('change', '.product-subcategory', function() { updateProducts(); });
    $('#custom-ordering-select, .language-filter-checkbox, .material-filter-checkbox').change(function() { updateProducts(); });
    $('.character-filter-image').click(function() { $(this).toggleClass('active'); updateProducts(); });
    priceSlider.noUiSlider.on('change', function() { updateProducts(); });

    $(document).on('click', '.remove-category', function() {
        var categoryName = $(this).parent().text().slice(0, -2);
        $('.product-category').filter(function() {
            return $(this).next('label').text() === categoryName;
        }).prop('checked', false).trigger('change');
    });

    // Initialize the infinite scroll and products load
    
    $(window).off('scroll').on('scroll', loadMoreProductsIfNeeded);

    // Dispatch a custom event for other scripts that might depend on this
    document.dispatchEvent(new CustomEvent('productFiltersLoaded'));
});
