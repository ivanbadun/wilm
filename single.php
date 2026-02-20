<?php
/**
 * Single Product / Post
 */
get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <?php
    // Получаем данные Hero из ACF
    $hero_title = get_field('hero_title');
    $hero_img   = get_field('hero_image_product');

    // Резервное изображение
    if ( ! $hero_img ) {
        $hero_img = get_post_thumbnail_id() ? get_post_thumbnail_id() : get_field('default_hero_image', 'option');
    }
    $hero_img_url = is_array($hero_img) ? $hero_img['url'] : wp_get_attachment_image_url($hero_img, 'full');
    ?>

    <section class="hero-banner" <?php bg($hero_img)?>>
        <div class="hero-banner__overlay">
            <div class="container h-100 d-flex align-items-center justify-content-center">
                <h1 class="hero-banner__title text-center text-white">
                    <?php echo $hero_title ? esc_html($hero_title) : get_the_title(); ?>
                </h1>
            </div>
        </div>
    </section>

    <main class="main-content py-5">
        <div class="container">
            <div class="row align-items-center"> <div class="col-lg-6 mb-4 mb-lg-0">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="entry__image">
                            <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded shadow']); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-6">
                    <div class="career-details">
                        <div class="entry__content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>

            </div>

            <?php if ( have_rows( 'flexible_content' ) ) : ?>
                <div class="mt-5">
                    <?php while ( have_rows( 'flexible_content' ) ) : the_row();
                        get_template_part( 'parts/flexible/' . get_row_layout() );
                    endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>