<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package tintin
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function tintin_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'tintin_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function tintin_woocommerce_scripts() {
	
	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'tintin-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'tintin_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function tintin_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'tintin_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function tintin_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'tintin_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'tintin_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function tintin_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'tintin_woocommerce_wrapper_before' );

if ( ! function_exists( 'tintin_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function tintin_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'tintin_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'tintin_woocommerce_header_cart' ) ) {
			tintin_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'tintin_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function tintin_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		tintin_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'tintin_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'tintin_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function tintin_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'tintin' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'tintin' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'tintin_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function tintin_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php tintin_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}


// Remove Breadcrumb from default location
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Add Breadcrumb to the top of the product summary
add_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 4);

// Customize the breadcrumb trail
add_filter('woocommerce_get_breadcrumb', 'customize_woocommerce_breadcrumbs', 10, 2);
function customize_woocommerce_breadcrumbs($crumbs, $breadcrumb) {
    // Get the main shop page URL
    $shop_page_url = wc_get_page_permalink('shop');

    foreach ($crumbs as $key => $crumb) {
        // Only modify category and subcategory crumbs
        if ($key > 0 && isset($crumb[1]) && strpos($crumb[1], 'product-category') !== false) {
            $term = get_term_by('name', $crumb[0], 'product_cat');
            if ($term && !is_wp_error($term)) {
                if ($term->parent === 0) {
                    // It's a main category
                    $crumbs[$key][1] = add_query_arg('filter_category', $term->term_id, $shop_page_url);
                } else {
                    // It's a subcategory, include both main category and subcategory
                    $parent_term_id = $term->parent;
                    $crumbs[$key][1] = add_query_arg(array(
                        'filter_category' => $parent_term_id,
                        'filter_subcategory' => $term->term_id
                    ), $shop_page_url);
                }
            }
        }

        // Remove the product name from the breadcrumb
        if (is_product() && $key === count($crumbs) - 1) {
            $crumbs[$key][0] = '';
        }
    }
    
    return $crumbs;
}




/*Remove Category from product page summary */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/* Remove Related Products */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/* Remove Results Count on Shop Page */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

/* Add an image field to character attributes */
function add_character_image_field() {
    ?>
    <div class="form-field">
        <label for="character-image"><?php _e('Character Image', 'tintin'); ?></label>
        <input type="hidden" id="character-image" name="character-image" class="character-image-field">
        <div id="character-image-preview" class="character-image-preview"></div>
        <button type="button" class="button character-image-upload"><?php _e('Add Image', 'tintin'); ?></button>
        <p class="description"><?php _e('Upload an image for the character.', 'tintin'); ?></p>
    </div>
    <?php
}
add_action('pa_character_add_form_fields', 'add_character_image_field', 10, 1);

