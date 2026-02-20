<?php
/**
 * Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Set up Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <!-- Remove Microsoft Edge's & Safari phone-email styling -->
    <meta name="format-detection" content="telephone=no,email=no,url=no">

    <!-- Add external fonts below (GoogleFonts / Typekit) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700&display=swap">

    <?php wp_head(); ?>
</head>

<body <?php body_class('no-outline'); ?>>
<?php wp_body_open(); ?>

<!-- <div class="preloader hide-for-medium">
	<div class="preloader__icon"></div>
</div> -->

<!-- BEGIN of Alert Bar -->
<?php if (get_field('enable_alert_bar', 'options')) :
    $bg_color = get_field('alert_background_color', 'options');
    $text_color = get_field('alert_text_color', 'options');
    $content = get_field('alert_content', 'options');

    if ( $content ): ?>
        <div id="alert-bar" class="alert-bar"
             style="background-color: <?php echo $bg_color; ?>; color: <?php echo $text_color; ?>;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="alert-bar__content">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;
endif; ?>
<!-- END of Alert Bar -->

<!-- BEGIN of header -->
<header class="header-main d-flex flex-column"> <?php if( have_rows('top_header_logos', 'option') ): ?>
        <div class="brand-bar border-bottom py-2 order-1">
            <div class="container">
                <div class="brand-grid">
                    <?php while( have_rows('top_header_logos', 'option') ): the_row();
                        $image = get_sub_field('top_header_logo');
                        $url = get_sub_field('logo_url');
                        ?>
                        <div class="brand-item">
                            <?php if($url): ?><a href="<?php echo esc_url($url); ?>" target="_blank"><?php endif; ?>
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                <?php if($url): ?></a><?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <nav class="navbar navbar-expand-lg py-2 order-2 position-relative">
        <div class="container align-items-center">

            <a class="navbar-brand m-0 p-0" href="<?php echo esc_url(home_url('/')); ?>">
                <?php
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                if ( $custom_logo_id ) {
                    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                    echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="main-logo-img">';
                } else {
                    echo '<h1 class="m-0" style="font-size:1.5rem;">' . get_bloginfo('name') . '</h1>';
                }
                ?>
            </a>

            <button class="navbar-toggler collapsed" type="button"
                    data-toggle="collapse"
                    data-target="#mainMenu"
                    aria-controls="mainMenu"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <?php
            $phone = get_field('header_phone', 'option');
            $button = get_field('header_button', 'option');
            ?>

            <div class="mobile-action-row d-flex d-lg-none w-100 align-items-center justify-content-between mt-3 pt-2 border-top">
                <div class="d-flex align-items-center gap-3">
                    <?php if($phone): ?>
                        <a href="tel:<?php echo preg_replace('/[^\d+]/', '', $phone); ?>" class="phone-link">
                            <i class="fa fa-phone" aria-hidden="true"></i> <?php echo esc_html($phone); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php if($button): ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="btn btn-small"><?php echo esc_html($button['title']); ?></a>
                <?php endif; ?>
            </div>

            <div class="collapse navbar-collapse" id="mainMenu"> <div class="nav-wrapper-right ms-auto d-flex flex-column align-items-end w-100">

                    <div class="desktop-top-contacts d-none d-lg-flex align-items-center mb-1">
                        <?php if($phone): ?>
                            <a href="tel:<?php echo preg_replace('/[^\d+]/', '', $phone); ?>" class="phone-link me-3 text-teal">
                                <i class="fa fa-phone" aria-hidden="true"></i> <?php echo esc_html($phone); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex align-items-center flex-column flex-lg-row w-100 justify-content-lg-end">
                        <?php if ( has_nav_menu( 'header-menu' ) ) : ?>
                            <?php wp_nav_menu( array(
                                    'theme_location' => 'header-menu',
                                    'menu_id'        => 'main-menu-list',
                                    'menu_class'     => 'navbar-nav text-uppercase fw-bold',
                                    'container'      => false,
                                    'walker'         => new Bootstrap_Navigation(),
                            ) ); ?>
                        <?php endif; ?>

                        <?php if($button): ?>
                            <a href="<?php echo esc_url($button['url']); ?>" class="btn btn-small hide">
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
    jQuery(document).ready(function($) {
        $('.nav-item.dropdown > .nav-link').on('click', function(e) {
            if ($(window).width() < 992) {
                e.preventDefault();
                var $parent = $(this).parent('.nav-item');
                var $menu = $(this).siblings('.dropdown-menu');

                // Переключаем классы
                $parent.toggleClass('show');
                $menu.toggleClass('show');
            }
        });
    });
</script>
<!-- END of header -->
