<?php
/**
 * Footer
 */
?>
<!-- BEGIN of footer -->
<footer class="footer">
    <div class="footer__grid container">
        <div class="footer__contacts">
            <?php
            $address = get_field('address', 'option');
            $phone = get_field('phone', 'option');
            $work_time = get_field('work_time', 'option');
            $name = get_field('name_company', 'option');

            if ($address || $phone || $work_time || $name) {
                echo '<p class="footer__title">' . __( 'Contact Us', 'default' ) . '</p>';
            }
            if ($name) echo '<p>' . $name . '</p>';
            if ($address) echo '<p>' . $address . '</p>';
            if ($work_time) echo '<p>' . $work_time . '</p>';
            if ($phone) {
                echo '<a href="tel:' . $phone . '"><i class="fa fa-phone" aria-hidden="true"></i> ' . $phone . '</a>';
            }
            ?>
        </div>

        <div class="footer__nav">
            <?php
            if ( has_nav_menu( 'footer-menu' ) ) {
                wp_nav_menu( array(
                        'theme_location' => 'footer-menu',
                        'menu_class' => 'footer-menu',
                        'depth' => 1
                ) );
            }
            ?>
        </div>

        <div class="footer__brand">
            <div class="footer__logo">
                <?php if ( $footer_logo = get_field( 'footer_logo', 'options' ) ):
                    echo wp_get_attachment_image( $footer_logo['id'], 'medium' );
                else:
                    show_custom_logo();
                endif; ?>
            </div>

            <?php if ( $copyright = get_field( 'copyright', 'options' ) ): ?>
                <div class="footer__copy-text">
                    <?php echo $copyright; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</footer>
<!-- END of footer -->

<button id="back-to-top"><span class="arrow"></span></button>

<?php wp_footer(); ?>
<?php if ( $ada_script = get_field( 'ada', 'options' ) ) : ?>
    <?php echo $ada_script; ?>
<?php endif; ?>
</body>
</html>
