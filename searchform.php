<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link       https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package    WordPress
 * @subpackage mt
 * @since      mt 1.0
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$mt_unique_id = wp_unique_id('search-form-');
?>
<form class="search-form" role="search" method="get"
      action="<?php echo esc_url(home_url('/')); ?>"
      <?php echo !empty($args['label']) ? 'aria-label="' . esc_attr($args['label']) . '"' : ''; ?>>
  
    <label for="<?php echo esc_attr($mt_unique_id); ?>">
        <span class="screen-reader-text"><?php _e('Search for:', 'mt'); ?></span>
        <input type="search" name="s" class="search-field"
               id="<?php echo esc_attr($mt_unique_id); ?>"
               placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'mt'); ?>"
               value="<?php echo get_search_query(); ?>" />
    </label>
    
    <input type="submit" class="search-submit"
           value="<?php echo esc_attr_x('Search', 'submit button', 'mt'); ?>" />
</form>
