<?php
/**
 * mt Custom CSS
 *
 * @package    WordPress
 * @subpackage mt
 * @since      mt 1.0
 */

if (!function_exists('mt_generate_css')) {
    /**
     * Generate CSS.
     *
     * @param string $selector The CSS selector.
     * @param string $style    The CSS style.
     * @param string $value    The CSS value.
     * @param string $prefix   The CSS prefix.
     * @param string $suffix   The CSS suffix.
     * @param bool   $echo     Echo the styles.
     */
    function mt_generate_css($selector, $style, $value, $prefix = '', $suffix = '', $echo = true)
    {
        $return = '';
        
        /*
         * Bail early if we have no $selector elements or properties and $value.
         */
        if (!$value || !$selector) {
            return;
        }
        
        $return = sprintf('%s { %s: %s; }', $selector, $style, $prefix . $value . $suffix);
        
        if ($echo) {
            echo $return; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- We need to double check this, but for now, we want to pass PHPCS ;)
            
        }
        
        return $return;
    }
}
