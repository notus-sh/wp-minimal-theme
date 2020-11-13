<?php

/**
 * Template to display comments and comment form
 */

use MT\Walkers\Comments;

if (post_password_required()) {
    return;
}

?>

<?php if ($comments): ?>
    <div class="comments" id="comments">
        <div class="comments-header section-inner small max-percentage">
            <h2 class="comment-reply-title"><?php echo mt_get_comments_title(); ?></h2>
        </div>

        <div class="comments-inner section-inner thin max-percentage">
        
            <?php wp_list_comments([
                'walker' => new Comments(),
                'avatar_size' => 120,
                'style' => 'div',
            ]); ?>
          
            <?php if ('' !== $pagination = mt_get_comments_pagination()): ?>
            <nav class="comments-pagination pagination" aria-label="<?php esc_attr_e('Comments', 'mt'); ?>">
                <?php echo wp_kses_post($pagination); ?>
            </nav>
            <?php endif; ?>

        </div><!-- .comments-inner -->
    </div><!-- comments -->
<?php endif; ?>

<?php if (comments_open() || pings_open()): ?>

    <?php comment_form([
        'class_form' => 'section-inner thin max-percentage',
        'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h2>',
    ]); ?>
    
<?php elseif (is_single()): ?>
    
    <div class="comment-respond" id="respond">
        <p class="comments-closed"><?php _e('Comments are closed.', 'mt'); ?></p>
    </div><!-- #respond -->

<?php endif; ?>
