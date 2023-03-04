<?php

namespace Src\Core\Http;

use Src\Core\Template;

class Response
{
    public static function show404()
    {
        self::setStatusCode(404);
        $template = new Template('error');
        return $template->render('error/_404');
    }

    private static function setStatusCode(int $code)
    {
        http_response_code($code);
    }
}
