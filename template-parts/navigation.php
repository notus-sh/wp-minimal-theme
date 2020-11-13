<?php

/**
 * Displays the next and previous post navigation in single posts
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if (!$next_post || !$prev_post) {
    return;
}

?>

<nav class="pagination-single section-inner" aria-label="<?php esc_attr_e('Post', 'mt'); ?>" role="navigation">
    <div class="pagination-single-inner">
        
        <?php if ($prev_post): ?>
            <a class="previous-post" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                <span class="arrow" aria-hidden="true">&larr;</span>
                <span class="title">
                    <span class="title-inner"><?php echo wp_kses_post(get_the_title($prev_post->ID)); ?></span>
                </span>
            </a>
        <?php endif; ?>

        <?php if ($next_post): ?>
            <a class="next-post" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
                <span class="arrow" aria-hidden="true">&rarr;</span>
                <span class="title">
                    <span class="title-inner"><?php echo wp_kses_post(get_the_title($next_post->ID)); ?></span>
                </span>
            </a>
        <?php endif; ?>
      
    </div>
</nav>
