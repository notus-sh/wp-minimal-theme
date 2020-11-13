<?php
/**
 * Displays the menus and widgets at the end of the main element.
 * Visually, this output is presented as part of the footer element.
 *
 * @package    WordPress
 * @subpackage mt
 * @since      mt 1.0
 */

// Only output the container if there are elements to display.
if (!has_nav_menu('footer')) {
    return;
}

?>
<div class="footer-nav-widgets-wrapper header-footer-group">
    <div class="footer-inner section-inner">
        <div class="footer-top has-footer-menu">
            <nav aria-label="<?php esc_attr_e('Footer', 'mt'); ?>" role="navigation" class="footer-menu-wrapper">
                <ul class="footer-menu reset-list-style">
                    <?php wp_nav_menu([
                        'container' => '',
                        'depth' => 1,
                        'items_wrap' => '%3$s',
                        'theme_location' => 'footer',
                    ]); ?>
                </ul>
            </nav><!-- .site-nav -->
        </div><!-- .footer-top -->
    </div><!-- .footer-inner -->
</div><!-- .footer-nav-widgets-wrapper -->
