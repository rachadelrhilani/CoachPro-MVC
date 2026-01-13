<?php
namespace App\Controllers;

use Core\Controller;
use Core\Security;

class CoachController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Security::requireRole('coach');
    }

    public function profile()
    {
        $this->render('coach/profile');
    }

    public function seances()
    {
        $this->render('coach/seances');
    }

    public function reservations()
    {
        $this->render('coach/reservations');
    }
}
