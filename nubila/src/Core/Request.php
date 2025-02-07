<?php

namespace Nubila\Core;

class Request
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getPath()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = '/nubila/public'; // Adjust this to match your project's base URL
        return substr($path, strlen($basePath));
    }
}