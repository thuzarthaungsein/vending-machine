<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $this->view('/admin/dashboard');
    }
}
