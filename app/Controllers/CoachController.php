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
        $user = $_SESSION['user'];

        $coachModel = new \App\Models\Coach();
        $coach = $coachModel->findByUser($user['id']);

        $seanceModel = new \App\Models\Seance();
        $seances = $seanceModel->byCoach($coach['id_coach']);

        $this->render('coach/seances', [
            'seances' => $seances
        ]);
    }


    public function reservations()
{
    $user = $_SESSION['user'];

    $coachModel = new Coach;
    $coach = $coachModel->findByUser($user['id']);

    $reservationModel = new \App\Models\Reservation();
    $reservations = $reservationModel->byCoach($coach['id_coach']);

    $this->render('coach/reservations', [
        'reservations' => $reservations
    ]);
}

}
