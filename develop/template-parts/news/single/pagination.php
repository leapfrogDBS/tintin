<section>
    <div class="container pt-0">
        <div class="post-navigation flex flex-col sm:flex-row justify-center sm:justify-between items-center gap-y-6">
        <?php
        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if (!empty($prev_post)): ?>
            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                <h3 class="heading-three mb-2.5 text-center sm:text-left">Previous</h3>
                <p class="p-one"><?php echo esc_html(get_the_title($prev_post->ID)); ?></p>
            </a>
        <?php endif; ?>

        <?php if (!empty($next_post)): ?>
            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
            <h3 class="heading-three mb-2.5 text-center sm:text-right">Next</h3>
            <p class="p-one"><?php echo esc_html(get_the_title($next_post->ID)); ?></p>
            </a>
        <?php endif; ?>
    </div>        
    </div>
</section>
