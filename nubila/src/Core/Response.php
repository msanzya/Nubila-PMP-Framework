<?php

namespace Nubila\Core;

class Response
{
    public static function json($data)
    {
        header('Content-Type: application/json');
        return json_encode($data);
    }
}