function edit_character_image_field($term) {
    $character_image = get_term_meta($term->term_id, 'character-image', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="character-image"><?php _e('Character Image', 'tintin'); ?></label></th>
        <td>
            <input type="hidden" id="character-image" name="character-image" value="<?php echo esc_attr($character_image); ?>" class="character-image-field">
            <div id="character-image-preview" class="character-image-preview">
                <?php if ($character_image) : ?>
                    <img src="<?php echo esc_url($character_image); ?>" style="max-width:100px;height:auto;">
                <?php endif; ?>
            </div>
            <button type="button" class="button character-image-upload"><?php _e('Add/Edit Image', 'tintin'); ?></button>
        </td>
    </tr>
    <?php
}
add_action('pa_character_edit_form_fields', 'edit_character_image_field', 10, 1);

function save_character_image_meta($term_id) {
    if (isset($_POST['character-image'])) {
        $character_image = sanitize_text_field($_POST['character-image']);
        update_term_meta($term_id, 'character-image', $character_image);
    }
}
add_action('created_pa_character', 'save_character_image_meta', 10, 1);
add_action('edited_pa_character', 'save_character_image_meta', 10, 1);



function enqueue_media_uploader_for_character_image() {
    wp_enqueue_media();
    wp_enqueue_script('character-image-uploader', get_template_directory_uri() . '/scripts/site/character-image-uploader.min.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader_for_character_image');


function enqueue_nouislider_assets() {
    // Check if it's the shop page or product category pages
    if ( is_shop() ) {
        // Enqueue noUiSlider CSS
        // Enqueue noUiSlider CSS from local theme directory
        wp_enqueue_style( 'nouislider-css', get_template_directory_uri() . '/assets/css/nouislider.min.css', array(), '1.0.0' );

        // Enqueue noUiSlider JS
        wp_enqueue_script( 'nouislider-js', get_template_directory_uri() . '/scripts/lib/nouislider.min.js', array(), '1.0.0', true );

        // Enqueue wNumb JS
        wp_enqueue_script( 'wnumb-js', get_template_directory_uri() . '/scripts/lib/wNumb.min.js', array(), '1.2.0', true );
    }
}

add_action( 'wp_enqueue_scripts', 'enqueue_nouislider_assets' );

/* Remove Select2 from WooCommerce */
add_action( 'wp_enqueue_scripts', 'dequeue_select2_scripts', 100 );
function dequeue_select2_scripts() {
    if ( class_exists( 'woocommerce' ) ) {
        wp_dequeue_style( 'select2' );
        wp_deregister_style( 'select2' );

        wp_dequeue_script( 'select2' );
        wp_deregister_script( 'select2' );
    }
}

/* Remove labels from checkout fields */
function custom_override_checkout_fields( $fields ) {
    // Billing fields
    foreach ( $fields['billing'] as $key => $field ) {
        if ( isset( $field['label'] ) ) {
            $fields['billing'][ $key ]['placeholder'] = $field['label'];
        }
        $fields['billing'][ $key ]['label'] = '';
    }

    // Shipping fields
    foreach ( $fields['shipping'] as $key => $field ) {
        if ( isset( $field['label'] ) ) {
            $fields['shipping'][ $key ]['placeholder'] = $field['label'];
        }
        $fields['shipping'][ $key ]['label'] = '';
    }

    // Order notes field
    if ( isset( $fields['order']['order_comments']['label'] ) ) {
        $fields['order']['order_comments']['placeholder'] = $fields['order']['order_comments']['label'];
    }
    $fields['order']['order_comments']['label'] = '';

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'custom_override_checkout_fields' );


/* Replace palceholder in additional notes */
add_filter( 'woocommerce_checkout_fields' , 'custom_override_notes_field' );

function custom_override_notes_field( $fields ) {
	$fields['order']['order_comments']['placeholder'] = 'If you have any special delivery requirements or want to add a gift message to your order, please enter the details here.';
	$fields['order']['order_comments']['label'] = '';
	$fields['order']['order_comments']['class'][] = 'notes-section'; // Add a custom class
	return $fields;
}


// Add a custom field (in an order) after billing details
add_filter( 'woocommerce_form_field_textarea', 'custom_form_field_textarea', 10, 4 );

function custom_form_field_textarea( $field, $key, $args, $value ) {
	if ( $key === 'order_comments' ) {
		$field = str_replace( '<label', '<h3 class="notes-heading heading-three mb-6">Additional Information</h3><label style="display:none"', $field );
	}
	return $field;
}


function remove_default_woocommerce_product_ordering() {
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 30 );
}

add_action( 'init', 'remove_default_woocommerce_product_ordering' );


/* Recent products Cookie */ 
function set_user_visited_product_cookie() {
    global $post;

    if ( is_product() ) {
        $viewed_products = array();
        if ( isset( $_COOKIE['woocommerce_recently_viewed'] ) ) {
            $viewed_products = explode( ',', $_COOKIE['woocommerce_recently_viewed'] );
        }

        if ( ! in_array( $post->ID, $viewed_products ) ) {
            $viewed_products[] = $post->ID;
            if ( count( $viewed_products ) > 3 ) { // Limit to last 5 viewed products
                array_shift( $viewed_products ); // Remove the oldest product
            }
            wc_setcookie( 'woocommerce_recently_viewed', implode( ',', $viewed_products ) );
        }
    }
}

add_action( 'wp', 'set_user_visited_product_cookie' );



/* Product Filters */
function filter_products_callback() {
    $categories = isset($_POST['categories']) ? $_POST['categories'] : array();
    $subcategories = isset($_POST['subcategories']) ? $_POST['subcategories'] : array();
    $characters = isset($_POST['characters']) ? $_POST['characters'] : array();
    $languages = isset($_POST['languages']) ? $_POST['languages'] : array(); 
    $materials = isset($_POST['materials']) ? $_POST['materials'] : array();
    $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : 'menu_order';
    $min_price = isset($_POST['min_price']) ? $_POST['min_price'] : '';
    $max_price = isset($_POST['max_price']) ? $_POST['max_price'] : '';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 9,
        'paged' => $page,
        'tax_query' => array('relation' => 'AND'),
        'post_status' => 'publish' // Show only published products
    );

    $response = array(
        'html' => '',
        'max_num_pages' => 0,
        'current_page' => $page
    );

    // Conditionally add price filters
    if ($min_price !== '' && $max_price !== '') {
        $args['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'type' => 'DECIMAL',
                'compare' => 'BETWEEN'
            )
        );
    }

    if (!empty($subcategories)) {
        // Filter by subcategories if provided
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => array_map('intval', $subcategories),
            'operator' => 'IN'
        );
    } elseif (!empty($categories)) {
        // Filter by main categories if no subcategories are provided
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => array_map('intval', $categories),
            'operator' => 'IN'
        );
    }


    if (!empty($characters)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'pa_character',
            'field' => 'term_id',
            'terms' => $characters,
            'operator' => 'IN'
        );
    }

    switch ($order_by) {
        case 'menu_order':
            $args['orderby'] = 'menu_order title';
            $args['order'] = 'ASC';
            break;
        case 'popularity':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'total_sales';
            $args['order'] = 'DESC';
            break;
        case 'rating':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_wc_average_rating';
            $args['order'] = 'DESC';
            break;
        case 'date':
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
        case 'price':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'ASC';
            break;
        case 'price-desc':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'DESC';
            break;
        default:
            // Default case can be set to any of the above or just 'menu_order'
            $args['orderby'] = 'menu_order title';
            $args['order'] = 'ASC';
            break;
    }
    

    if (!empty($materials)) { // Add the materials filter
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat', // Use the taxonomy of the material attribute
            'field' => 'term_id',
            'terms' => $materials,
            'operator' => 'IN'
        );
    }

    if (!empty($languages)) { // Add the languages filter
        $args['tax_query'][] = array(
            'taxonomy' => 'pa_language', // Replace 'pa_language' with the actual slug of the language attribute
            'field' => 'term_id',
            'terms' => $languages,
            'operator' => 'IN'
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
        $response['html'] = ob_get_clean();

        $response['max_num_pages'] = $query->max_num_pages;

    } else {
        $response['html'] = '<h3 class="heading-three text-center col-span-2 lg:col-span-3">No products found.</h3>';
    }
    wp_send_json($response);
    wp_die();
}


