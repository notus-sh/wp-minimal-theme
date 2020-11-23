<?php

/**
 * Displays footer menu
 */

if (!has_nav_menu('footer')) {
    return;
}

?>
<nav aria-label="<?php esc_attr_e('Footer', 'mt'); ?>" role="navigation">
    <ul class="footer-menu">
        <?php wp_nav_menu([
            'container' => '',
            'depth' => 1,
            'items_wrap' => '%3$s',
            'theme_location' => 'footer',
        ]); ?>
    </ul>
</nav>
