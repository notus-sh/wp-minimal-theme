<?php

use Composer\Autoload\ClassLoader;
use MT\Templates\Comments;
use MT\Theme;

$autoload_ns = 'MT\\';
$autoload_dir = __DIR__ . '/src/';

try {
    $loader = new ClassLoader();
    $loader->addPsr4($autoload_ns , $autoload_dir);
    $loader->register();
    
} catch (Exception $e) {
    
    // Composer is not available, fallback to a custom SPL autoloader.
    spl_autoload_register(function ($class) use ($autoload_ns, $autoload_dir) {
        $ns_length = strlen($autoload_ns);
        if (strncmp($autoload_ns, $class, $ns_length) !== 0) {
            return;
        }
        
        $class_in_ns = substr($class, $ns_length);
        $file_in_dir = $autoload_dir . str_replace('\\', '/', $class_in_ns) . '.php';
        
        if (false === $realpath = realpath($file_in_dir)) {
            return;
        }
    
        require $realpath;
    });
    
}

Theme::setup();
Comments::setup();

/**
 * Register and Enqueue Styles.
 */
function mt_register_styles()
{
    $theme_version = wp_get_theme()->get('Version');
    
    wp_enqueue_style('mt-style', get_stylesheet_uri(), array(), $theme_version);
    wp_style_add_data('mt-style', 'rtl', 'replace');
    
    // Add print CSS.
    wp_enqueue_style('mt-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print');
}

add_action('wp_enqueue_scripts', 'mt_register_styles');


/**
 * Register and Enqueue Scripts.
 */
