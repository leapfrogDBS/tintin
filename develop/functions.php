<?php
/**
 * tintin functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tintin
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.1.5' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tintin_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on tintin, use a find and replace
		* to change 'tintin' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'tintin', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	
	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'tintin_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'tintin_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tintin_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tintin_content_width', 640 );
}
add_action( 'after_setup_theme', 'tintin_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tintin_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'tintin' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'tintin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'tintin_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tintin_scripts() {
	wp_enqueue_style('tintin-style', get_template_directory_uri() . '/style.css', '', _S_VERSION);
	wp_style_add_data( 'tintin-style', 'rtl', 'replace' );

	// Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Figtree:wght@500;600;700&display=swap', array(), null);

	/* Splide */
	wp_enqueue_style('splide-css', get_template_directory_uri() . '/assets/css/splide.min.css', '', _S_VERSION);
    wp_enqueue_script('splide-js', get_template_directory_uri() . '/scripts/lib/splide.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('splide-config-js', get_template_directory_uri() . '/scripts/site/splide-config.min.js', array('splide-js'), _S_VERSION, true);


	wp_enqueue_style('fancybox-css', get_template_directory_uri().'/assets/css/fancybox.css', '', _S_VERSION);
    wp_enqueue_script('fancybox-js', get_template_directory_uri() . '/scripts/lib/fancybox.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('fancybox-config-js', get_template_directory_uri() . '/scripts/site/fancybox-config.min.js', array( 'fancybox-js' ), _S_VERSION, true);


	wp_enqueue_script('tintin-app-js', get_template_directory_uri() . '/scripts/site/app.min.js', array(), _S_VERSION	, true);
    $shop_page_url = get_permalink(wc_get_page_id('shop'));
    wp_localize_script('tintin-app-js', 'wpVars', array(
        'shopPageUrl' => $shop_page_url,
        'homeUrl' => home_url()
    ));
	
	// Enqueue Mapbox
    wp_enqueue_script('mapbox-gl-js', 'https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js', array(), null, true);
    wp_enqueue_style('mapbox-gl-css', 'https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css');

    // Ajax
    wp_enqueue_script('post-filters-ajax', get_template_directory_uri() . '/scripts/site/posts-filters.min.js', array('jquery'));
    wp_localize_script('post-filters-ajax', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));   
    
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tintin_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/* Custom Image Sizes */
add_action('after_setup_theme', 'custom_image_sizes');
function custom_image_sizes() {
    add_image_size('product_previews', 240, 240, true);
	add_image_size('news_previews', 400, 200, true);
    add_image_size('news_page', 300, 330, true);
}

  
/* Custom Excerpt Length */
function custom_excerpt_length( $length ) {
    return 14; 
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/* Remove [...] from excerpt */
function custom_excerpt_more($more) {
    return '...'; // This will remove the ellipsis
}
add_filter('excerpt_more', 'custom_excerpt_more');

/* Breadcrumbs */

/*Create custom breadcurmbs*/
function custom_breadcrumbs() {
    $separator = ' / ';
    $home_title = 'Home';

    global $post;
    $home_link = home_url('/');

    echo '<nav class="breadcrumbs">';

    if (!is_front_page()) {
        echo '<a href="' . $home_link . '">' . $home_title . '</a>' . $separator;
    }

    if (is_category() || is_single()) {
        $categories = get_the_category();
        if (!empty($categories)) {
            $category = $categories[0];
            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>' . $separator;
        }

        if (is_single()) {
            echo the_title();
        }
    } elseif (is_page()) {
        if ($post->post_parent) {
            $ancestors = get_post_ancestors($post->ID);
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                echo '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>' . $separator;
            }
        }
        echo the_title();
    } elseif (is_home()) {
        echo 'Journal';
    } elseif (is_shop()) {
        echo 'Shop';
    }

    echo '</nav>';
}


/* Register Menus */
function my_custom_menu_setup() {
    register_nav_menus( array(
        'menu-left' => esc_html__( 'Left Menu', 'tintin' ),
        'menu-right' => esc_html__( 'Right Menu', 'tintin' ),
        'mega-menu-categories' => esc_html__( 'Mega Menu Categories', 'tintin' ),
    ) );
}
add_action( 'after_setup_theme', 'my_custom_menu_setup' );



add_action('wp_ajax_filter_posts', 'my_filter_posts_function');
add_action('wp_ajax_nopriv_filter_posts', 'my_filter_posts_function');

function my_filter_posts_function() {
    $category = $_POST['category'];
    $paged = isset($_POST['page']) ? $_POST['page'] : 1;

    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'paged' => $paged,
        'category_name' => $category === 'all' ? '' : $category
    );
    
    $the_query = new WP_Query($args);

    // Start buffering the output
    ob_start();

    if ($the_query->have_posts()) :
        echo '<div id="posts-container">';
        while ($the_query->have_posts()) : $the_query->the_post();
           	get_template_part('template-parts/news/news-card');
        endwhile;
        echo '</div>';

        // Pagination
        echo paginate_links(array(
            'total' => $the_query->max_num_pages,
            'current' => $paged,
            'format' => '?paged=%#%',
        ));
    else :
        echo '<h3 class="heading-three text-center">No posts found.</h3>';
    endif;

    wp_reset_postdata();

    // Get the buffered content
    $response = ob_get_clean();

    // Send the response
    echo $response;
    wp_die();
}

/*Direct post category to posts */
function custom_category_link($termlink, $term, $taxonomy) {
    if ($taxonomy === 'category') {
        $posts_page_id = get_option('page_for_posts');
        if ($posts_page_id) {
            return get_permalink($posts_page_id);
        }
    }
    return $termlink;
}

add_filter('term_link', 'custom_category_link', 10, 3);

/* Custom Walker Nav Menu */
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        if ($item->title == 'Shop' && $depth === 0) {
            // Add a class to the 'Shop' menu item
            $item->classes[] = 'shop-item';
            
            // Start capturing the output for the menu item
            ob_start();
            parent::start_el($output, $item, $depth, $args, $id);
            
            // Add the chevron SVG
            $chevron_svg_path = get_template_directory() . '/assets/img/global/chevron.svg';
            if (file_exists($chevron_svg_path)) {
                include $chevron_svg_path;
            }

            // Include the mega menu content
            
            $mega_menu_content = ob_get_clean();

            // Append the captured output and mega menu content
            $output .= $mega_menu_content;
        } else {
            // Default behavior for other menu items
            parent::start_el($output, $item, $depth, $args, $id);
        }
    }
}

function add_my_account_to_menu( $items, $args ) {
    if ( $args->theme_location == 'menu-right' ) {
        if ( is_user_logged_in() ) {
            $items .= '<li class="menu-item"><a class="whitespace-nowrap" href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '"> My Account</a></li>';
        } else {
            $items .= '<li class="menu-item"><a class="whitespace-nowrap" href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '">Sign in</a></li>';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_my_account_to_menu', 10, 2 );
