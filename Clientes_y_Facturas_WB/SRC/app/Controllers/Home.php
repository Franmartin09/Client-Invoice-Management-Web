<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {   
        header("Location: /login");
        exit;
    }
}
