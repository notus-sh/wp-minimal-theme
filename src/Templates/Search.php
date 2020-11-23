<?php

namespace MT\Templates;

abstract class Search
{
    public static function setup()
    {
    }
    
    /**
     * Return title for search result pages
     */
    public static function title(): string
    {
        return sprintf('%1$s %2$s', __('Search:', 'mt'), '&ldquo;' . get_search_query() . '&rdquo;');
    }
    
    /**
     * Return description for search result pages
     */
    public static function description(): string
    {
        global $wp_query;
    
        if (!$wp_query->found_posts) {
            return __(
                'We could not find any results for your search. You can give it another try through the search form below.',
                'mt'
            );
        }
    
        return sprintf(
            /* translators: %s: Number of search results. */
            _n(
                'We found %s result for your search.',
                'We found %s results for your search.',
                $wp_query->found_posts,
                'mt'
            ),
            number_format_i18n($wp_query->found_posts)
        );
    }
}
