<?php
$no_padding = get_sub_field('remove_padding');
$section_class = 'flex-50-50-text';
if ($no_padding) {
    $section_class .= ' flex-50-50-text--no-padding';
}
?>

<section class="<?php echo $section_class; ?>">
    <div class="container">

        <?php if( $title = get_sub_field('title') ): ?>
            <div class="flex-50-50-text__header">
                <h2 class="flex-50-50-text__title"><?php echo esc_html($title); ?></h2>
            </div>
        <?php endif; ?>

        <div class="flex-50-50-text__grid">
            <div class="flex-50-50-text__col">
                <?php echo get_sub_field('left_column_content'); ?>
            </div>

            <div class="flex-50-50-text__col">
                <?php echo get_sub_field('right_column_content'); ?>
            </div>
        </div>

    </div>
</section>