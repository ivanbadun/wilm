<?php
$form_side = get_sub_field('form_side');
$section_class = ($form_side == 'right') ? 'form-map-section--reverse' : '';
?>

<section class="form-map-section <?php echo $section_class; ?>">
    <div class="map-col">
        <?php
        $map_type = get_sub_field('map_type');
        if ( $map_type == 'image' ) :
            $image = get_sub_field('map_image');
            $link = get_sub_field('image_link');
            if ( $image ) : ?>
                <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener" class="map-link">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="Map Location">
                </a>
            <?php endif;
        else :
            echo get_sub_field('map_embed');
        endif;
        ?>
    </div>

    <div class="container">
        <div class="row <?php echo ($form_side == 'right') ? 'justify-content-end' : ''; ?>">
            <div class="col-lg-6">
                <div class="career-details form-inner-content px-4">
                    <?php
                    $form_type = get_sub_field('form_type2');
                    $text = get_sub_field('text_before_form');
                    if ( $text ) echo $text;

                    if ( $form_type == 'gravity' ) :
                        $form_id = get_sub_field('gravity_form_select');
                        if ( $form_id ) :
                            $final_id = is_array($form_id) ? $form_id['id'] : $form_id;
                            echo do_shortcode('[gravityform id="' . $final_id . '" title="false" description="false" ajax="true"]');
                        endif;
                    elseif ( $form_type == 'd3' ) :
                        echo get_sub_field('d3_form_code');
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>