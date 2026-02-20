<?php get_header(); ?>

<main class="staff-detail-page">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article class="staff-detail">

                <div class="staff-left">
                    <?php if(has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('full'); ?>
                    <?php endif; ?>
                </div>

                <div class="staff-right">
                    <h1 class="career-title mb-0"><?php the_title(); ?></h1>

                    <?php if($job_title = get_field('job_title')): ?>
                        <div class="job-role"><?php echo esc_html($job_title); ?></div>
                    <?php endif; ?>

                    <div class="career-details">
                        <?php the_content(); ?>
                    </div>

                    <a href="javascript:history.back()" class="back-link">← Back to Team</a>
                </div>

            </article>

        <?php endwhile; endif; ?>
    </div>
</main>

<?php get_footer(); ?>