<?php

/**
 * Display tags
 */

if (!has_tag()) {
    return;
}

?>

<p>
    <span class="screen-reader-text"><?php _e('Tags', 'mt'); ?></span>
    <?php the_tags('', ', ', ''); ?>
</p>
