<?php

namespace App\Controllers;

use App\Models\Reservation;
use Core\Controller;
use Core\Security;

class ReservationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Security::requireRole('sportif');
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
}
