<?php

/**
 * Display categories
 */

if (!has_category()) {
    return;
}

?>

<p class="entry-categories">
    <span class="screen-reader-text"><?php _e('Categories', 'mt'); ?></span>
    <?php the_category(' '); ?>
</p>
