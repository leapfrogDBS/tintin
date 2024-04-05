<section>
    <div class="container grid grid-cols-1 lg:grid lg:grid-cols-3 gap-x-24">
    <div class="col-span-1 flex flex-row lg:flex-col gap-10 flex-wrap">
    <?php if ( have_rows('contact_block') ): ?>
        <?php while ( have_rows('contact_block') ) : the_row(); ?>
            <div class="contact-block">
                <h3 class="heading-three mb-4"><?php the_sub_field('cd_heading'); ?></h3>
                <?php if ( have_rows('contact_line') ): ?>
                    <?php while ( have_rows('contact_line') ) : the_row(); ?>
                        <?php 
                        $cb_text = get_sub_field('cb_text');
                        $cb_link = get_sub_field('cb_link'); // This is an array
                        if ( !empty($cb_link) && is_array($cb_link) ): 
                            $link_url = $cb_link['url'];
                            $link_title = $cb_link['title'] ?? ''; // Optional: handle title
                            ?>
                            <a href="<?php echo esc_url($link_url); ?>" class="p-one block"><?php echo nl2br(esc_html($cb_text)); ?></a>
                        <?php else: ?>
                            <p class="p-one"><?php echo nl2br(esc_html($cb_text)); ?></p>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
        </div>
        <div class="col-span-2 mt-12 lg:mt-0">
            <?php 
            $contact_form_shortcode = get_field('contact_form_shortcode');
            echo do_shortcode($contact_form_shortcode); 
            ?>
        </div>
    </div>
</section>
