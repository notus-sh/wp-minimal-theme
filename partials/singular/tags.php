<?php

/**
 * Display tags
 */

if (!has_tag()) {
    return;
}

?>

<div class="entry-tags">
    <span class="screen-reader-text"><?php _e('Tags', 'mt'); ?></span>
    <div class="entry-tags-inner"><?php the_tags('', ', ', ''); ?></div>
</div>