add_action('wp_ajax_filter_products', 'filter_products_callback');
add_action('wp_ajax_nopriv_filter_products', 'filter_products_callback');

/* Get subcategories for desktop filters */
function get_subcategories_callback() {
    $parent_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $subcategories = get_terms('product_cat', array('hide_empty' => false, 'parent' => $parent_id));
    
    // Start a container for subcategories of this main category
    echo '<div id="subcat-container-for-' . $parent_id . '" class="filter-terms">'; 

    foreach ($subcategories as $subcategory) {
        echo '<div class="filter-checkbox">';
        echo '<input type="checkbox" id="subcat_' . $subcategory->term_id . '" class="product-subcategory" value="' . $subcategory->term_id . '">';
        echo '<label for="subcat_' . $subcategory->term_id . '">' . $subcategory->name . '</label>';
        echo '</div>';
    }

    // Close the container
    echo '</div>';

    wp_die();
}
add_action('wp_ajax_get_subcategories', 'get_subcategories_callback');
add_action('wp_ajax_nopriv_get_subcategories', 'get_subcategories_callback');

/* Get subcategories for mobile */
function get_mobile_subcategories_callback() {
    $parent_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $subcategories = get_terms('product_cat', array('hide_empty' => false, 'parent' => $parent_id));
    
    echo '<option value="">All</option>'; // Default option

    foreach ($subcategories as $subcategory) {
        echo '<option value="' . $subcategory->term_id . '">' . $subcategory->name . '</option>';
    }

    wp_die();
}
add_action('wp_ajax_get_mobile_subcategories', 'get_mobile_subcategories_callback');
add_action('wp_ajax_nopriv_get_mobile_subcategories', 'get_mobile_subcategories_callback');

