<a href="<?php echo get_permalink(); ?>" class="news-card">
    <!-- Display the featured image -->
    <div class="featured-image">
        <?php echo the_post_thumbnail('news_page', array( 'class' => 'w-full h-auto aspect-square object-cover object-center' )); ?>
    </div>

    <div class="post-details">
        <!-- Display the post title -->
        <h4 class="post-title"><?php echo get_the_title(); ?></h4>

        <!-- Display the post date -->
        <p class="post-date"><?php echo get_the_date(); ?></p>

        <!-- Display the post excerpt -->
        <p class="post-excerpt">
            <?php 
                $custom_excerpt = wp_trim_words(get_the_excerpt(), 14); 
                echo $custom_excerpt;
            ?>
        </p>
    </div>
</a>