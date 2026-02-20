<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>

<!--HOME PAGE SLIDER-->
<?php if (shortcode_exists('slider')) {
    echo do_shortcode('[slider]');
} ?>
<!--END of HOME PAGE SLIDER-->

<?php if ( have_rows( 'flex_part' ) ) : ?>
    <?php while ( have_rows( 'flex_part' ) ): the_row(); ?>
        <?php get_template_part( 'parts/flexible/flexible', get_row_layout() ); ?>
    <?php endwhile; ?>
<?php endif; ?>
	
<!-- BEGIN of main content -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- END of main content -->

<?php get_footer(); ?>
