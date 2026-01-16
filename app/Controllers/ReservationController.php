<?php

namespace App\Controllers;

use App\Models\Coach;
use App\Models\Reservation;
use Core\Controller;
use Core\Security;
use Core\Session;

class ReservationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create($id)
    {
        $this->render('reservation/create', [
            'id_seance' => $id
        ]);
    }
    public function store()
    {
        Security::requireRole('sportif');

        $idSeance = (int) $_POST['id_seance'];
        $idSportif = $_SESSION['user']['id'];

        $reservation = new Reservation();

        if ($reservation->exists($idSeance)) {
            header('Location: ' . BASE_URL . '/sportif/seances');
            exit;
        }

        $reservation->create($idSeance, $idSportif);

        header('Location: ' . BASE_URL . '/sportif/history');
        exit;
    }
    public function history()
    {
        Security::requireRole('sportif');
        $sportifId = Session::get('user')['id'];

        $reservationModel = new Reservation();
        $reservations = $reservationModel->bySportif($sportifId);

        $this->render('sportif/history', [
            'reservations' => $reservations
        ]);
    }
    public function reservations()
    {
        Security::requireRole('coach');
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
