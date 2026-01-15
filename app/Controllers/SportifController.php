<?php

namespace App\Controllers;

use App\Models\Coach;
use App\Models\Reservation;
use App\Models\Seance;
use Core\Controller;
use Core\Security;
use Core\Session;

class SportifController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Security::requireRole('sportif');
    }

    public function coaches()
    {
        $coachModel = new Coach();
        $coaches = $coachModel->all();

        $this->render('sportif/coaches', [
            'coaches' => $coaches
        ]);
    }

    public function seances()
    {
        $seanceModel = new Seance();
        $seances = $seanceModel->all();

        $this->render('sportif/seances', [
            'seances' => $seances
        ]);
    }

    public function history()
    {
        $sportifId = Session::get('user')['id'];

        $reservationModel = new Reservation();
        $reservations = $reservationModel->bySportif($sportifId);

        $this->render('sportif/history', [
            'reservations' => $reservations
        ]);
    }
}