/* Get price range for products */
function get_min_max_product_prices() {
    global $wpdb;

    $prices = array('min' => 0, 'max' => 1000); // Default values

    // SQL to get min and max prices
    $sql = "
        SELECT min(meta_value + 0) as minprice, max(meta_value + 0) as maxprice
        FROM {$wpdb->postmeta}
        WHERE meta_key = '_price'
    ";

    $results = $wpdb->get_row($sql);

    if (!empty($results)) {
        $prices['min'] = floor($results->minprice);
        $prices['max'] = ceil($results->maxprice);
    }

    return $prices;
}

function enqueue_filters() {
    wp_enqueue_script('product-filters', get_template_directory_uri() . '/scripts/site/product-filters.min.js', array('jquery'));

    // Fetch min and max prices
    $prices = get_min_max_product_prices();

    // Localize the script with AJAX URL and min/max prices
    wp_localize_script('product-filters', 'price_slider_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'min_price' => $prices['min'],
        'max_price' => $prices['max']
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_filters');


/* Custom Shop Image Size */
function custom_set_shop_product_image_size() {
    // Add a new image size for product thumbnails
    add_image_size('custom-shop-thumbnail', 300, 300, true); // 300 pixels wide and tall, crop mode enabled
    add_image_size('custom_cart_thumbnail', 100, 100, true);

    // Replace the default WooCommerce thumbnail image size with the custom size
    add_filter('woocommerce_get_image_size_thumbnail', function($size) {
        return array(
            'width'  => 300,
            'height' => 300,
            'crop'   => 1,
        );
    });
}

add_action('after_setup_theme', 'custom_set_shop_product_image_size');


/*Remove default Woocommerce Pagination */
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);


/* Search Products and Posts */
function tintin_combined_search() {

    $shop_page_url = get_permalink(wc_get_page_id('shop'));

    // Function to modify the WHERE clause of SQL queries
    function search_by_title_only($where, &$wp_query) {
        global $wpdb;
        if ($search_term = $wp_query->get('search_title_only')) {
            // Modify the WHERE clause to search by title only
            $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($search_term)) . '%\'';
        }
        return $where;
    }

    // Ensure $_POST['search'] is set and sanitize it
    $search_term = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    // Search for Products
    $product_args = array(
        'post_type' => 'product',
        'posts_per_page' => 6,
        'search_title_only' => $search_term, // Set the custom flag for title-only search
        'orderby' => 'title',
        'order' => 'ASC',
        'post_status' => 'publish',
    );

    add_filter('posts_where', 'search_by_title_only', 10, 2);
    $product_query = new WP_Query($product_args);
    remove_filter('posts_where', 'search_by_title_only', 10);

    ob_start();
    if ($product_query->have_posts()) : 
        echo '<div class="posts-search-results-container grid grid-cols-1 sm:grid-cols-2 gap-6">';
        while ($product_query->have_posts()) : $product_query->the_post();
            get_template_part('template-parts/content', 'search-product');
        endwhile;
        echo '</div>';
    else :
        echo '<p class="my-10 text-center h2">No products found</p>';
    endif;
    $product_html = ob_get_clean();
    wp_reset_postdata();

    // Search for Posts
    $post_args = array(
        'post_type' => array('post', 'page'),
        'posts_per_page' => -1,
        'search_title_only' => $search_term, // Use the same custom flag for title-only search
        'orderby' => 'title',
        'order' => 'ASC',
        'post_status' => 'publish',
    );

    add_filter('posts_where', 'search_by_title_only', 10, 2);
    $post_query = new WP_Query($post_args);
    remove_filter('posts_where', 'search_by_title_only', 10);

    ob_start();
    if ($post_query->have_posts()) : 
        echo '<div class="posts-search-results-container grid grid-cols-1 sm:grid-cols-2 gap-6">';
        while ($post_query->have_posts()) : $post_query->the_post();
            get_template_part('template-parts/content', 'search-post');
        endwhile;
        echo '</div>';
    else :
        echo '<p class="my-10 text-center h2">No posts found</p>';
    endif;
    $post_html = ob_get_clean();
    wp_reset_postdata();

    $category_html = ''; // Initialize the variable to hold the output HTML for categories
$categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'name__like' => $search_term,
    'hide_empty' => false,
));

