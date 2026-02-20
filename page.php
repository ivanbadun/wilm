<?php
/**
 * Page
 */
get_header(); ?>

<main class="main-content">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-8 col-md-10 col-sm-12 col-12 mx-auto">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article <?php post_class( 'entry' ); ?>>
                            <h1 class="page-title entry__title text-center"><?php the_title(); ?></h1>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div title="<?php the_title_attribute(); ?>" class="entry__thumb text-center mb-4">
                                    <?php the_post_thumbnail( 'large', ['class' => 'img-fluid d-inline-block'] ); ?>
                                </div>
                            <?php endif; ?>

                            <div class="entry__content">
                                <?php the_content( '', true ); ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</main>

<?php get_footer(); ?>
