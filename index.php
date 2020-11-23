<?php

/**
 * Main template
 */

?>

<?php get_header(); ?>

<main id="site-content" role="main">
    
    <?php if (have_posts()): ?>
        
        <?php
        while (have_posts()) {
            the_post();
            get_template_part('partials/singular-as-list-item', get_post_type());
        }
        ?>
    
    <?php endif; ?>
    
    <?php get_template_part('partials/layout/pagination'); ?>
</main>

<?php get_footer();
