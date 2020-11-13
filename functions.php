<?php

use Composer\Autoload\ClassLoader;


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


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mt_theme_support()
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
    
    // Add support for full and wide align images.
    add_theme_support('align-wide');
    // Add support for responsive embeds.
    add_theme_support('responsive-embeds');
    
    /**
     * Configure Gutenberg
     */
    add_theme_support('editor-styles');
    
    // Colors
    add_theme_support('disable-custom-colors'); // No color pickers
    add_theme_support('disable-custom-gradients'); // No custom gradients
    add_theme_support('editor-color-palette', []); // No colors at all
    
    // Fonts
    add_theme_support('disable-custom-font-sizes'); // No custom font sizes
    add_theme_support('editor-font-sizes', []); // No font size control at all
}

add_action('after_setup_theme', 'mt_theme_support');


/**
 * Load theme translation files.
 */
function mt_load_textdomain() {
    load_theme_textdomain('mt', get_template_directory() . '/locales/');
}

add_action('after_setup_theme', 'mt_load_textdomain');


/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

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
 * Force comments number to be returned as int
 */
function mt_get_comments_number($count)
{
    return absint($count);
}

add_filter('get_comments_number', 'mt_get_comments_number');


/**
 * Return the comment section title
 */
function mt_get_comments_title()
{
    $nb_comments = get_comments_number();
    if (0 === $nb_comments) {
        return _e('Leave a comment', 'mt');
    }
    
    if (1 === $nb_comments) {
        return sprintf(_x('One reply on &ldquo;%s&rdquo;', 'comments title', 'mt'), get_the_title());
    }
    
    return sprintf(
        /* translators: 1: Number of comments, 2: Post title. */
        _nx('%1$s reply on &ldquo;%2$s&rdquo;', '%1$s replies on &ldquo;%2$s&rdquo;', $nb_comments, 'comments title', 'mt'),
        number_format_i18n($nb_comments),
        get_the_title()
    );
}

/**
 * Return comments pagination
 */
function mt_get_comments_pagination()
{
    return paginate_comments_links([
        'echo' => false,
        'end_size' => 0,
        'mid_size' => 0,
        'next_text' => __('Newer Comments', 'mt') . ' <span aria-hidden="true">&rarr;</span>',
        'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __('Older Comments', 'mt'),
    ]);
}

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
 * Return title for search result page
 */
function mt_get_search_title()
{
    return sprintf(
        '%1$s %2$s',
        '<span class="color-accent">' . __('Search:', 'mt') . '</span>',
        '&ldquo;' . get_search_query() . '&rdquo;'
    );
}


/**
 * Return description for search result page
 */
function mt_get_search_description()
{
    global $wp_query;
    
    if (!$wp_query->found_posts) {
        return __(
          'We could not find any results for your search. You can give it another try through the search form below.',
          'mt'
        );
    }
    
    return sprintf(
        /* translators: %s: Number of search results. */
        _n(
            'We found %s result for your search.',
            'We found %s results for your search.',
            $wp_query->found_posts,
            'mt'
        ),
        number_format_i18n($wp_query->found_posts)
    );
}
