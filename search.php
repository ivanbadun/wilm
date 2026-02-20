<?php
/**
 * Search Results Template
 */
get_header(); ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <main class="main-content">
                    <h1 class="page-title mb-4">
                        <?php printf( __( 'Search Results for: %s', 'default' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?>
                    </h1>

                    <div class="search-form-container mb-5">
                        <?php get_search_form(); ?>
                    </div>

                    <?php if ( have_posts() ) : ?>
                        <div class="row posts-list">
                            <?php while ( have_posts() ) : the_post(); ?>
                                <div class="col-lg-3 col-md-6 col-12 my-4 d-flex align-items-stretch">
                                    <?php
                                    // Используем loop-post, который мы правили ранее
                                    get_template_part( 'parts/loop', 'post' );
                                    ?>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="col-12 pagination-wrapper my-5 text-center">
                            <?php
                            global $wp_query; // Используем глобальный запрос для получения количества страниц

                            echo paginate_links( array(
                                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                    'total'        => $wp_query->max_num_pages,
                                    'current'      => max( 1, get_query_var( 'paged' ) ),
                                    'prev_text'    => '« Prev',
                                    'next_text'    => 'Next »',
                                    'type'         => 'plain'
                            ) );
                            ?>
                        </div>

                    <?php else : ?>
                        <div class="col-12">
                            <p class="text-center"><?php _e( 'Sorry, but nothing matched your search terms.', 'default' ); ?></p>
                        </div>
                    <?php endif; ?>
                </main>
            </div>
        </div>
    </div>

<?php get_footer(); ?>