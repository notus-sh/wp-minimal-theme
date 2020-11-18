<?php

namespace MT;

abstract class Theme
{
    public static function setup()
    {
        add_action('after_setup_theme', [self::class, 'support']);
        add_action('after_setup_theme', [self::class, 'loadTextDomain']);
    }
    
    public static function getVersion(): string
    {
        return wp_get_theme()->get('Version');
    }
    
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * @hook after_theme_setup
     * Note: This function is hooked into the after_setup_theme hook as the init hook
     * is too late for some features, such as indicating support for post thumbnails.
     */
    public static function support()
    {
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');
    
        // Set content-width.
        global $content_width;
        if (!isset($content_width)) {
            $content_width = 580;
        }
    
        // Enable support for Post Thumbnails on every post types.
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 9999); // Set post thumbnail size.
    
        // Let WordPress manage the document title.
        add_theme_support('title-tag');
    
        // Switch to HTML5 markup for search form, comment form, and comments.
        add_theme_support('html5', [
          'search-form',
          'comment-form',
          'comment-list',
          'gallery',
          'caption',
          'script',
          'style',
        ]);
    }
    
    public static function loadTextDomain() {
        load_theme_textdomain('mt', get_template_directory() . '/locales/');
    }
}
