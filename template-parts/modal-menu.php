<?php

/**
 * Displays the menu icon and modal
 *
 * @package    WordPress
 * @subpackage mt
 * @since      mt 1.0
 */

if (!has_nav_menu('expanded')) {
  return;
}

?>

<div class="menu-modal cover-modal header-footer-group" data-modal-target-string=".menu-modal">
    <div class="menu-modal-inner modal-inner">
        <div class="menu-wrapper section-inner">
            <div class="menu-top">
        
                <button class="toggle close-nav-toggle fill-children-current-color"
                        data-toggle-target=".menu-modal"
                        data-toggle-body-class="showing-menu-modal"
                        data-set-focus=".menu-modal"
                        aria-expanded="false">
                    <span class="toggle-text"><?php _e('Close Menu', 'mt'); ?></span>⨯
                </button><!-- .nav-toggle -->

                <nav class="expanded-menu" aria-label="<?php esc_attr_e('Expanded', 'mt'); ?>" role="navigation">
                    <ul class="modal-menu reset-list-style">
                        <?php wp_nav_menu([
                            'container' => '',
                            'items_wrap' => '%3$s',
                            'show_toggles' => true,
                            'theme_location' => 'expanded',
                        ]); ?>
                    </ul>
                </nav>

            </div><!-- .menu-top -->
        </div><!-- .menu-wrapper -->
    </div><!-- .menu-modal-inner -->
</div><!-- .menu-modal -->
