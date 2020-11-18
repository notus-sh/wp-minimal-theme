<?php

namespace MT;

abstract class Editors
{
    public static function setup()
    {
        add_action('after_setup_theme', [self::class, 'support']);
        
        add_action('enqueue_block_editor_assets', [self::class, 'block'], 1, 1);
        add_action('init', [self::class, 'classic']);
    }
    
    /**
     * Configure Guttenberg theme support
     *
     * @hook after_theme_setup
     * Note: This function is hooked into the after_setup_theme hook as the init hook
     * is too late for some features, such as indicating support for post thumbnails.
     */
    public static function support()
    {
        // Add support for full and wide align images.
        add_theme_support('align-wide');
        // Add support for responsive embeds.
        add_theme_support('responsive-embeds');
        
        // Load WordPress default styles for blocks
        add_theme_support('editor-styles');
        
        // Colors
        add_theme_support('disable-custom-colors'); // No color pickers
        add_theme_support('disable-custom-gradients'); // No custom gradients
        add_theme_support('editor-color-palette', []); // No colors at all
        add_theme_support('editor-gradient-presets', []); // No gradients at all
        
        // Fonts
        add_theme_support('disable-custom-font-sizes'); // No custom font sizes
        add_theme_support('editor-font-sizes', []); // No font size control at all
        
        // No fonts, line heights or spacings unit
        add_theme_support('custom-units', [] );
    
        // No default compositions
        remove_theme_support('core-block-patterns');
    }
    
    /**
     * Enqueue supplemental block editor styles.
     */
    public static function block()
    {
        // Enqueue the editor styles.
        wp_enqueue_style(
            'mt-block-editor-styles',
            get_theme_file_uri('/assets/css/editor-style-block.css'),
            array(),
            Theme::getVersion(),
            'all'
        );
        wp_style_add_data('mt-block-editor-styles', 'rtl', 'replace');
        
        // Enqueue the editor script.
        wp_enqueue_script(
            'mt-block-editor-script',
            get_theme_file_uri('/assets/js/editor-script-block.js'),
            array('wp-blocks', 'wp-dom'),
            Theme::getVersion(),
            true
        );
    }
    
    /**
     * Enqueue classic editor styles.
     */
    public static function classic()
    {
        add_editor_style(['/assets/css/editor-style-classic.css']);
    }
}
