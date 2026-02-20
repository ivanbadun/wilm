<?php
$job_title_from_url = isset($_GET['job-title']) ? esc_html($_GET['job-title']) : '';
?>

<section class="content-form-section my-5">
    <div class="container form-full">
        <div class="container text-center">
            <?php if ( $job_title_from_url ) : ?>
                <h1 class="career-title"><?php echo $job_title_from_url; ?></h1>
            <?php endif; ?>
        </div>
        <p class="text-center career-details"><?php _e( 'Please fill out the form below to submit your employment application.', 'default' ); ?></p>

        <?php
        $form_type = get_sub_field('form_type');

        if ( $form_type == 'gravity' ) :
            $gravity_form_data = get_sub_field('gravity_form_select');
            $form_id = is_array($gravity_form_data) ? $gravity_form_data['id'] : $gravity_form_data;

            if ( $form_id ) :
                echo do_shortcode('[gravityform id="' . $form_id . '" title="false" description="false" ajax="true" field_values="job_title=' . urlencode($job_title_from_url) . '"]');
            endif;

        elseif ( $form_type == 'd3' ) :
            echo get_sub_field('d3_form_code');
        endif;
        ?>
    </div>
</section>