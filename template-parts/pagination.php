<?php

/**
 * Output pagination
 */

$posts_pagination = get_the_posts_pagination([
    'mid_size' => 1,
    'prev_text' => sprintf(
        '%s <span class="nav-prev-text">%s</span>',
        '<span aria-hidden="true">&larr;</span>',
        __('Newer <span class="nav-short">Posts</span>', 'mt')
    ),
    'next_text' => sprintf(
        '<span class="nav-next-text">%s</span> %s',
        __('Older <span class="nav-short">Posts</span>', 'mt'),
        '<span aria-hidden="true">&rarr;</span>'
    )
]);

if (!$posts_pagination) {
    return;
}

?>

<div class="pagination-wrapper section-inner">
    <?php echo $posts_pagination; ?>
</div>
