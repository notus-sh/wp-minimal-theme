<?php

/**
 * Template to display 404 pages
 */

?>

<?php get_header(); ?>

<main id="site-content" role="main">
    <div class="section-inner thin error404-content">
        <h1 class="entry-title"><?php _e('Page Not Found', 'mt'); ?></h1>
        <div class="intro-text">
          <p><?php _e('The page you were looking for could not be found. It might have been removed, renamed, or did not exist in the first place.', 'mt'); ?></p>
        </div>
        
        <?php get_search_form(['label' => __('404 not found', 'mt')]); ?>
    </div>
</main>

<?php get_footer();
