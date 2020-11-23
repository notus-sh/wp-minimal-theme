<?php

namespace MT\Templates;

use MT\Theme;

abstract class Layout
{
    public static function setup()
    {
        add_action('init', [self::class, 'registerMenus']);
        
        add_action('wp_enqueue_scripts', [self::class, 'registerStyles']);
        add_action('wp_enqueue_scripts', [self::class, 'registerScripts']);
        
        add_action('wp_head', [self::class, 'noJSClass']);
        add_filter('body_class', [self::class, 'bodyClass']);
        add_action('wp_body_open', [self::class, 'skipLink'], 5);
    }
    
    /**
     * Register menus
     */
    public static function registerMenus()
    {
        register_nav_menus([
            'primary' => __('Main Menu', 'mt'),
            'footer' => __('Footer Menu', 'mt'),
        ]);
    }
    
    /**
     * Register and enqueue Styles.
     */
    public static function registerStyles(): void
    {
        wp_enqueue_style('mt-style', get_stylesheet_uri(), array(), Theme::getVersion());
        wp_style_add_data('mt-style', 'rtl', 'replace');
        
        // Add print CSS.
        wp_enqueue_style('mt-print-style', get_template_directory_uri() . '/print.css', null, Theme::getVersion(), 'print');
    }
    
    /**
     * Register and enqueue Scripts.
     */
    public static function registerScripts(): void
    {
        if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
        
        wp_enqueue_script('mt-js', get_template_directory_uri() . '/assets/js/index.js', array(), Theme::getVersion(), false);
        wp_script_add_data('mt-js', 'async', true);
    }
    
    /**
     * Adds 'no-js' class.
     * If we're missing JavaScript support, the HTML element will have a 'no-js' class.
     */
    public static function noJSClass()
    {
        echo sprintf('<script>%1$s = %1$s.replace("no-js", "js");</script>', 'document.documentElement.className');
    }
    
    /**
     * Adds conditional body classes.
     *
     * @param array $classes Classes added to the body tag.
     * @return array Classes added to the body tag.
     */
    public static function bodyClass(array $classes): array
    {
        global $post;
        
        $post_type = isset($post) ? $post->post_type : false;
    
        // Check whether we're singular.
        if (is_singular()) {
            $classes[] = 'singular';
        }
    
        // Check for post thumbnail.
        if (is_singular() && has_post_thumbnail()) {
            $classes[] = 'has-post-thumbnail';
        } elseif (is_singular()) {
            $classes[] = 'missing-post-thumbnail';
        }
    
        // Check whether we're in the customizer preview.
        if (is_customize_preview()) {
            $classes[] = 'customizer-preview';
        }
    
        // Check if posts have single pagination.
        if (is_single() && (get_next_post() || get_previous_post())) {
            $classes[] = 'has-single-pagination';
        } else {
            $classes[] = 'has-no-pagination';
        }
    
        // Check if we're showing comments.
        if ($post && (('post' === $post_type || comments_open() || get_comments_number()) && !post_password_required())) {
            $classes[] = 'showing-comments';
        } else {
            $classes[] = 'not-showing-comments';
        }
    
        // Check if avatars are visible.
        $classes[] = get_option('show_avatars') ? 'show-avatars' : 'hide-avatars';
    
        // Slim page template class names (class = name - file suffix).
        if (is_page_template()) {
            $classes[] = basename(get_page_template_slug(), '.php');
        }
    
        // Add a class indicating whether top part of the footer elements are output.
        if (has_nav_menu('footer')) {
            $classes[] = 'footer-top-visible';
        } else {
            $classes[] = 'footer-top-hidden';
        }
    
        return $classes;
    }
    
    /**
     * Generate a skip to content link
     * Will be displayed at the top of pages so that users can bypass the menu.
     */
    public static function skipLink()
    {
        echo sprintf(
            '<a class="skip-link screen-reader-text" href="#site-content">%s</a>',
            __('Skip to the content', 'mt')
        );
    }
    
    /**
     * Return copyright mention for footer
     */
    public static function copyright()
    {
        return sprintf(
            '&copy; %1$s <a href="%2$s">%3$s</a>',
            date_i18n(
                /* translators: Copyright date format, see https://www.php.net/date */
                _x('Y', 'copyright date format', 'mt')
            ),
            esc_url(home_url('/')),
            get_bloginfo('name', 'display')
        );
    }
}
