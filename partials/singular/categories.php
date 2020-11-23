<?php

/**
 * Display categories
 */

if (!has_category()) {
    return;
}

?>

<div class="entry-categories">
    <span class="screen-reader-text"><?php _e('Categories', 'mt'); ?></span>
    <div class="entry-categories-inner"><?php the_category(' '); ?></div>
</div>
