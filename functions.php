<?php

use theme\CreateLazyImg;
use theme\DynamicAdmin;
use theme\WlAcfGfField;

/**
 * Functions
 */

/** ========================================================================
 * Constants.
 */

define( 'IMAGE_PLACEHOLDER', get_stylesheet_directory_uri() . '/assets/images/placeholder.jpg' );

/** ========================================================================
 * Included Functions.
 */

spl_autoload_register(function ($class_name) {
    if (0 === strpos($class_name, 'theme\\')) {
        $class_name = str_replace('theme\\', '', $class_name);
        $file = get_stylesheet_directory() . "/inc/classes/{$class_name}.php";

        if (!file_exists($file)) {
            echo sprintf(__('Error locating <code>%s</code> for inclusion.', 'bwp'), $file);
        } else {
            require_once $file;
        }
    }
});

array_map(function ($filename) {
    $file = get_stylesheet_directory() . "/inc/{$filename}.php";
    if (!file_exists($file)) {
        echo sprintf(__('Error locating <code>%s</code> for inclusion.', 'bwp'), $file);
    } else {
        include_once $file;
    }
}, [
    'helpers',
    'recommended-plugins',
    'class-bootstrap-navigation',
    'theme-customizations',
    'home-slider',
    'svg-support',
    'gravity-form-customizations',
    'custom-fields-search',
    'google-maps',
    'tiny-mce-customizations',
    'acf-placeholder',
    // 'woo-customizations',
    // 'shortcodes',
]);

// Register ACF Gravity Forms field
if (class_exists('theme\WlAcfGfField')) {
    // initialize
    new WlAcfGfField();
}

/** ========================================================================
 * Enqueue Scripts and Styles for Front-End.
 */

add_action('wp_enqueue_scripts', function () {
	if ( ! is_admin() ) {
		// Disable gutenberg built-in styles
		wp_dequeue_style( 'wp-block-library' );

		// Load Stylesheets
		//core
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', null, '4.3.1' );

		//system
		wp_enqueue_style( 'custom', get_template_directory_uri() . '/assets/css/custom.css', null, null );/*2rd priority*/
		wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', null, null );/*1st priority*/

		// Load JavaScripts
		//core
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'bootstrap.min', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', null, '4.3.1', true );

		//plugins
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/plugins/slick.min.js', null, '1.8.1', true );
		wp_enqueue_script( 'lazyload', 'https://cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/19.1.3/lazyload.min.js', null, '19.1.3', true );
		wp_enqueue_script( 'matchHeight', get_template_directory_uri() . '/assets/js/plugins/jquery.matchHeight-min.js', null, '0.7.2', true );
//		wp_enqueue_script( 'fancybox.v2', get_template_directory_uri() . '/assets/js/plugins/jquery.fancybox.v2.js', null, '2.1.5', true );
		wp_enqueue_script( 'fancybox.v3', get_template_directory_uri() . '/assets/js/plugins/jquery.fancybox.v3.js', null, '3.5.2', true );
//		wp_enqueue_script( 'jarallax', get_template_directory_uri() . '/assets/js/plugins/jarallax.min.js', null, '1.12.0', true );

		//custom javascript
		wp_enqueue_script( 'global', get_template_directory_uri() . '/assets/js/global.js', null, null, true ); /* This should go first */
	}
});

/** ========================================================================
 * Additional Functions.
 */

add_action('wp', function() {
    // Dynamic Admin
    if (class_exists('theme\DynamicAdmin') && is_admin()) {
         $dynamic_admin = new DynamicAdmin();
         //$dynamic_admin->addField( 'page', 'template', __('Page Template', 'bwp'), 'template_detail_field_for_page' );

        $dynamic_admin->run();
    }
});

// Apply lazyload to whole page content
if (class_exists('theme\CreateLazyImg')) {
    add_action('template_redirect', function () {
        ob_start(function ($html) {
            $lazy = new CreateLazyImg();
            $buffer = $lazy->ignoreScripts($html);
            $buffer = $lazy->ignoreNoscripts($buffer);
            $html = $lazy->lazyloadImages($html, $buffer);
            $html = $lazy->lazyloadPictures($html, $buffer);
            $html = $lazy->lazyloadBackgroundImages( $html, $buffer );

            return $html;
        });
    });
}