ob_start();
if (!empty($categories)) {
    echo '<div class="category-search-results-container grid grid-cols-2 sm:grid-cols-2 gap-6">';
    foreach ($categories as $category) {
        $link = $shop_page_url . '?filter_category=' . $category->term_id;
        $displayName = esc_html($category->name);

        // Check if the category is a child
        if ($category->parent != 0) {
            // It's a child category, fetch the parent category name
            $parent_category = get_term($category->parent, 'product_cat');
            if (!is_wp_error($parent_category) && $parent_category) {
                $displayName = esc_html($parent_category->name) . ' > ' . esc_html($category->name);
                // Adjust the link for child category
                $link = $shop_page_url . '?filter_category=' . $parent_category->term_id . '&filter_subcategory=' . $category->term_id;
            }
        }

        // Output the link
        echo '<a href="' . $link . '" class="category-result font-bold">' . $displayName . '</a>';
    }
    echo '</div>';
} else {
    echo '<p class="my-10 text-center h2">No categories found</p>';
}
$category_html = ob_get_clean();
    wp_reset_postdata();

    // Send JSON response
    wp_send_json(array(
        'products' => $product_html,
        'posts' => $post_html,
        'categories' => $category_html
    ));

    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_tintin_combined_search', 'tintin_combined_search');
add_action('wp_ajax_nopriv_tintin_combined_search', 'tintin_combined_search');


/* Login form on checkout page */
function custom_checkout_login_form() {
    if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
        return;
    }

    woocommerce_login_form(
        array(
            'message'  => __( 'Returning customer?', 'woocommerce' ) . ' ' . __( 'Click here to login', 'woocommerce' ),
            'redirect' => wc_get_checkout_url(),
            'hidden'   => true,
        )
    );
}
add_action( 'woocommerce_before_checkout_form', 'custom_checkout_login_form', 10 );


if (function_exists('acf_add_options_page')) {

    // Existing Product Page Modules Settings
    acf_add_options_page(array(
        'page_title' => 'Product Page Modules Settings', 
        'menu_title' => 'Product Page Modules', 
        'menu_slug' => 'product-page-modules-settings', 
        'capability' => 'edit_posts', 
        'redirect' => false 
    ));

    // Add new options page for Footer Settings
    acf_add_options_page(array(
        'page_title' => 'Footer Settings', 
        'menu_title' => 'Footer Settings', 
        'menu_slug' => 'footer-settings', 
        'capability' => 'edit_posts', 
        'redirect' => false 
    ));

    // Add new options page for Popup Settings
    acf_add_options_page(array(
        'page_title' => 'Popup Settings', 
        'menu_title' => 'Popup Settings', 
        'menu_slug' => 'popup-settings', 
        'capability' => 'edit_posts', 
        'redirect' => false 
    ));

    // Add new options page for Announcement Bar Settings
    acf_add_options_page(array(
        'page_title' => 'Announcement Bar Settings', 
        'menu_title' => 'Announcement Bar Settings', 
        'menu_slug' => 'announcement-bar-settings', 
        'capability' => 'edit_posts', 
        'redirect' => false 
    ));
}

// Remove variation from product title in the cart 
function tg_customize_cart_item_name( $title, $cart_item, $cart_item_key ) {
    if ( isset( $cart_item['product_id'] ) ) {
        $product = wc_get_product( $cart_item['product_id'] );
        if ( $product ) {
            // Using regular expression to remove the variation part (e.g., " - l")
            $title = preg_replace('/ - [^ ]+$/', '', $product->get_name());
        }
    }
    return $title;
}
add_filter( 'woocommerce_cart_item_name', 'tg_customize_cart_item_name', 10, 3 );


// Product Variations
function tg_get_formatted_product_variations( $cart_item ) {
    if (isset($cart_item['variation']) && is_array($cart_item['variation'])) {
        $variation_list = [];

        foreach ($cart_item['variation'] as $key => $value) {
            if (empty($value)) continue;

            $attribute_name = str_replace('attribute_', '', $key);
            $term = get_term_by('slug', $value, $attribute_name);
            if ($term) {
                $variation_list[] = $term->name;
            } else {
                $variation_list[] = $value;
            }
        }

        if (!empty($variation_list)) {
            return '<p class="product-variations text-[14px] italic leading-[0.14px] font-normal">' . implode(', ', $variation_list) . '</p>';
        }
    }
    return '';
}


