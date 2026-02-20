<?php

$buttons = get_sub_field('products_flex_buttons');
$topbuttons = get_sub_field('products_flex_top_buttons');

$section_title   = get_sub_field('products_flex_title');
$description     = get_sub_field('products_flex_content');
$manual_products = get_sub_field('products_on_flexible');

$categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
]);

echo "<script>const wp_ajax_url = '" . admin_url('admin-ajax.php') . "';</script>";

?>

<section class="products-module">
    <div class="container">

        <div class="products-module__header">
            <div class="header-left">
                <?php if ( $section_title ) : ?>
                    <h2><?php echo esc_html( $section_title ); ?></h2>
                <?php endif; ?>

                <div class="d-flex justify-content-between">
                    <select id="product-filter" class="product-dropdown w-25">
                        <option value="disabled selected"><?php _e( 'Select a Product', 'default' ); ?></option>

                        <option value="all">All</option>

                        <?php foreach ( $categories as $cat ) : ?>
                            <option value="<?php echo esc_attr( $cat->slug ); ?>">
                                <?php echo esc_html( $cat->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="header-right mx-2">
                        <?php render_custom_buttons( $topbuttons ); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if ( $description ) : ?>
            <div class="products-module__description">
                <?php echo wp_kses_post( $description ); ?>
            </div>
        <?php endif; ?>

        <div id="products-grid" class="row g-4 my-4">
            <?php
            if ( $manual_products ) :
                global $post;
                foreach ( $manual_products as $post ) : setup_postdata( $post );

                    $terms = get_the_terms( get_the_ID(), 'product_cat' );
                    $term_slugs = $terms ? implode( ' ', wp_list_pluck( $terms, 'slug' ) ) : '';
                    ?>

                    <div class="col-12 col-md-6 col-lg-3 product-item" data-category="<?php echo esc_attr( $term_slugs ); ?>">
                        <?php
                        get_template_part( 'parts/product' );
                        ?>
                    </div>

                <?php endforeach;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <div class="products-module__footer d-flex align-content-center justify-content-center">
            <?php render_custom_buttons( $buttons ); ?>
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filter = document.getElementById('product-filter');
        const grid = document.getElementById('products-grid');

        if (!filter || !grid) return;

        filter.addEventListener('change', function() {
            const selectedCat = this.value;

            if (!selectedCat) return;

            grid.style.opacity = '0.5';

            const formData = new FormData();
            formData.append('action', 'filter_products');
            formData.append('category', selectedCat);

            fetch(wp_ajax_url, {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    grid.innerHTML = data;
                    grid.style.opacity = '1';
                })
                .catch(error => {
                    console.error('Error:', error);
                    grid.style.opacity = '1';
                });
        });
    });
</script>