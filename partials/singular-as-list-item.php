<?php

/**
 * Display a singular item (page, post or custom post type) in a list
 */

$class = has_post_thumbnail() ? 'header-cover' : '';
$style = has_post_thumbnail() ? sprintf("background-image: url(%s);", get_the_post_thumbnail_url()) : '';

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <header
        <?php echo !empty($class) ? sprintf('class="%s"', $class) : ''; ?>
        <?php echo !empty($style) ? sprintf('style="%s"', $style) : ''; ?>
        >
        <div class="entry-header">
            <?php the_title('<h2 class="entry-title heading-size-1"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
  
            <div class="entry-meta">
                <?php the_time(get_option('date_format')); ?>
                <?php get_template_part('partials/singular/categories'); ?>
                <?php get_template_part('partials/singular/tags'); ?>
                <?php get_template_part('partials/singular/comments-count'); ?>
            </div>
        </div>
    </header>
    
    <?php if (has_excerpt()): ?>
        <div class="entry-intro">
            <?php the_excerpt(); ?>
        </div>
    <?php endif; ?>
</article>

