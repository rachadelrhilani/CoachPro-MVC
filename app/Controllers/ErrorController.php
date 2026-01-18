<?php

namespace App\Controllers;

use Core\Controller;

class ErrorController extends Controller
{
    public function notFound()
    {
        $this->render('errors/404');
    }
}
