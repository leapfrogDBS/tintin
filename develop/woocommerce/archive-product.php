<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

get_template_part('template-parts/hero-sections/standard-hero');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
do_action( 'woocommerce_before_shop_loop' ); 

// Detect the category filter from URL
$filtered_category = isset($_GET['filter_category']) ? $_GET['filter_category'] : '';
$filtered_subcategory = isset($_GET['filter_subcategory']) ? $_GET['filter_subcategory'] : '';

get_template_part('template-parts/standard-hero');

get_template_part('template-parts/product-filters-mobile');

?>
<section class="shop-page-items">
	<div id="mobileFilterBtn" class="grid grid-cols-2 md:hidden">
		<div class="mobile-filters-container text-shop-front-blue py-6 gap-x-3 z-30 flex justify-center">
			<?php include(locate_template('assets/img/global/filters.svg'));?>
			<h5 class="heading-five">Filters</h5>
		</div>
		<div class="mobile-filters-container text-shop-front-blue py-6 gap-x-3 z-30 flex justify-center">
			<?php include(locate_template('assets/img/global/sort.svg'));?>
			<h5 class="heading-five">Sort</h5>
		</div>
	</div>

	<div class="container pt-0 md:py-[60px] px-4 sm:px-[40px] lg:px-[80px]">
			<div class="hidden md:flex top-filters justify-between">
			<div class="flex items-center gap-x-10 pb-10">
				<h2 class="heading-two leading-none">Filters</h2>
				<div id="selected-categories"></div>
			</div>
			<div class="custom-ordering">
				<select id="custom-ordering-select">
					<option value="menu_order">Default sorting</option>
					<option value="popularity">Sort by popularity</option>
					<option value="rating">Sort by average rating</option>
					<option value="date">Sort by latest</option>
					<option value="price">Sort by price: low to high</option>
					<option value="price-desc">Sort by price: high to low</option>
				</select>
			</div>	
		</div>

		<div class="flex justify-between gap-x-12 !mt-0 pt-8 md:border-t-2 custom-border">

			<div class="hidden md:block shop-filers-container sticky top-[var(--dynamic-top-offset)] h-screen overflow-auto w-1/3 pb-24">
				<div class="shop-filters">
					<div class="filter-group">
						<div class="accordion-button">
							<span class="chevron">
								<?php include(locate_template('assets/img/global/chevron.svg'));?>
							</span>
							<h3 class="filter-title">Category</h3>
						</div>
						<div class="filters-container category-filter hidden">
							<div class="filter-terms">
								<?php
								$terms = get_terms('product_cat', array('hide_empty' => true, 'parent' => 0));
								foreach ($terms as $term) {
									echo '<div class="filter-checkbox">';
									echo '<input type="checkbox" id="cat_' . $term->term_id . '" class="product-category" value="' . $term->term_id . '">';
									echo '<label for="cat_' . $term->term_id . '">' . $term->name . '</label>';
									echo '</div>';
								}
								?>
							</div>
						</div>
					</div>

					<div id="product-filters" class="filter-group">
						<div class="accordion-button">
							<span class="chevron">
								<?php include(locate_template('assets/img/global/chevron.svg'));?>
							</span>
							<h3 class="filter-title">Product Type</h3>
							</div>
						<div class="filters-container subcategory-filter hidden">
							<div id="subcategories-container" class="filter-terms"></div>
						</div>
					</div>
					
					<div class="filter-group">
						<div class="accordion-button">
							<span class="chevron">
								<?php include(locate_template('assets/img/global/chevron.svg'));?>
							</span>
							<h3 class="filter-title">Character</h3>
							</div>
						<div class="filters-container hidden">
							<div class="filter-terms character">
							<?php
								$character_terms = get_terms('pa_character', array(
									'hide_empty' => false,
									'orderby'    => 'count',
									'order'      => 'DESC', // Use 'ASC' for ascending order
								));
								
								foreach ($character_terms as $term) {
									$character_image = get_term_meta($term->term_id, 'character-image', true);
									echo '<div class="character-filter-item flex-shrink-0">';
									echo '<input type="checkbox" id="char_' . $term->term_id . '" class="character-filter-checkbox" value="' . $term->term_id . '" style="display: none;">';
									echo '<label for="char_' . $term->term_id . '">';
									if ($character_image) {
										echo '<img src="' . esc_url($character_image) . '" alt="' . esc_attr($term->name) . '" class="character-filter-image w-[88px] cursor-pointer">';
									} else {
										echo '<span>' . $term->name . '</span>';
									}
									echo '</label>';
									echo '</div>';
								} 
								?>
							</div>
						</div>
					</div>
					
					<div class="filter-group">
						<div class="accordion-button">
							<span class="chevron">
								<?php include(locate_template('assets/img/global/chevron.svg'));?>
							</span>
							<h3 class="filter-title">Language</h3>
						</div>
						<div class="filters-container hidden">
							<div class="filter-terms">
								<?php
								$language_terms = get_terms('pa_language', array('hide_empty' => false)); // Replace 'pa_language' with the actual attribute slug
								foreach ($language_terms as $term) {
									echo '<div class="filter-checkbox">';
									echo '<input type="checkbox" id="lang_' . $term->term_id . '" class="language-filter-checkbox" value="' . $term->term_id . '">';
									echo '<label for="lang_' . $term->term_id . '">' . $term->name . '</label>';
									echo '</div>';
								}
								?>
							</div>
						</div>
					</div>


					<div class="filter-group">
						<div class="accordion-button">
							<span class="chevron">
								<?php include(locate_template('assets/img/global/chevron.svg'));?>
							</span>
							<h3 class="filter-title">Material</h3>
						</div>
						<div class="filters-container hidden">
							<div class="filter-terms material">
								<?php
								// Replace 'models' with the actual slug of your main category 'Models'
								$models_category = get_term_by('slug', 'tintin-models', 'product_cat');
								$material_terms = get_terms('product_cat', array('hide_empty' => false, 'parent' => $models_category->term_id));
								foreach ($material_terms as $term) {
									echo '<div class="filter-checkbox">';
									echo '<input type="checkbox" id="mat_' . $term->term_id . '" class="material-filter-checkbox" value="' . $term->term_id . '">';
									echo '<label for="mat_' . $term->term_id . '">' . $term->name . '</label>';
									echo '</div>';
								}
								?>
							</div>
						</div>
					</div>
				
					<div class="filter-group">
						<div class="accordion-button">
							<span class="chevron">
								<?php include(locate_template('assets/img/global/chevron.svg'));?>
							</span>
							<h3 class="filter-title">Price</h3>
						</div>
						<div class="filters-container hidden">
							<div class="filter-terms">
								<div class="heading-five mb-2">
								£<span id="min-price"></span>  -  £<span id="max-price"></span>
								</div>
								<div id="price-range-slider" class="price-slider px-6"></div>
							</div>
						</div>
					</div>

				
				</div>
			</div>

			<div class="shop-products w-full md:w-2/3">
								
								
				<?php
				if ( woocommerce_product_loop() ) {

					/**
					 * Hook: woocommerce_before_shop_loop.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					

					woocommerce_product_loop_start();
					
					

					woocommerce_product_loop_end(); 
					

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
				} ?>
				<div id="loading-icon" class="flex justify-center hidden col-span-2 lg:col-span-3">
					<img class="w-28 h-auto" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/global/loader.gif" alt="Loading...">
				</div>
				
					<p id="load-more" class="hidden btn btn-small bg-white border-shop-front-blue border-2 text-shop-front-blue mt-12">Load More</p>	
				
			</div>
			
		</div>

	</div>
	
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {

	if (window.innerWidth > 769) {
    document.addEventListener('productFiltersLoaded', function() {
        var filteredCategory = "<?php echo esc_js($filtered_category); ?>";
        var filteredSubcategory = "<?php echo esc_js($filtered_subcategory); ?>";
		if (filteredCategory) {
            var parentCheckbox = document.querySelector('.product-category[value="' + filteredCategory + '"]');
            if (parentCheckbox) {
                parentCheckbox.checked = true;
                document.querySelector('.category-filter').classList.remove('hidden');
				fetchSubcategories(filteredCategory);
				if (filteredSubcategory) {    
					document.addEventListener('subcategoriesUpdated', function() {
						if (filteredSubcategory) {
							var subcategoryCheckbox = document.querySelector('.product-subcategory[value="' + filteredSubcategory + '"]');
							if (subcategoryCheckbox) {
								subcategoryCheckbox.checked = true;
								document.querySelector('.subcategory-filter').classList.remove('hidden');
								updateProducts();
							}
						} 
						
                	},);
				}
				else {
					updateProducts();
				}
            }
        } else {
			updateProducts();
		}
		
    });
}
});


 document.addEventListener('DOMContentLoaded', function() {
    const mobileFilterBtn = document.getElementById('mobileFilterBtn');
    const mobileFilters = document.querySelector('.mobile-filters');
    const closeFiltersBtn = document.querySelector('.close-filters');
    const resetFormBtn = document.getElementById('reset-form');
    const mobileSubcategoryFilterSection = document.getElementById('mobile-subcategory-filter-section');
    const formElements = mobileFilters.querySelectorAll('select');
	const applyFiltersBtn = document.getElementById('apply-mobile-filters');
	
	
	if (window.innerWidth < 769) {
        var filteredCategory = "<?php echo esc_js($filtered_category); ?>";
        var filteredSubcategory = "<?php echo esc_js($filtered_subcategory); ?>"
		document.addEventListener('productFiltersLoaded', function() {
			if (filteredCategory) {
				document.getElementById('mobile-category-filter').value = filteredCategory;
				fetchSubcategories(filteredCategory, true);
				if (filteredSubcategory) {
					document.addEventListener('subcategoriesUpdated', function() {
						document.getElementById('mobile-subcategory-filter').value = filteredSubcategory;
						setTimeout(function() {
							applyFiltersBtn.click();
						}, 100);
					});
				} else {
					setTimeout(function() {
						applyFiltersBtn.click();
					}, 100);
				}
			}
			
		});
	}


    mobileFilterBtn.addEventListener('click', () => {
        mobileFilters.classList.toggle('hidden');
    });

    closeFiltersBtn.addEventListener('click', () => {
        mobileFilters.classList.add('hidden');
    });

    resetFormBtn.addEventListener('click', () => {
        formElements.forEach(el => el.value = ''); // Reset all select elements
		mobileSubcategoryFilterSection.classList.add('hidden'); // Hide subcategory filter section
		updateProducts(1); // Reset products
    });

	applyFiltersBtn.addEventListener('click', () => {
        mobileFilters.classList.add('hidden');
		const mobileFiltersData = gatherMobileFilters();
    	updateProducts(1, mobileFiltersData);
		window.scrollTo({ top: 0, behavior: 'smooth' });	
       
    });

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

});

</script>

<?php get_template_part('template-parts/page-modules'); ?>
<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );


get_footer( 'shop' );

