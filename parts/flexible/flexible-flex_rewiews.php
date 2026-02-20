<?php
$reviews_data = get_sub_field('rewiews_per_page');

if ( $reviews_data ) : ?>
    <section class="reviews-section">
        <div class="container">
            <div class="reviews-slider-wrapper">
                <div class="js-reviews-slick">

                    <?php foreach ( $reviews_data as $post ) : setup_postdata( $post );
                        $author_name = get_field('author_name', $post->ID);
                        $source      = get_field('source', $post->ID);
                        $stars       = get_field('stars', $post->ID);
                        $source_icon_url = '/assets/images/icons/' . strtolower(trim($source)) . '.png';
                        ?>
                        <div class="review-slide">
                            <div class="review-slide__inner">
                                <div class="review-slide__text">
                                    <?php the_content(); ?>
                                </div>

                                <div class="review-slide__meta">
                                    <?php if ( $source ) : ?>
                                        <div class="review-slide__source">
                                            <img src="<?php echo esc_url($source_icon_url); ?>" alt="<?php echo esc_attr($source); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <div class="review-slide__stars">
                                        <?php
                                        $rating = intval($stars);
                                        for ( $i = 1; $i <= 5; $i++ ) : ?>
                                            <span class="star <?php echo ( $i <= $rating ) ? 'is-active' : ''; ?>">★</span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; wp_reset_postdata(); ?>

                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<script>
    jQuery(document).ready(function($) {
        var $slider = $('.js-reviews-slick');
        if ($slider.length) {
            $slider.slick({
                dots: true,
                arrows: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                adaptiveHeight: true,
                customPaging: function(slider, i) {
                    return '<button type="button"></button>';
                }
            });
        }
    });
</script>