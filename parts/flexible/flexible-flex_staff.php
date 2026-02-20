<section class="staff-module">
    <div class="container">
        <?php if( $m_title = get_sub_field('staff_flex_title') ): ?>
            <h2><?php echo esc_html($m_title); ?></h2>
        <?php endif; ?>

        <?php if( have_rows('staff_flex_sections') ): ?>
            <?php while( have_rows('staff_flex_sections') ): the_row(); ?>
                <div class="staff-group">
                    <h3><?php the_sub_field('staff_flex_label'); ?></h3>

                    <div class="staff-grid">
                        <?php
                        $staff_members = get_sub_field('select_staff');
                        if( $staff_members ):
                            foreach( $staff_members as $post ): setup_postdata($post);
                                $content = get_the_content();
                                $has_bio = !empty(trim($content));
                                $job_title = get_field('job_title');
                                ?>

                                <div class="staff-card">
                                    <?php if( $has_bio ): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php endif; ?>

                                        <?php if(has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail('medium'); ?>
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="No image">
                                        <?php endif; ?>

                                        <h4><?php the_title(); ?></h4>

                                        <?php if($job_title): ?>
                                            <p class="staff-title"><?php echo esc_html($job_title); ?></p>
                                        <?php endif; ?>

                                        <?php if( $has_bio ): ?>
                                    </a>
                                <?php endif; ?>
                                </div>

                            <?php endforeach;
                            wp_reset_postdata();
                        endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>