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
            get_template_part('template-parts/content', get_post_type());
        }
        ?>
    
    <?php endif; ?>
    
    <?php get_template_part('template-parts/pagination'); ?>
</main>

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php get_footer();
