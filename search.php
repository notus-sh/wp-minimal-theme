<?php

/**
 * Template to display search results
 */

?>

<?php get_header(); ?>

<main id="site-content" role="main">
    <header class="archive-header has-text-align-center header-footer-group">
        <div class="archive-header-inner section-inner medium">
            <h1 class="archive-title">
                <?php echo wp_kses_post(mt_get_search_title()); ?>
            </h1>
          
            <div class="archive-subtitle section-inner thin max-percentage intro-text">
                <?php echo wp_kses_post(wpautop(mt_get_search_description())); ?>
            </div>
        </div>
    </header>
    
    <?php if (have_posts()): ?>
    
        <?php
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', get_post_type());
        }
        ?>
    
    <?php else: ?>

        <div class="no-search-results-form section-inner thin">
            <?php get_search_form(['label' => __('search again', 'mt')]); ?>
        </div>
        
    <?php endif; ?>
    
    <?php get_template_part('template-parts/pagination'); ?>
</main>

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php get_footer();
