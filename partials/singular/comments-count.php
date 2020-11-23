<?php

/**
 * Display comments count
 */

if (!(comments_open() || get_comments_number())) {
    return;
}

?>

<p><?php comments_popup_link(); ?></p>
