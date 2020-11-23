<?php

/**
 * Template to display archives
 */

use MT\Errors;

if (!have_posts()) {
    Errors::notFound();
}

?>

<?php get_header(); ?>

<main id="site-content" role="main">
    
    <header class="archive-header has-text-align-center header-footer-group">
        <div class="archive-header-inner section-inner medium">
            <h1 class="archive-title">
                <?php echo wp_kses_post(get_the_archive_title()); ?>
            </h1>
          
            <div class="archive-subtitle section-inner thin max-percentage intro-text">
                <?php echo wp_kses_post(wpautop(get_the_archive_description())); ?>
            </div>
        </div>
    </header>
    
    <?php
    while (have_posts()) {
        the_post();
        get_template_part('partials/singular-as-list-item', get_post_type());
    }
    ?>
    
    <?php get_template_part('partials/layout/pagination'); ?>
</main>

<?php get_footer();
