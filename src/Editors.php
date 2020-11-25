<?php

namespace MT;

abstract class Editors
{
    public static function setup()
    {
        add_action('after_setup_theme', [self::class, 'support']);
        add_action('after_setup_theme', [self::class, 'styles']);
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
     * Enqueue editors stylesheet
     */
    public static function styles()
    {
        add_editor_style(['/dist/stylesheets/editors.css']);
    }
}
