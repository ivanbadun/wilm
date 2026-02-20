<section class="content-form-section my-5">
    <div class="container">
        <?php if( $title = get_sub_field('title') ): ?>
            <div class="section-title text-center mb-4">
                <h2><?php echo esc_html($title); ?></h2>
            </div>
        <?php endif; ?>

        <?php if( $text = get_sub_field('content') ): ?>
            <div class="career-details text-center mb-4">
                <?php echo $text; ?>
            </div>
        <?php endif; ?>

        <div class="form-contact-container">
            <?php
            $form_type = get_sub_field('form_type3');

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
</section>