// Display the custom text field in the WooCommerce admin
function variation_settings_fields($loop, $variation_data, $variation) {
    woocommerce_wp_text_input(
        array(
            'id' => 'custom_variation_title[' . $variation->ID . ']',
            'label' => __('Custom Variation Title', 'woocommerce'),
            'desc_tip' => 'true',
            'description' => __('Enter the custom title here.', 'woocommerce'),
            'value' => get_post_meta($variation->ID, 'custom_variation_title', true)
        )
    );
}
add_action('woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3);

// Save the custom text field
function save_variation_settings_fields($post_id) {
    $custom_title = $_POST['custom_variation_title'][$post_id];
    if (!empty($custom_title)) {
        update_post_meta($post_id, 'custom_variation_title', esc_attr($custom_title));
    }
}
add_action('woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2);

function add_custom_title_to_variation_data($data, $product, $variation) {
    $data['custom_title'] = get_post_meta($variation->get_id(), 'custom_variation_title', true);
    return $data;
}
add_filter('woocommerce_available_variation', 'add_custom_title_to_variation_data', 10, 3);


function customize_wc_add_to_cart_message_with_variation_title( $message, $product_id, $quantity ) {
    // Retrieve the custom title from the session
    $custom_title = WC()->session->get('recently_added_custom_title');

    if ( !empty($custom_title) ) {
        // Create the new message with the custom title
        $message = ' <a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
        $message .= sprintf( esc_html__( '"%s" has been added to your cart.', 'woocommerce' ), esc_html( $custom_title ) );

        // Clear the session variable
        WC()->session->__unset('recently_added_custom_title');

        return $message;
    }

    // Return default message if no custom title is found
    return $message;
}
add_filter( 'wc_add_to_cart_message_html', 'customize_wc_add_to_cart_message_with_variation_title', 10, 3 );

// Add the custom title to the cart item name
function customize_cart_item_name_with_custom_variation_title( $product_name, $cart_item, $cart_item_key ) {
    // Check if the custom title is set in the cart item
    if ( isset( $cart_item['custom_variation_title'] ) && ! empty( $cart_item['custom_variation_title'] ) ) {
        return esc_html( $cart_item['custom_variation_title'] );
    }

    // Return the default product name if no custom title is set
    return $product_name;
}
add_filter( 'woocommerce_cart_item_name', 'customize_cart_item_name_with_custom_variation_title', 10, 3 );


function custom_new_badge() {
    global $product;

    // Check if the product is in the "new-products" category
    if (has_term('tintin-products', 'product_cat', $product->get_id())) {
        echo '<span class="new-product-label">New!</span>';
    }
}

/* Account Pages */

function my_account_open_container() {
    echo '<section>';
    echo '<div class="container account-page">'; // Tailwind container classes
}
function my_account_close_container() {
    echo '</div>'; // Close the container div
    echo '</section>'; // Close the section
}

add_action( 'woocommerce_before_account_navigation', 'my_account_open_container', 5 );
add_action( 'woocommerce_after_account_content', 'my_account_close_container', 30 );

add_action( 'woocommerce_before_customer_login_form', 'my_account_open_container', 10 );
add_action( 'woocommerce_after_customer_login_form', 'my_account_close_container', 20 );




add_filter( 'woocommerce_product_tabs', 'tg_custom_remove_product_tabs', 98 );

function tg_custom_remove_product_tabs( $tabs ) {
    global $product;

    // Check if the product has custom attributes
    $has_custom_attributes = false;
    $attributes = $product->get_attributes();

    foreach ( $attributes as $attribute ) {
        // Check if the attribute is set to "display on the product page"
        if ( !$attribute->get_variation() && $attribute->get_visible() ) {
            $has_custom_attributes = true;
            break;
        }
    }

    // If no custom attributes, unset the additional information tab
    if ( ! $has_custom_attributes ) {
        unset( $tabs['additional_information'] );
    }

    return $tabs;
}

add_action( 'wp_footer', 'output_product_stock_quantity_script' );
function output_product_stock_quantity_script() {
    // Only on single product pages
    if( !is_product() ) return;

    global $product;
    if ( ! $product instanceof WC_Product ) {
        $product = wc_get_product( get_the_ID() );
    }
    
    $stock_quantity = $product->get_stock_quantity();
    ?>
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var stockQuantity = <?php echo json_encode($stock_quantity); ?>;
        
        var quantityContainers = document.querySelectorAll('.quantity.buttons_added');
        quantityContainers.forEach(function(quantityContainer) {
            if (stockQuantity === 1) {
                quantityContainer.style.display = 'none';
            }
        });
    });
    </script>
    <?php
}


