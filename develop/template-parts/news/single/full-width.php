<?php if(get_the_content()) : ?>
    <section>
        <div class="container">
            <div class="wysiwyg">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>