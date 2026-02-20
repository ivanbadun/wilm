<?php
/**
 * Template Name: Employment
 */
get_header();
?>

<?php if ( have_rows( 'flex_part' ) ) : ?>
    <?php while ( have_rows( 'flex_part' ) ): the_row(); ?>
        <?php get_template_part( 'parts/flexible/flexible', get_row_layout() ); ?>
    <?php endwhile; ?>
<?php endif; ?>


<?php get_footer(); ?>