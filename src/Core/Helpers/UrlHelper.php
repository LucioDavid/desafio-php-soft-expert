<?php

function appUrl(string $uri = null)
{
    if ($uri === null || $uri === '/') {
        return $_ENV['APP_URL'];
    }

    return "{$_ENV['APP_URL']}/{$uri}";
}

function redirect(string $uri)
{
    $url = appUrl($uri);
    header('Refresh:0;url=' . $url);
    exit;
}
