<?php

/**
 * Template to display content
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    
    <?php
    
    get_template_part('template-parts/entry-header');
    if (!is_search()) {
        get_template_part('template-parts/featured-image');
    }
    ?>

    <div class="post-inner thin">
        <div class="entry-content">
            <?php
            if (is_search() || !is_singular()) {
                the_excerpt();
            } else {
                the_content(__('Continue reading', 'mt'));
            }
            ?>
        </div>
    </div>

    <div class="section-inner">
        <?php
        
        wp_link_pages([
            'before' => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__('Page', 'mt') . '"><span class="label">' . __('Pages:', 'mt') . '</span>',
            'after' => '</nav>',
            'link_before' => '<span class="page-number">',
            'link_after' => '</span>',
        ]);
        
        edit_post_link();
        
        // Single bottom post meta.
        mt_the_post_meta(get_the_ID(), 'single-bottom');
        
        if (post_type_supports(get_post_type(get_the_ID()), 'author') && is_single()) {
            get_template_part('template-parts/entry-author-bio');
        }
        ?>
    </div>
    
    <?php
    
    if (is_single()) {
        get_template_part('template-parts/navigation');
    }
    
    /**
     *  Output comments wrapper if it's a post, or if comments are open,
     * or if there's a comment number – and check for password.
     * */
    if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) {
        ?>

        <div class="comments-wrapper section-inner">
            <?php comments_template(); ?>
        </div>
        
        <?php
    }
    ?>

</article>
