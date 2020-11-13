<?php
/**
 * Displays the menus and widgets at the end of the main element.
 * Visually, this output is presented as part of the footer element.
 *
 * @package    WordPress
 * @subpackage mt
 * @since      mt 1.0
 */

$has_footer_menu = has_nav_menu('footer');

$has_sidebar_1 = is_active_sidebar('sidebar-1');

// Only output the container if there are elements to display.
if (!($has_footer_menu || $has_sidebar_1)) {
    return;
}

?>
<div class="footer-nav-widgets-wrapper header-footer-group">
    <div class="footer-inner section-inner">
        
        <?php if ($has_footer_menu): ?>
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
        <?php endif; ?>
        
        <?php if ($has_sidebar_1): ?>
            <aside class="footer-widgets-outer-wrapper" role="complementary">
                <div class="footer-widgets-wrapper">
                  
                    <?php if ($has_sidebar_1): ?>
                        <div class="footer-widgets column-one grid-item">
                            <?php dynamic_sidebar('sidebar-1'); ?>
                        </div>
                    <?php endif; ?>
  
                </div><!-- .footer-widgets-wrapper -->
            </aside><!-- .footer-widgets-outer-wrapper -->
        <?php endif; ?>
      
    </div><!-- .footer-inner -->
</div><!-- .footer-nav-widgets-wrapper -->
