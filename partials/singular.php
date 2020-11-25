<?php

/**
 * Display a singular item (page, post or custom post type)
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
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

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
    
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
    
    <?php if (comments_open() || get_comments_number()): ?>
        <div class="comments-wrapper">
            <?php comments_template(); ?>
        </div>
    <?php endif; ?>
</article>
