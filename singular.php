<?php

/**
 * Template to display single posts and pages.
 */

?>

<?php get_header(); ?>

<main id="site-content" role="main">
    
    <?php if (have_posts()): ?>
        
        <?php
        while (have_posts()) {
            the_post();
            get_template_part('partials/singular', get_post_type());
        }
        ?>
    
    <?php endif; ?>

</main>

<?php get_footer(); ?>
