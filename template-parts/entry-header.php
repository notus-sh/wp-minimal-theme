<?php

/**
 * Display post header
 */

?>

<header class="entry-header has-text-align-center<?php echo is_singular() ? esc_attr($entry_header_classes) : ''; ?>">
    <div class="entry-header-inner section-inner medium">
      
        <?php if (has_category()): ?>
            <div class="entry-categories">
                <span class="screen-reader-text"><?php _e('Categories', 'mt'); ?></span>
                <div class="entry-categories-inner"><?php the_category(' '); ?></div>
            </div>
        <?php endif; ?>
      
        <?php if (is_singular()): ?>
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        <?php else: ?>
            <?php the_title('<h2 class="entry-title heading-size-1"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
        <?php endif; ?>
      
        <?php if (has_excerpt() && is_singular()): ?>
            <div class="intro-text section-inner max-percentage">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
        
        <?php mt_the_post_meta(get_the_ID(), 'single-top'); ?>

    </div>
</header>