/** ========================================================================
 * PUT YOU FUNCTIONS BELOW.
 */

add_image_size( 'full_hd', 1920, 0, array( 'center', 'center' ) );
add_image_size( 'large_high', 1024, 0, false );
// add_image_size( 'name', width, height, array('center','center'));

// Disable gutenberg
add_filter('use_block_editor_for_post_type', '__return_false');

add_action('wp_ajax_filter_products', 'filter_products_callback');
add_action('wp_ajax_nopriv_filter_products', 'filter_products_callback');

function filter_products_callback() {
    if ( ! isset( $_POST['category'] ) ) {
        wp_die();
    }

    $category = $_POST['category'];

    $args = [
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'post_status'    => 'publish',
    ];

    if ($category !== 'all') {
        $args['tax_query'] = [
                [
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $category,
                ],
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="col-12 col-md-6 col-lg-3 product-item">
                <?php
                get_template_part( 'parts/product' );
                ?>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else : ?>
        <p class="text-center"><?php _e( 'No products found', 'default' ); ?></p>
    <?php endif;

    wp_die();
}

if ( ! function_exists( 'render_custom_buttons' ) ) {
    function render_custom_buttons( $buttons_data ) {
        if ( empty( $buttons_data ) || !is_array($buttons_data) ) {
            return;
        }

        foreach ( $buttons_data as $row ) {
            $link   = isset($row['products_flex_link']) ? $row['products_flex_link'] : null;
            $color  = isset($row['products_flex_color']) ? $row['products_flex_color'] : 'blue';

            if ( $link && is_array($link) ) {
                $url    = esc_url( $link['url'] );
                $title  = esc_html( $link['title'] );
                $target = ! empty( $link['target'] ) ? esc_attr( $link['target'] ) : '_self';

                echo '<a href="' . $url . '" target="' . $target . '" class="btn btn--' . esc_attr($color) . '">' . $title . '</a>';
            }
        }
    }
}

add_filter( 'tiny_mce_before_init', function( $settings ) {
    $style_formats = array(
            array(
                    'title' => 'Buttons',
                    'items' => array(
                            array(
                                    'title'    => 'Dark Blue Button',
                                    'selector' => 'a',
                                    'classes'  => 'btn btn--blue',
                            ),
                            array(
                                    'title'    => 'Teal Button',
                                    'selector' => 'a',
                                    'classes'  => 'btn btn--teal',
                            ),
                    ),
            ),
    );
    $settings['style_formats'] = json_encode( $style_formats );
    return $settings;
});


add_filter('post_type_link', function($post_link, $post) {
    if ($post->post_type === 'staff') {
        if (empty(trim(strip_tags($post->post_content)))) {
            return '#';
        }
    }
    return $post_link;
}, 10, 2);

add_shortcode('phone_link', function() {
    $phone = get_field('phone', 'options');
    if( !$phone ) return '';

    $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
    return '<a href="tel:' . $phone_clean . '" class="phone-link">' . $phone . '</a>';
});

function filter_search_results($query) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
        $query->set( 'post_type', array( 'post', 'product' ) );
    }
}
add_action( 'pre_get_posts', 'filter_search_results' );


function custom_list_menu_shortcode($atts) {
    $atts = shortcode_atts(array(
            'menu' => 'site-map',
    ), $atts);

    $menu_items = wp_get_nav_menu_items($atts['menu']);

    if (!$menu_items) {
        return '';
    }

    $output = '<ul class="site-map-list">';

    foreach ($menu_items as $item) {
        $title = $item->title;
        $url = $item->url;
        $description = $item->description;

        $output .= '<li>';
        $output .= '<a href="' . esc_url($url) . '">' . esc_html($title) . '</a>';

        if (!empty($description)) {
            $output .= ' - ' . esc_html($description);
        }

        $output .= '</li>';
    }

    $output .= '</ul>';

    return $output;
}

add_shortcode('listmenu', 'custom_list_menu_shortcode');