<?php

use Core\Controller;

class SeanceController extends Controller
{
    public function available()
    {
        $this->render('sportif/seances');
    }
}
