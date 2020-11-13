<?php

/**
 * Template to display the header
 */

use MT\Walkers\Pages;

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
  
    <header id="site-header" class="header-footer-group" role="banner">
        <div class="header-inner section-inner">
            <div class="header-titles-wrapper">
              
                <button class="toggle search-toggle mobile-search-toggle"
                        data-toggle-target=".search-modal"
                        data-toggle-body-class="showing-search-modal"
                        data-set-focus=".search-modal .search-field"
                        aria-expanded="false">
                    <span class="toggle-inner">
                        <span class="toggle-icon">🔎</span>
                        <span class="toggle-text"><?php _e('Search', 'mt'); ?></span>
                    </span>
                </button>
    
                <div class="header-titles">
                    <?php if ((is_front_page() || is_home()) && !is_page()): ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(get_home_url(null, '/')) ?>">
                                <?php echo esc_html(get_bloginfo('name')); ?>
                            </a>
                        </h1>
                    <?php else: ?>
                        <div class="site-title faux-heading">
                            <a href="<?php echo esc_url(get_home_url(null, '/')) ?>">
                                <?php echo esc_html(get_bloginfo('name')); ?>
                            </a>
                        </div>
                    <?php endif; ?>
          
                    <?php if ($description = get_bloginfo('description')): ?>
                        <div class="site-description"><?php echo $description; ?></div>
                    <?php endif; ?>
                </div>
            </div>
    
            <div class="header-navigation-wrapper">
                <nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e('Main menu', 'mt'); ?>" role="navigation">
                    <ul class="primary-menu reset-list-style">
                        <?php if (has_nav_menu('primary')): ?>
                            <?php wp_nav_menu([
                                'container' => '',
                                'items_wrap' => '%3$s',
                                'theme_location' => 'primary',
                            ]); ?>
                        <?php else: ?>
                            <?php wp_list_pages([
                                'match_menu_classes' => true,
                                'show_sub_menu_icons' => true,
                                'title_li' => false,
                                'walker' => new Pages(),
                            ]); ?>
                        <?php endif; ?>
                    </ul>
                </nav>
    
                <div class="header-toggles hide-no-js">
                    <div class="toggle-wrapper search-toggle-wrapper">
                        <button class="toggle search-toggle desktop-search-toggle"
                                data-toggle-target=".search-modal"
                                data-toggle-body-class="showing-search-modal"
                                data-set-focus=".search-modal .search-field"
                                aria-expanded="false">
                            <span class="toggle-inner">
                                🔎 <span class="toggle-text"><?php _e('Search', 'mt'); ?></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <?php get_template_part('template-parts/modal-search'); ?>
    
    </header>
