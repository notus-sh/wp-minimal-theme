<?php

namespace MT\Templates;

abstract class Comments
{
    public static function setup()
    {
        add_filter('get_comments_number', [self::class, 'count']);
    }
    
    public static function title()
    {
        $nb_comments = get_comments_number();
        if (0 === $nb_comments) {
            return _e('Leave a comment', 'mt');
        }
    
        if (1 === $nb_comments) {
            return sprintf(_x('One reply on &ldquo;%s&rdquo;', 'comments title', 'mt'), get_the_title());
        }
    
        return sprintf(
            /* translators: 1: Number of comments, 2: Post title. */
            _nx('%1$s reply on &ldquo;%2$s&rdquo;', '%1$s replies on &ldquo;%2$s&rdquo;', $nb_comments, 'comments title', 'mt'),
            number_format_i18n($nb_comments),
            get_the_title()
        );
    }
    
    public static function pagination()
    {
        return paginate_comments_links([
            'echo' => false,
            'end_size' => 0,
            'mid_size' => 0,
            'next_text' => __('Newer Comments', 'mt') . ' <span aria-hidden="true">&rarr;</span>',
            'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __('Older Comments', 'mt'),
        ]);
    }
    
    /**
     * @hook get_comments_number
     */
    public static function count($count)
    {
        return absint($count);
    }
}
