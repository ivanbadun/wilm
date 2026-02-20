<section class="careers-section">
    <div class="container">
        <?php
        $careers = get_sub_field('careers_on_page');
        if( $careers ): ?>
            <div class="careers-list">
                <?php foreach( $careers as $post ): setup_postdata($post); ?>
                    <div class="career-item my-4">
                        <h3 class="career-title"><?php the_title(); ?></h3>

                        <div class="career-details mb-4">
                            <?php the_content(); ?>
                        </div>

                        <?php
                        $employment_page_url = home_url('/employment/');
                        $job_url = add_query_arg('job-title', urlencode(get_the_title()), $employment_page_url);
                        ?>

                        <a href="<?php echo esc_url($job_url); ?>" class="btn btn--teal">
                            <?php _e( 'Submit Resume', 'default' ); ?>
                        </a>
                    </div>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>