function mt_register_scripts()
{
    $theme_version = wp_get_theme()->get('Version');
    
    if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    wp_enqueue_script('mt-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false);
    wp_script_add_data('mt-js', 'async', true);
}

add_action('wp_enqueue_scripts', 'mt_register_scripts');


/**
 * Register navigation menus
 */
function mt_menus()
{
    register_nav_menus([
        'primary' => __('Main Menu', 'mt'),
        'footer' => __('Footer Menu', 'mt'),
    ]);
}

add_action('init', 'mt_menus');


/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function mt_skip_link()
{
    echo '<a class="skip-link screen-reader-text" href="#site-content">' . __('Skip to the content', 'mt') . '</a>';
}

add_action('wp_body_open', 'mt_skip_link', 5);


/**
 * Enqueue supplemental block editor styles.
 */
function mt_block_editor_styles()
{
    // Enqueue the editor styles.
    wp_enqueue_style(
      'mt-block-editor-styles',
      get_theme_file_uri('/assets/css/editor-style-block.css'),
      array(),
      wp_get_theme()->get('Version'),
      'all'
    );
    wp_style_add_data('mt-block-editor-styles', 'rtl', 'replace');
    
    // Enqueue the editor script.
    wp_enqueue_script(
      'mt-block-editor-script',
      get_theme_file_uri('/assets/js/editor-script-block.js'),
      array('wp-blocks', 'wp-dom'),
      wp_get_theme()->get('Version'),
      true
    );
}

add_action('enqueue_block_editor_assets', 'mt_block_editor_styles', 1, 1);


/**
 * Enqueue classic editor styles.
 */
function mt_classic_editor_styles()
{
    $classic_editor_styles = array(
      '/assets/css/editor-style-classic.css',
    );
    
    add_editor_style($classic_editor_styles);
}

add_action('init', 'mt_classic_editor_styles');


/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 * @return string
 */
function mt_read_more_tag($html)
{
    return preg_replace(
      '/<a(.*)>(.*)<\/a>/iU',
      sprintf(
        '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>',
        get_the_title(get_the_ID())
      ),
      $html
    );
}

add_filter('the_content_more_link', 'mt_read_more_tag');

/**
 * Return copyright mention for footer
 */
function mt_get_copyright()
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

/**
 * Table of Contents:
 * Post Meta
 * Menus
 * Classes
 * Archives
 * Miscellaneous
 */

/**
 * Post Meta
 */

/**
 * Retrieves and displays the post meta.
 *
 * If it's a single post, outputs the post meta values specified in the Customizer settings.
 *
 * @param int    $post_id  The ID of the post for which the post meta should be output.
 * @param string $location Which post meta location to output – single or preview.
 */
function mt_the_post_meta($post_id = null, $location = 'single-top')
{
    echo mt_get_post_meta(
      $post_id,
      $location
    ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in mt_get_post_meta().
    
}

/**
 * Filters the edit post link to add an icon and use the post meta structure.
 *
 * @param string $link    Anchor tag for the edit link.
 * @param int    $post_id Post ID.
 * @param string $text    Anchor text.
 */
function mt_edit_post_link($link, $post_id, $text)
{
    if (is_admin()) {
        return $link;
    }
    
    $edit_url = get_edit_post_link($post_id);
    
    if (!$edit_url) {
        return;
    }
    
    $text = sprintf(
      wp_kses(
      /* translators: %s: Post title. Only visible to screen readers. */
        __('Edit <span class="screen-reader-text">%s</span>', 'mt'),
        array(
          'span' => array(
            'class' => array(),
          ),
        )
      ),
      get_the_title($post_id)
    );
    
    return '<div class="post-meta-wrapper post-meta-edit-link-wrapper"><ul class="post-meta"><li class="post-edit meta-wrapper"><span class="meta-icon">🖉</span><span class="meta-text"><a href="' . esc_url($edit_url) . '">' . $text . '</a></span></li></ul><!-- .post-meta --></div><!-- .post-meta-wrapper -->';
}

add_filter('edit_post_link', 'mt_edit_post_link', 10, 3);

/**
 * Retrieves the post meta.
 *
 * @param int    $post_id  The ID of the post.
 * @param string $location The location where the meta is shown.
 */
function mt_get_post_meta($post_id = null, $location = 'single-top')
{
    // Require post ID.
    if (!$post_id) {
        return;
    }
    
    /**
     * Filters post types array.
     *
     * This filter can be used to hide post meta information of post, page or custom post type
     * registered by child themes or plugins.
     *
     * @param array Array of post types
     * @since mt 1.0
     *
     */
    $disallowed_post_types = apply_filters('mt_disallowed_post_types_for_meta_output', array('page'));
    
    // Check whether the post type is allowed to output post meta.
    if (in_array(get_post_type($post_id), $disallowed_post_types, true)) {
        return;
    }
    
    $post_meta_wrapper_classes = '';
    $post_meta_classes = '';
    
    // Get the post meta settings for the location specified.
    if ('single-top' === $location) {
        /**
         * Filters post meta info visibility.
         *
         * Use this filter to hide post meta information like Author, Post date, Comments, Is sticky status.
         *
         * @param array $args {
         * @type string 'author'
         * @type string 'post-date'
         * @type string 'comments'
         * @type string 'sticky'
         *                    }
         * @since mt 1.0
         *
         */
        $post_meta = apply_filters(
          'mt_post_meta_location_single_top',
          array(
            'author',
            'post-date',
            'comments',
            'sticky',
          )
        );
        
        $post_meta_wrapper_classes = ' post-meta-single post-meta-single-top';
    } elseif ('single-bottom' === $location) {
        /**
         * Filters post tags visibility.
         *
         * Use this filter to hide post tags.
         *
         * @param array $args {
         * @type string 'tags'
         *                    }
         * @since mt 1.0
         *
         */
        $post_meta = apply_filters(
          'mt_post_meta_location_single_bottom',
          array(
            'tags',
          )
        );
        
        $post_meta_wrapper_classes = ' post-meta-single post-meta-single-bottom';
    }
    
    // If the post meta setting has the value 'empty', it's explicitly empty and the default post meta shouldn't be output.
    if ($post_meta && !in_array('empty', $post_meta, true)) {
        // Make sure we don't output an empty container.
        $has_meta = false;
        
        global $post;
        $the_post = get_post($post_id);
        setup_postdata($the_post);
        
        ob_start();
        
        ?>
        
        <div class="post-meta-wrapper<?php
        echo esc_attr($post_meta_wrapper_classes); ?>">
            
            <ul class="post-meta<?php
            echo esc_attr($post_meta_classes); ?>">
                
                <?php
                
                /**
                 * Fires before post meta HTML display.
                 *
                 * Allow output of additional post meta info to be added by child themes and plugins.
                 *
                 * @param int    $post_id   Post ID.
                 * @param array  $post_meta An array of post meta information.
                 * @param string $location  The location where the meta is shown.
                 *                          Accepts 'single-top' or 'single-bottom'.
                 * @since mt 1.1 Added the `$post_meta` and `$location` parameters.
                 *
                 * @since mt 1.0
                 */
                do_action('mt_start_of_post_meta_list', $post_id, $post_meta, $location);
                
                // Author.
                if (post_type_supports(get_post_type($post_id), 'author') && in_array('author', $post_meta, true)) {
                    $has_meta = true;
                    ?>
                    <li class="post-author meta-wrapper">
						<span class="meta-icon">
							<span class="screen-reader-text"><?php _e('Post author', 'mt'); ?></span>
							
						</span>
                        <span class="meta-text">
							<?php
                            printf(
                            /* translators: %s: Author name. */
                              __('By %s', 'mt'),
                              '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(
                                get_the_author_meta('display_name')
                              ) . '</a>'
                            );
                            ?>
						</span>
                    </li>
                    <?php
                }
                
                // Post date.
                if (in_array('post-date', $post_meta, true)) {
                    $has_meta = true;
                    ?>
                    <li class="post-date meta-wrapper">
                <span class="meta-icon">
                  <span class="screen-reader-text"><?php _e('Post date', 'mt'); ?></span>
                  📅
                </span>
                        <span class="meta-text">
                  <a href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
                </span>
                    </li>
                    <?php
                }
                
                // Categories.
                if (in_array('categories', $post_meta, true) && has_category()) {
                    $has_meta = true;
                    ?>
                    <li class="post-categories meta-wrapper">
                <span class="meta-icon">
                  <span class="screen-reader-text"><?php _e('Categories', 'mt'); ?></span>
                  📂
                </span>
                        <span class="meta-text">
                  <?php _ex('In', 'A string that is output before one or more categories', 'mt'); ?><?php the_category(', '); ?>
                </span>
                    </li>
                    <?php
                }
                
                // Tags.
                if (in_array('tags', $post_meta, true) && has_tag()) {
                    $has_meta = true;
                    ?>
                    <li class="post-tags meta-wrapper">
                <span class="meta-icon">
                  <span class="screen-reader-text"><?php _e('Tags', 'mt'); ?></span>
                  🔖
                </span>
                        <span class="meta-text">
                  <?php the_tags('', ', ', ''); ?>
                </span>
                    </li>
                    <?php
                }
                
                // Comments link.
                if (in_array('comments', $post_meta, true) && !post_password_required() && (comments_open(
                    ) || get_comments_number())) {
                    $has_meta = true;
                    ?>
                    <li class="post-comment-link meta-wrapper">
                        <span class="meta-icon">🗪</span>
                        <span class="meta-text"><?php comments_popup_link(); ?></span>
                    </li>
                    <?php
                }
                
                // Sticky.
                if (in_array('sticky', $post_meta, true) && is_sticky()) {
                    $has_meta = true;
                    ?>
                    <li class="post-sticky meta-wrapper">
                        <span class="meta-icon">⭐ </span>
                        <span class="meta-text"><?php _e('Sticky post', 'mt'); ?> </span>
                    </li>
                    <?php
                }
                
                /**
                 * Fires after post meta HTML display.
                 *
                 * Allow output of additional post meta info to be added by child themes and plugins.
                 *
                 * @param int    $post_id   Post ID.
                 * @param array  $post_meta An array of post meta information.
                 * @param string $location  The location where the meta is shown.
                 *                          Accepts 'single-top' or 'single-bottom'.
                 * @since mt 1.1 Added the `$post_meta` and `$location` parameters.
                 *
                 * @since mt 1.0
                 */
                do_action('mt_end_of_post_meta_list', $post_id, $post_meta, $location);
                
                ?>
            
            </ul><!-- .post-meta -->
        
        </div><!-- .post-meta-wrapper -->
        
        <?php
        
        wp_reset_postdata();
        
        $meta_output = ob_get_clean();
        
        // If there is meta to output, return it.
        if ($has_meta && $meta_output) {
            return $meta_output;
        }
    }
}

/**
 * Menus
 */

/**
 * Filters classes of wp_list_pages items to match menu items.
 *
 * Filter the class applied to wp_list_pages() items with children to match the menu class, to simplify.
 * styling of sub levels in the fallback. Only applied if the match_menu_classes argument is set.
 *
 * @param string[] $css_class    An array of CSS classes to be applied to each list item.
 * @param WP_Post  $page         Page data object.
 * @param int      $depth        Depth of page, used for padding.
 * @param array    $args         An array of arguments.
 * @param int      $current_page ID of the current page.
 * @return array CSS class names.
 */
function mt_filter_wp_list_pages_item_classes($css_class, $page, $depth, $args, $current_page)
{
    // Only apply to wp_list_pages() calls with match_menu_classes set to true.
    $match_menu_classes = isset($args['match_menu_classes']);
    
    if (!$match_menu_classes) {
        return $css_class;
    }
    
    // Add current menu item class.
    if (in_array('current_page_item', $css_class, true)) {
        $css_class[] = 'current-menu-item';
    }
    
    // Add menu item has children class.
    if (in_array('page_item_has_children', $css_class, true)) {
        $css_class[] = 'menu-item-has-children';
    }
    
    return $css_class;
}

add_filter('page_css_class', 'mt_filter_wp_list_pages_item_classes', 10, 5);

/**
 * Adds a Sub Nav Toggle to the Expanded Menu and Mobile Menu.
 *
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param WP_Post  $item  Menu item data object.
 * @param int      $depth Depth of menu item. Used for padding.
 * @return stdClass An object of wp_nav_menu() arguments.
 */
function mt_add_sub_toggles_to_main_menu($args, $item, $depth)
{
    // Add sub menu toggles to the Expanded Menu with toggles.
    if (isset($args->show_toggles) && $args->show_toggles) {
        // Wrap the menu item link contents in a div, used for positioning.
        $args->before = '<div class="ancestor-wrapper">';
        $args->after = '';
        
        // Add a toggle to items with children.
        if (in_array('menu-item-has-children', $item->classes, true)) {
            $toggle_target_string = '.menu-modal .menu-item-' . $item->ID . ' > .sub-menu';
            $toggle_duration = mt_toggle_duration();
            
            // Add the sub menu toggle.
            $args->after .= '<button class="toggle sub-menu-toggle fill-children-current-color" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="' . absint(
                $toggle_duration
              ) . '" aria-expanded="false"><span class="screen-reader-text">' . __(
                'Show sub menu',
                'mt'
              ) . '</span>⌄</button>';
        }
        
        // Close the wrapper.
        $args->after .= '</div><!-- .ancestor-wrapper -->';
        // Add sub menu icons to the primary menu without toggles.
    } elseif ('primary' === $args->theme_location) {
        if (in_array('menu-item-has-children', $item->classes, true)) {
            $args->after = '<span class="icon"></span>';
        } else {
            $args->after = '';
        }
    }
    
    return $args;
}

add_filter('nav_menu_item_args', 'mt_add_sub_toggles_to_main_menu', 10, 3);

/**
 * Classes
 */

/**
 * Adds 'no-js' class.
 *
 * If we're missing JavaScript support, the HTML element will have a 'no-js' class.
 */
function mt_no_js_class()
{
    ?>
    <script>document.documentElement.className = document.documentElement.className.replace('no-js', 'js');</script>
    <?php
}

add_action('wp_head', 'mt_no_js_class');

/**
 * Adds conditional body classes.
 *
 * @param array $classes Classes added to the body tag.
 * @return array Classes added to the body tag.
 */
function mt_body_classes($classes)
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

add_filter('body_class', 'mt_body_classes');

/**
 * Archives
 */

/**
 * Filters the archive title and styles the word before the first colon.
 *
 * @param string $title Current archive title.
 * @return string Current archive title.
 */
function mt_get_the_archive_title($title)
{
    $regex = apply_filters(
      'mt_get_the_archive_title_regex',
      array(
        'pattern' => '/(\A[^\:]+\:)/',
        'replacement' => '<span class="color-accent">$1</span>',
      )
    );
    
    if (empty($regex)) {
        return $title;
    }
    
    return preg_replace($regex['pattern'], $regex['replacement'], $title);
}

add_filter('get_the_archive_title', 'mt_get_the_archive_title');

/**
 * Miscellaneous
 */

/**
 * Toggles animation duration in milliseconds.
 *
 * @return int Duration in milliseconds
 */
function mt_toggle_duration()
{
    /**
     * Filters the animation duration/speed used usually for submenu toggles.
     *
     * @param int $duration Duration in milliseconds.
     * @since mt 1.0
     *
     */
    $duration = apply_filters('mt_toggle_duration', 250);
    
    return $duration;
}
