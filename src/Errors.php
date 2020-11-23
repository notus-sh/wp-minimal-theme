<?php

namespace MT;

abstract class Errors
{
    public static function notFound()
    {
        status_header(404);
        require get_404_template();
        exit;
    }
}
