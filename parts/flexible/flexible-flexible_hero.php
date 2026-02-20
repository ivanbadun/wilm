<?php
$title = get_sub_field('hero_title');
$img   = get_sub_field('hero_image');

if ( ! $img ) {
    $img = get_field('default_hero_image', 'option');
}

$img_url = is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : (is_array($img) ? $img['url'] : $img);

?>
<section class="hero-banner" <?php bg($img_url)?>>
    <div class="hero-banner__overlay h-100">
        <div class="container h-100 d-flex align-items-center justify-content-center">
            <?php if ( $title ) : ?>
                <h1 class="hero-banner__title text-center">
                    <?php echo esc_html( $title ); ?>
                </h1>
            <?php endif; ?>
        </div>
    </div>
</section>