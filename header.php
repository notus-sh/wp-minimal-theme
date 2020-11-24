<?php

/**
 * Template to display the header
 */

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>
  
    <header id="site-header" role="banner">
    
        <div class="header-titles">
            <a class="site-title" href="<?php echo esc_url(get_home_url(null, '/')) ?>">
                <?php echo esc_html(get_bloginfo('name')); ?>
            </a>
  
            <?php if ($description = get_bloginfo('description')): ?>
                <p class="site-description"><?php echo $description; ?></p>
            <?php endif; ?>
        </div>

        <div class="header-controls">
            <nav aria-label="<?php esc_attr_e('Main menu', 'mt'); ?>" role="navigation">
                <ul class="primary-menu">
                    <?php if (has_nav_menu('primary')): ?>
                        <?php wp_nav_menu([
                            'container' => '',
                            'items_wrap' => '%3$s',
                            'theme_location' => 'primary',
                        ]); ?>
                    <?php else: ?>
                        <?php wp_list_pages(['title_li' => false]); ?>
                    <?php endif; ?>
                </ul>
            </nav>
        
            <?php get_search_form(['label' => __('Search for:', 'mt')]); ?>
        </div>
    </header>
