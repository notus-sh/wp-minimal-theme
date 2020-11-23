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
    }
    
    /**
     * Enqueue supplemental block editor styles.
     */
    public static function block()
    {
        // Enqueue the editor styles.
        wp_enqueue_style(
            'mt-block-editor-styles',
            get_theme_file_uri('/dist/stylesheets/blocks-editor.css'),
            array(),
            Theme::getVersion(),
            'all'
        );
        //wp_style_add_data('mt-block-editor-styles', 'rtl', 'replace');
    }
    
    /**
     * Enqueue classic editor styles.
     */
    public static function classic()
    {
        add_editor_style(['/dist/stylesheets/classic-editor.css']);
    }
}
