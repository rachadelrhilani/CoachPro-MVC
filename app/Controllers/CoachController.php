<?php

namespace App\Controllers;

use App\Models\Coach;
use App\Models\Seance;
use Core\Controller;
use Core\Security;
use Core\Session;

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
    $user = Session::get('user');

    $coach = (new Coach())->findByUser($user['id']);

    $seanceModel = new Seance();

    $seances = $seanceModel->byCoach($coach['id_coach']);
    $stats   = $seanceModel->statsByCoach($coach['id_coach']);

    $this->render('coach/seances', [
        'seances' => $seances,
        'stats'   => $stats
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
    public function createSeance()
    {
        $user = $_SESSION['user'];

        $coach = (new Coach())->findByUser($user['id']);

        (new Seance())->create([
            'date_seance' => $_POST['date_seance'],
            'heure'       => $_POST['heure'],
            'duree'       => $_POST['duree'],
            'id_coach'    => $coach['id_coach']
        ]);

        $this->redirect('/coach/seances');
    }
    public function deleteSeance()
    {
        Security::requireRole('coach');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/coach/seances');
            exit;
        }

        $idSeance = (int) $_POST['id_seance'];

        $seanceModel = new Seance();

        if ($seanceModel->isReserved($idSeance)) {
            $_SESSION['error'] = "Impossible de supprimer une séance réservée";
            header('Location: ' . BASE_URL . '/coach/seances');
            exit;
        }

        $seanceModel->delete($idSeance);

        header('Location: ' . BASE_URL . '/coach/seances');
        exit;
    }
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/coach/profile');
        }

        $coachModel = new Coach();

        $coachModel->update(
            Session::get('user')['id'],
            $_POST
        );

        $this->redirect('/coach/profile');
    }
}
