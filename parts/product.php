<style>

</style>

<article id="post-<?php the_ID(); ?>" <?php post_class('product-card h-100'); ?>>
    <a href="<?php the_permalink(); ?>" class="product-card__link">
        <div class="product-card__image-wrapper">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail('medium_large', ['class' => 'product-card__img']); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="No image" class="product-card__img">
            <?php endif; ?>
        </div>

        <div class="product-card__title-box">
            <h3 class="product-card__title">
                <?php the_title(); ?>
            </h3>
        </div>
    </a>
</article>