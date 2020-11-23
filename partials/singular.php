<?php

/**
 * Display a singular item (page, post or custom post type)
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <header>
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    
        <?php if (has_excerpt()): ?>
          <div class="entry-intro">
              <?php the_excerpt(); ?>
          </div>
        <?php endif; ?>
    
        <?php the_time(get_option('date_format')); ?>
        <?php get_template_part('partials/singular/categories'); ?>
        <?php get_template_part('partials/singular/tags'); ?>
        <?php get_template_part('partials/singular/comments-count'); ?>
    </header>
    
    <?php if (has_post_thumbnail()): ?>
        <figure class="featured-media">
            <div class="featured-media-inner">
                <?php the_post_thumbnail(); ?>
                <?php if ('' !== $caption = get_the_post_thumbnail_caption()): ?>
                    <figcaption><?php echo wp_kses_post($caption); ?></figcaption>
                <?php endif; ?>
            </div>
        </figure>
    <?php endif; ?>
    
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
    
    <?php if (comments_open() || get_comments_number()): ?>
        <div class="comments-wrapper">
            <?php comments_template(); ?>
        </div>
    <?php endif; ?>
</article>
