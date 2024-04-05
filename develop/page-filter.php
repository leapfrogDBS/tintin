<?php
/*
Template Name: Mobile Filter Page
*/

get_header();
?>

<section class="mobile-cateogry-workflow h-screen fixed inset-0 z-50 bg-white overflow-y-auto">
    <div class="py-8 shadow-custom">
        <div class="container flex justify-center items-center py-0">
            <h3 class="heading-three">Shop by Category</h3>
        </div>
    </div>
    <div class="relative overflow-x-hidden">
        <div id="first" class="container flex flex-col justify-between h-[80vh] p-0">
            
            <div class="all-categories grid grid-cols-3"> 
                <?php
                $categories = get_terms('product_cat', array('hide_empty' => true, 'parent' => 0));

                foreach ($categories as $category) {
                    // Get the term ID
                    $term_id = $category->term_id;
                    // Get the image ID associated with the category
                    $thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
                    // Get the image URL from the image ID
                    $image_url = wp_get_attachment_url($thumbnail_id);
                    ?>
                    <div class="category flex flex-col gap-y-4 items-center px-3 py-6 cursor-pointer mob-cat-selector" data-cat="<?php echo $category->term_id; ?>"> 
                        <?php if ($image_url): // Check if the category has an image associated ?>
                            <img class="h-auto w-full aspect-square object-cover object-center" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
                        <?php endif; ?>
                        <h3 class="heading-three text-[16px]"><?php echo esc_html($category->name); ?></h3>
                    </div>
                <?php
                }
                ?>
            </div>
        </div> 

        <div id="second" class="container flex flex-col h-[80vh] p-0 absolute top-0 z-40 bg-white">
            
            <?php
            // Fetch all parent product categories
            $parent_categories = get_terms('product_cat', array(
                'parent' => 0,
                'hide_empty' => false,
            ));

            $shop_page_url = get_permalink(wc_get_page_id('shop')); // Get the shop page URL once

            foreach ($parent_categories as $parent_category) {
                // Check if the term exists
                if (!$parent_category) continue;

                // Construct link for the parent category
                $category_link = $shop_page_url . '?filter_category=' . $parent_category->term_id;
                ?>
                

                    <?php
                    // Get and display subcategories
                    $subcategories = get_terms('product_cat', array(
                        'parent' => $parent_category->term_id,
                        'hide_empty' => false,
                    ));

                    if (!empty($subcategories)) { ?>
                        <div class="filter-cats break-inside-avoid px-12" data-filter="<?php echo $parent_category->term_id; ?>">
                            <div class="accordion-button flex items-center justify-between py-6">
                                <p class="p-one font-bold text-[20px]"><?php echo esc_html($parent_category->name); ?></p>
                                <span class="chevron">
                                    <?php include(locate_template('assets/img/global/chevron.svg')); ?>
                                </span>
                            </div>
                            <div class="!mt-0 pb-6 flex flex-col gap-y-2 filters-container hidden">
                                <a href="<?php echo esc_url($category_link); ?>" class="p-two font-normal">All</a>
                                <?php foreach ($subcategories as $subcategory) {
                                    $subcategory_link = $shop_page_url . '?filter_category=' . $parent_category->term_id . '&filter_subcategory=' . $subcategory->term_id; ?>
                                    <a class="p-two font-normal" href="<?php echo esc_url($subcategory_link); ?>"><?php echo esc_html($subcategory->name); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="filter-cats py-6 break-inside-avoid px-12">
                            <a href="<?php echo esc_url($category_link); ?>" class="p-one font-bold text-[20px]"><?php echo esc_html($parent_category->name); ?></a>
                        </div>
                    <?php } ?>
                
            <?php } ?>
        </div>
    </div>

                   
</section>


<style>
    #masthead, footer {
        display: none;
    }

    .category {
        border-bottom: 1px solid rgba(19, 60, 148, 0.2);
        border-right: 1px solid rgba(19, 60, 148, 0.2);
    }

    .category:last-child {
        border-right: 1px solid rgba(19, 60, 148, 0.2);
    }

    .all-categories > :nth-child(-n+3) {
        border-top: none;
    }
    .filter-cats {
        border-bottom: 1px solid rgba(19, 60, 148, 0.2);
    }

    #second {
        transform: translateX(100%);
        transition: transform 0.5s ease-in-out;
    }
    #second.show-this {
        transform: translateX(0%);
    }
</style>

<script>
    const cats = document.querySelectorAll('.mob-cat-selector');
    
    cats.forEach(cat => {
        cat.addEventListener('click', function() {
            const catID = this.dataset.cat; 
            const element = document.querySelector(`[data-filter="${catID}"]`);

            if (element) {
                // Toggle visibility of #first and #second based on the presence of a matching element
                document.querySelector('#second').classList.toggle('show-this');
                // Show the specific category's details
                element.querySelector('.filters-container').classList.toggle('hidden');
                setTimeout(() => {
                element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 500);
            } else {
                // If no matching element found, navigate to the category link
                window.location.href = '<?php echo esc_url($shop_page_url); ?>?filter_category=' + catID;
            }
        });
    });
</script>


<?php 
get_footer();


