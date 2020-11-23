<?php

/**
 * Template to display search results
 */

use MT\Templates\Search;

?>

<?php get_header(); ?>

<main id="site-content" role="main">
    <header>
        <h1 class="archive-title"><?php echo wp_kses_post(Search::title()); ?></h1>
        <div class="archive-subtitle">
            <?php echo wp_kses_post(wpautop(Search::description())); ?>
        </div>
    </header>
    
    <?php if (have_posts()): ?>
    
        <?php
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/singular-as-list-item', get_post_type());
        }
        ?>
    
    <?php else: ?>

        <div class="no-search-results-form">
            <?php get_search_form(['label' => __('search again', 'mt')]); ?>
        </div>
        
    <?php endif; ?>
    
    <?php get_template_part('partials/layout/pagination'); ?>
</main>

<?php get_footer();
