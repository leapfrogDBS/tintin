<section class="mobile-filters h-screen fixed inset-0 z-50 bg-white hidden overflow-y-auto">
    <div class="py-8 shadow-custom">
        <div class="container grid grid-cols-3 items-center py-0">
            <button class="close-filters"><?php include(locate_template('assets/img/global/close.svg'));?></button>
            <h3 class="heading-three">Filters</h3>
            <button class="justify-self-end" id="reset-form"><?php include(locate_template('assets/img/global/refresh.svg'));?></button>
        </div>
    </div>

    <div class="container flex flex-col justify-between h-[80vh] px-[20px]">
        <div class="all-filters flex flex-col gap-y-4"> 
            
            <!-- Sort Filter -->
            <div class="grid grid-cols-3 items-center border-b border-shop-front-blue border-opacity-20 pb-4">
                <label for="mobile-order-filter" class="block p-one text-[16px] font-semibold">Sort by</label>
                <select id="mobile-order-filter" class="col-span-2 block p-one text-[16px] w-auto py-2 px-3 bg-white focus:outline-none">
                    <option value="">Sort By</option>
                    <option value="menu_order">Default sorting</option>
					<option value="popularity">Sort by popularity</option>
					<option value="rating">Sort by average rating</option>
					<option value="date">Sort by latest</option>
					<option value="price">Sort by price: low to high</option>
					<option value="price-desc">Sort by price: high to low</option>
                </select>
            </div>
        
           


            <!-- Category Filter -->
            <div class="grid grid-cols-3 items-center border-b border-shop-front-blue border-opacity-20 pb-4">
                <label for="mobile-category-filter" class="block p-one text-[16px] font-semibold">Category</label>
                <select id="mobile-category-filter" class="col-span-2 block p-one text-[16px] w-auto py-2 px-3 bg-white focus:outline-none">
                    <option value="">Select Category</option>
                    <!-- Category options populated from PHP -->
                    <?php
                    $categories = get_terms('product_cat', array('hide_empty' => true, 'parent' => 0));
                    foreach ($categories as $category) {
                        echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- Subcategory Filter (dynamically populated based on selected category) -->
            <div id="mobile-subcategory-filter-section" class="hidden grid grid-cols-3 items-center border-b border-shop-front-blue border-opacity-20 pb-4">
                <label for="mobile-subcategory-filter" class="block p-one text-[16px] font-semibold">Product Type</label>
                <select id="mobile-subcategory-filter" class="col-span-2 block p-one text-[16px] w-auto py-2 px-3 bg-white focus:outline-none">
                    <option value="">Select Subcategory</option>
                </select>
            </div>

            <!-- Character Filter -->
            <div class="grid grid-cols-3 items-center border-b border-shop-front-blue border-opacity-20 pb-4">
                <label for="mobile-character-filter" class="block p-one text-[16px] font-semibold">Character</label>
                <select id="mobile-character-filter" class="col-span-2 block p-one text-[16px] w-auto py-2 px-3 bg-white focus:outline-none">
                    <option value="">Select Character</option>
                    <!-- Character options populated from PHP -->
                    <?php
                    $characters = get_terms('pa_character', array('hide_empty' => false));
                    foreach ($characters as $character) {
                        echo '<option value="' . $character->term_id . '">' . $character->name . '</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- Language Filter -->
            <div class="grid grid-cols-3 items-center border-b border-shop-front-blue border-opacity-20 pb-4">
                <label for="mobile-language-filter" class="block p-one text-[16px] font-semibold">Language</label>
                <select id="mobile-language-filter" class="col-span-2 block p-one text-[16px] w-auto py-2 px-3 bg-white focus:outline-none">
                    <option value="">Select Language</option>
                    <!-- Language options populated from PHP -->
                    <?php
                    $languages = get_terms('pa_language', array('hide_empty' => false));
                    foreach ($languages as $language) {
                        echo '<option value="' . $language->term_id . '">' . $language->name . '</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- Material Filter -->
            <div class="grid grid-cols-3 items-center border-b border-shop-front-blue border-opacity-20 pb-4">
                <label for="mobile-material-filter" class="block p-one text-[16px] font-semibold">Material</label>
                <select id="mobile-material-filter" class="col-span-2 block p-one text-[16px] w-auto py-2 px-3 bg-white focus:outline-none">
                    <option value="">Select Material</option>
                    <!-- Material options populated from PHP -->
                    <?php
                    $models_category = get_term_by('slug', 'tintin-models', 'product_cat');
                    $material_terms = get_terms('product_cat', array('hide_empty' => false, 'parent' => $models_category->term_id));
                    foreach ($material_terms as $term) {
                        echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                    }
                    ?>
                </select>
            </div>

        </div>

        <!-- Show Results Button -->
        <button id="apply-mobile-filters" class="btn-medium btn bg-covers-turquoise">Show Results</button>
    </div>                  
</section>





