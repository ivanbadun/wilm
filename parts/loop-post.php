<?php
/**
 * Post item (Card style)
 *
 * This template part is used for displaying post items in search results or archives.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('product-card h-100 mb-4'); ?>>
    <a href="<?php the_permalink(); ?>" class="product-card__link shadow-sm d-block text-decoration-none">

        <div class="product-card__image-wrapper">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail('medium_large', [
                        'class' => 'product-card__img img-fluid w-100',
                        'style' => 'object-fit: cover; aspect-ratio: 1/1;'
                ]); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg"
                     alt="<?php _e('No image', 'default'); ?>"
                     class="product-card__img img-fluid w-100"
                     style="object-fit: cover; aspect-ratio: 1/1;">
            <?php endif; ?>
        </div>

        <div class="product-card__title-box p-3">
            <h3 class="product-card__title h5 mb-0 text-dark">
                <?php the_title(); ?>
            </h3>

            <?php if ( is_sticky() ) : ?>
                <span class="badge bg-warning text-dark mt-2"><?php _e( 'Sticky', 'default' ); ?></span>
            <?php endif; ?>
        </div>

    </a>
</article>