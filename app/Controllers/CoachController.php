<?php
namespace App\Controllers;

use App\Models\Coach;
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
    $user = $_SESSION['user'];

    $coachModel = new Coach;
    $coach = $coachModel->findByUser($user['id']);

    $this->render('coach/profile', [
        'coach' => $coach
    ]);
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
