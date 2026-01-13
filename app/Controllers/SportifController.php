<?php
namespace App\Controllers;

use Core\Controller;
use Core\Security;

class SportifController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Security::requireRole('sportif');
    }

    public function coaches()
    {
        $this->render('sportif/coaches');
    }

    public function seances()
    {
        $this->render('sportif/seances');
    }

    public function history()
    {
        $this->render('sportif/history');
    }
}
