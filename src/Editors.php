<?php

namespace MT;

abstract class Editors
{
    public static function setup()
    {
        add_action('enqueue_block_editor_assets', [self::class, 'block'], 1, 1);
        add_action('init', [self::class, 'classic']);
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
