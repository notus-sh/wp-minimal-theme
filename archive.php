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
    
    <header>
        <h1 class="archive-title"><?php echo wp_kses_post(get_the_archive_title()); ?></h1>
        <div class="archive-subtitle">
            <?php echo wp_kses_post(wpautop(get_the_archive_description())); ?>
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
