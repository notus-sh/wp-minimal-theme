<?php
/**
 * Header file for the mt WordPress default theme.
 *
 * @link       https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    WordPress
 * @subpackage mt
 * @since      mt 1.0
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
  
    <header id="site-header" class="header-footer-group" role="banner">
        <div class="header-inner section-inner">
            <div class="header-titles-wrapper">
              
                <button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal"
                        data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field"
                        aria-expanded="false">
                    <span class="toggle-inner">
                        <span class="toggle-icon"><?php mt_the_theme_svg('search'); ?></span>
                        <span class="toggle-text"><?php _e('Search', 'mt'); ?></span>
                    </span>
                </button><!-- .search-toggle -->
    
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
          
                    <?php
                    // Site description.
                    mt_site_description();
                    ?>
                </div><!-- .header-titles -->
    
                <button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"
                      data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
                    <span class="toggle-inner">
                        <span class="toggle-icon"><?php mt_the_theme_svg('ellipsis'); ?></span>
                        <span class="toggle-text"><?php _e('Menu', 'mt'); ?></span>
                    </span>
                </button><!-- .nav-toggle -->
            
            </div><!-- .header-titles-wrapper -->
    
            <div class="header-navigation-wrapper">
            
                <?php if (has_nav_menu('primary') || !has_nav_menu('expanded')): ?>
                <nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e('Horizontal', 'mt'); ?>" role="navigation">
                    <ul class="primary-menu reset-list-style">
                        <?php
                        if (has_nav_menu('primary')) {
                            wp_nav_menu(
                              array(
                                'container' => '',
                                'items_wrap' => '%3$s',
                                'theme_location' => 'primary',
                              )
                            );
                        } elseif (!has_nav_menu('expanded')) {
                            wp_list_pages(
                              array(
                                'match_menu_classes' => true,
                                'show_sub_menu_icons' => true,
                                'title_li' => false,
                                'walker' => new Mt_Walker_Page(),
                              )
                            );
                        }
                        ?>
                    </ul>
                </nav><!-- .primary-menu-wrapper -->
                <?php endif; ?>
    
                <div class="header-toggles hide-no-js">
                  
                    <?php if (has_nav_menu('expanded')): ?>
                    <div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu">
                        <button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal"
                                data-toggle-body-class="showing-menu-modal" aria-expanded="false"
                                data-set-focus=".close-nav-toggle">
                            <span class="toggle-inner">
                                <span class="toggle-text"><?php _e('Menu', 'mt'); ?></span>
                                <span class="toggle-icon"><?php mt_the_theme_svg('ellipsis'); ?></span>
                            </span>
                        </button><!-- .nav-toggle -->
                    </div><!-- .nav-toggle-wrapper -->
                    <?php endif; ?>
    
                    <div class="toggle-wrapper search-toggle-wrapper">
                        <button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal"
                              data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field"
                              aria-expanded="false">
                            <span class="toggle-inner">
                              <?php mt_the_theme_svg('search'); ?>
                              <span class="toggle-text"><?php _e('Search', 'mt'); ?></span>
                            </span>
                        </button><!-- .search-toggle -->
                    </div>
              
                </div><!-- .header-toggles -->
            </div><!-- .header-navigation-wrapper -->
        </div><!-- .header-inner -->
        
        <?php get_template_part('template-parts/modal-search'); ?>
    
    </header><!-- #site-header -->
    
    <?php
    // Output the menu modal.
    get_template_part('template-parts/modal-menu');
