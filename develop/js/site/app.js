let App;

App = {


    debounce: function(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    },
   
    addScrollClass: function() {
        const header = document.getElementById('masthead');
        let isScrolled = false;

        window.addEventListener("scroll", function() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

            if (currentScroll > 0 && !isScrolled) {
                // Scrolling down and class not added
                header.classList.add("is-scrolled");
                isScrolled = true;
            } else if (currentScroll === 0 && isScrolled) {
                // Back at the top of the page and class added
                header.classList.remove("is-scrolled");
                isScrolled = false;
            }
        });
    },

    navToggle: function() {
        const body = document.querySelector('body');
        const navtoggles = document.querySelectorAll('[data-navtoggle]');
      
        navtoggles.forEach(navtoggle => {
            navtoggle.addEventListener('click', () => this.toggleNav(body));
        });
    },

    toggleNav: function(body) {
        const isOpen = body.dataset.menuopen === 'true';
        body.dataset.menuopen = String(!isOpen);
        isOpen ? this.navClose() : this.navOpen();
    },
    
    navOpen: function() {
        this.toggleNavElements(true);
    },

    navClose: function() {
        this.toggleNavElements(false);
    },

    toggleNavElements: function(open) {
        const menuflyoutBlocker = document.querySelector('#menu-flyout-blocker');
        const menuflyout = document.querySelector('#menu-flyout');
        const hamburger = document.querySelector('.hamburger');
        hamburger.classList.toggle('open', open);
        menuflyoutBlocker.classList.toggle('!opacity-100', open);
        menuflyoutBlocker.classList.toggle('!visible', open);
        menuflyout.classList.toggle('!translate-x-0', open);
    },


    toggleLayout: function() {
        const gridViewBtn = document.getElementById('grid-view');
        const listViewBtn = document.getElementById('list-view');
        const postsContainer = document.getElementById('news-posts-container');

        if (!gridViewBtn || !listViewBtn || !postsContainer) {
            return;
        }

        gridViewBtn.addEventListener('click', function() {
            postsContainer.classList.add('grid-layout');
            postsContainer.classList.remove('list-layout');
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
        });
    
        listViewBtn.addEventListener('click', function() {
            postsContainer.classList.add('list-layout');
            postsContainer.classList.remove('grid-layout');
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
        });
        
    },

    attachEventListeners: function() {
        document.body.addEventListener('click', (event) => {
            if (event.target.matches('.youtube-thumbnail-wrapper') || event.target.closest('.youtube-thumbnail-wrapper')) {
                const videoId = event.target.dataset.videoid || event.target.closest('.youtube-thumbnail-wrapper').dataset.videoid;
                this.openLightbox(videoId);
            }
        });
        document.getElementById('lightbox').addEventListener('click', (event) => {
            if (event.target.id === 'lightbox' || event.target.matches('.lightbox-close')) {
                this.closeLightbox();
            }
        });
    },

    openLightbox: function(videoId) {
        var lightbox = document.getElementById('lightbox');
        var iframe = document.getElementById('lightbox-video');

        iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
        lightbox.classList.remove('hidden');
    },

    closeLightbox: function() {
        var lightbox = document.getElementById('lightbox');
        var iframe = document.getElementById('lightbox-video');

        iframe.src = '';
        lightbox.classList.add('hidden');
    },

    handleQuantityButtons: function() {
        jQuery(document).on('click', '.quantity .plus, .quantity .minus', function() {
            // Determine whether it's a plus or minus button
            const isPlusButton = jQuery(this).hasClass('plus');
            const quantityInput = jQuery(this).siblings('.qty');
            let quantity = parseInt(quantityInput.val(), 10);
    
            // Increment or decrement the quantity
            quantity = isPlusButton ? quantity + 1 : quantity - 1;
            quantity = quantity < 0 ? 0 : quantity;
            quantityInput.val(quantity).change(); // Trigger change event
        });
    },
    

    updateCartOnQuantityChange: function() {
        jQuery(document).on('change', '.woocommerce-cart-form .qty', function() {
        });
    },

   
    wrapNameFields: function() {
        var billingFirstName = document.getElementById('billing_first_name');
        var billingLastName = document.getElementById('billing_last_name');
        var shippingFirstName = document.getElementById('shipping_first_name');
        var shippingLastName = document.getElementById('shipping_last_name');
        if (billingFirstName && billingLastName) {
            var billingWrapper = document.createElement('div');
            billingWrapper.className = 'name-field';
            billingFirstName.parentNode.insertBefore(billingWrapper, billingFirstName);
            billingWrapper.appendChild(billingFirstName);
            billingWrapper.appendChild(billingLastName);
        }

        if (shippingFirstName && shippingLastName) {
            var shippingWrapper = document.createElement('div');
            shippingWrapper.className = 'name-field';
            shippingFirstName.parentNode.insertBefore(shippingWrapper, shippingFirstName);
            shippingWrapper.appendChild(shippingFirstName);
            shippingWrapper.appendChild(shippingLastName);
        }
    }, 
    
    
    toggleAccordion: function(element) {
        const content = element.nextElementSibling;
        content.classList.toggle('hidden');
        element.querySelector('.chevron').classList.toggle('rotate');
    },

    initializeAccordions: function() {
        const accordions = document.querySelectorAll('.accordion-button');
        accordions.forEach(accordion => {
            accordion.addEventListener('click', function() {
                App.toggleAccordion(this);
            });
        });
    },
    
    shopSearch: function() {
        const searchInput = document.querySelector('#search-container [name="s"]');
        const searchContent = document.querySelector('[data-searchproducts]');
        const newsContent = document.querySelector('[data-searchposts]');
        const categoryContent = document.querySelector('[data-searchcategories]');
        const searchLoader = document.querySelector('#search-container .search-loader');
        const clearButton = document.querySelector('#clear-search');

        const data = new FormData();
        data.append('action', 'tintin_combined_search');
        data.append('search', searchInput.value);

        fetch(my_ajax_object.ajax_url, {
            method: "POST",
            credentials: 'same-origin',
            body: data
        })
        .then((response) => response.json())
        .then((data) => {
            if (data) {
                const productResults = data.products || '';
                const postResults = data.posts || '';
                const categoryResults = data.categories || ''
                const productControls = document.querySelector('.search-products-container').previousElementSibling;
                const postControls = document.querySelector('.post-results-container').previousElementSibling;
                const categoryControls = document.querySelector('.category-results-container').previousElementSibling;

                searchContent.innerHTML = productResults;
                newsContent.innerHTML = postResults;
                categoryContent.innerHTML = categoryResults;

                // Toggle 'invisible' class based on search results
                productControls.classList.toggle('invisible', productResults.trim() === '');
                postControls.classList.toggle('invisible', postResults.trim() === '');
                categoryControls.classList.toggle('invisible', postResults.trim() === '');

                searchLoader.classList.remove('!opacity-100');
            }
        });
       
    },

    shopSearchHandler: function() {
        let inputTimer;
        const searchForm = document.querySelector('#search-container form');
        const searchInput = document.querySelector('#search-container [name="s"]');
        const searchLoader = document.querySelector('#search-container .search-loader');
        const clearButton = document.querySelector('#clear-search');
        const searchContent = document.querySelector('[data-searchproducts]');
        const newsContent = document.querySelector('[data-searchposts]');
        const categoryContent = document.querySelector('[data-searchcategories]');
        const closeButton = document.querySelector('#close-search');

        closeButton.addEventListener('click', function() {
            // Close the Fancybox
            Fancybox.close();
            clearSearch();
        });
    
        searchInput.addEventListener('keyup', function() {
            searchLoader.classList.add('!opacity-100');
            clearButton.classList.add('hidden'); // Hide the 'X' button when loading starts
            clearTimeout(inputTimer);
            inputTimer = setTimeout(function() {
                App.shopSearch();
                setTimeout(() => clearButton.classList.remove('hidden'), 300); // Slight delay to show the 'X' button
            }, 500);
        });
    
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            searchLoader.classList.add('!opacity-100');
            clearButton.classList.add('hidden'); // Hide the 'X' button when loading starts
            App.shopSearch();
            setTimeout(() => clearButton.classList.remove('hidden'), 1000); // Slight delay to show the 'X' button
        });
    
        // Clear search input and results when 'X' button is clicked
        clearButton.addEventListener('click', function() {
            clearSearch();
        });

        function clearSearch() {
            searchInput.value = ''; // Clear the search input
            searchContent.innerHTML = ''; // Clear the product search results
            newsContent.innerHTML = ''; // Clear the news search results
            const productControls = document.querySelector('.search-products-container').previousElementSibling;
            const postControls = document.querySelector('.post-results-container').previousElementSibling;
            productControls.classList.add('invisible');
            postControls.classList.add('invisible');
        }
    },

    updateCartOnQuantityChange: function() {
        const updateCart = this.debounce(function() {
            jQuery('button[name="update_cart"]').trigger('click');
        }, 1000); // Adjust the delay as needed
    
        jQuery(document).on('change', '.woocommerce-cart-form .qty', function() {
            updateCart();
        });
    },

    convertLoginLabelsToPlaceholders: function() {
        this.applyPlaceholder('.woocommerce-form-login');
        this.applyPlaceholder('.woocommerce-form-register');
    },

    applyPlaceholder: function(formSelector) {
        var form = document.querySelector(formSelector);
        if (!form) return;

        var labels = form.querySelectorAll('label');
        labels.forEach(function(label) {
            var inputId = label.getAttribute('for');
            var input = form.querySelector('#' + inputId);
            if (input && (input.type === 'text' || input.type === 'password' || input.type === 'email')) {
                input.placeholder = label.textContent.trim();
                label.style.display = 'none'; // Hides the label
            }
        });
    },


    handleVariationImages: function() {
        var originalTitle = jQuery('.product_title').text();

        function updateMainImage(variationImageSrc, variationImageFullSrc) {
            var $slider = jQuery('.product-image-splide-list');
            var $singleImage = jQuery('.single-image img');
           
              
            if ($slider.length) {
                $slider.find('.splide__slide.is-active img').attr('src', variationImageFullSrc);
                $slider.find('.splide__slide.is-active img').attr('srcset', variationImageFullSrc);
                $slider.find('.splide__slide.is-active a').attr('data-src', variationImageFullSrc);
                          
            } else if ($singleImage.length) {

                $singleImage.attr('src', variationImageFullSrc);
                $singleImage.attr('srcset', variationImageFullSrc);
                $singleImage.closest('figure').attr('data-src', variationImageFullSrc);
            }
        }
    
        jQuery('form.variations_form').on('found_variation', function(event, variation) {
            if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
                updateMainImage(variation.image.src, variation.image.full_src);
            }
            // Update the product title with the custom title of the selected variation
            if (variation && variation.custom_title) {
                var decodedTitle = jQuery('<textarea/>').html(variation.custom_title).text(); // Decoding HTML entities
                jQuery('.product_title').text(decodedTitle);
            } else {
                jQuery('.product_title').text(originalTitle);
            }
        }).on('reset_image', function() {
            var $imageContainer = jQuery('.product-images');
            var originalSrc = $imageContainer.data('default-image');
            var originalFullSrc = $imageContainer.data('default-image-full');
            updateMainImage(originalSrc, originalFullSrc);
        });
    },
    
    initHeroSlider: function() {
        var heroSplideElement = document.querySelector('#home-hero-splide');
    
        if (heroSplideElement) {
            var heroSplide = new Splide(heroSplideElement, {
                // Add any specific Splide configurations for the hero slider here
            });
    
            function updateBackground() {
                var currentImage = heroSplide.Components.Elements.slides[heroSplide.index].querySelector('img').src;
                var targetContainer = document.querySelector('.img-test'); // Replace with your target container's class
                targetContainer.style.backgroundImage = 'url(' + currentImage + ')';
                
                targetContainer.style.backgroundPosition = 'left center'; // Center the background image
            }
    
            heroSplide.on('mounted', updateBackground);
            heroSplide.on('move', updateBackground);
    
            heroSplide.mount();
        }
    },

    updateSelectStyles: function() {
        function updateSelectStyle(selectElement) {
            if (selectElement.value === "") {
                selectElement.classList.remove('select-changed');
                selectElement.classList.add('select-default');
            } else {
                selectElement.classList.remove('select-default');
                selectElement.classList.add('select-changed');
            }
        }
    
        const selects = document.querySelectorAll('.all-filters select');
    
        selects.forEach(select => {
            updateSelectStyle(select); // Set initial style
            select.addEventListener('change', function() {
                updateSelectStyle(this);
            });
        });
    },
    
    adjustTopOffsetForAnnouncementBar: function() {
        const announcementBar = document.querySelector('#announcement-bar'); // Adjust selector as needed
        const existingOffset = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--dynamic-top-offset'), 10);
    
        if (announcementBar && getComputedStyle(announcementBar).display !== 'none') {
            const announcementBarHeight = announcementBar.offsetHeight;
            const newOffset = existingOffset + announcementBarHeight;
            document.documentElement.style.setProperty('--dynamic-top-offset', `${newOffset}px`);
        }
    },

    mobileShopWorkflow: function() {
        var homeURL = wpVars.homeUrl;
        var shopPageURL = wpVars.shopPageUrl; // Dynamically fetched shop page URL
    
        // Select all links on the page
        var allLinks = document.querySelectorAll('a');
    
        allLinks.forEach(function(link) {
            // Check if the link's href attribute matches the dynamically fetched shop page URL
            if (link.href === shopPageURL) {
                link.addEventListener('click', function(event) {
                    if (window.innerWidth <= 768) {
                        event.preventDefault();
                        window.location.href = homeURL + '/mobile-filters';
                    }
                });
            }
        });
    },
    
     
        
    init: function() {
        this.addScrollClass();
        this.navToggle();
        this.toggleLayout();
        this.attachEventListeners();
        this.handleQuantityButtons();
        this.updateCartOnQuantityChange();
        this.wrapNameFields();
        this.initializeAccordions();
        this.shopSearchHandler();
        this.updateCartOnQuantityChange();
        this.convertLoginLabelsToPlaceholders();
        this.handleVariationImages();
        this.initHeroSlider();
        this.updateSelectStyles();
        this.adjustTopOffsetForAnnouncementBar();
        this.mobileShopWorkflow(); 
    }

}

document.addEventListener("DOMContentLoaded", () => App.init());



