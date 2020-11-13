<?php

/**
 * Display featured image
 */

if (!(has_post_thumbnail() && !post_password_required())) {
    return;
}

?>
<figure class="featured-media">
    <div class="featured-media-inner section-inner">
        <?php the_post_thumbnail(); ?>
      
        <?php if ('' !== $caption = get_the_post_thumbnail_caption()): ?>
            <figcaption class="wp-caption-text">
                <?php echo wp_kses_post($caption); ?>
            </figcaption>
        <?php endif; ?>

    </div>
</figure>
