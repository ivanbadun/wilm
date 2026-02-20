<?php
/**
 * Template Name: Products
 */
get_header(); ?>

<!-- BEGIN of main content -->
<?php if ( have_rows( 'flex_part' ) ) : ?>
    <?php while ( have_rows( 'flex_part' ) ): the_row(); ?>
        <?php get_template_part( 'parts/flexible/flexible', get_row_layout() ); ?>
    <?php endwhile; ?>
<?php endif; ?>
<!-- END of main content -->

<!-- BEGIN of main content -->
<div class="container py-5">
    <div class="row">
        <?php
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $count = get_field('products_per_page');
        $order_val = get_field('products_order');

        $args = array(
                'post_type'      => 'product',
                'posts_per_page' => $count ? $count : 12,
                'status'         => 'publish',
                'paged'          => $paged,
                'orderby'        => $order_val ? $order_val : 'date',
                'order'          => ($order_val == 'title') ? 'ASC' : 'DESC'
        );

        $products_query = new WP_Query( $args );

        if ( $products_query->have_posts() ) : ?>

            <?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
                <div class="col-lg-3 col-md-6 col-12 my-4">
                    <?php get_template_part( 'parts/product' ); ?>
                </div>
            <?php endwhile; ?>

            <div class="col-12 pagination-wrapper my-5">
                <?php
                echo paginate_links( array(
                        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                        'total'        => $products_query->max_num_pages,
                        'current'      => max( 1, $paged ),
                        'prev_text'    => '« Prev',
                        'next_text'    => 'Next »',
                        'type'         => 'plain'
                ) );
                ?>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <div class="col-12">
                <p class="text-center"><?php _e( 'No products yet', 'default' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- END of main content -->

<?php get_footer(); ?>
