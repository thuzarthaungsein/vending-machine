<?php

namespace App\Controllers;

class BaseController
{
    public function view($viewName, $data = [])
    {
        extract($data);
        require_once __DIR__ . "/../Views/$viewName.php";
    }
}
