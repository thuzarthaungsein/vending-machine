<?php

namespace App\Helpers;

class Response
{
    public static function json($data)
    {
        return json_encode($data);
    }
}
