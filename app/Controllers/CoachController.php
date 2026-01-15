<?php

namespace App\Controllers;

use App\Models\Coach;
use App\Models\Seance;
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

        $coachModel = new Coach();
        $coach = $coachModel->findByUser($user['id']);

        $seanceModel = new Seance();
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
    public function deleteSeance($id)
{
    $seanceModel = new Seance();

    if ($seanceModel->isReserved($id)) {
        die('Impossible de supprimer une séance réservée');
    }

    $seanceModel->delete($id);
    $this->redirect('/coach/seances');
}

}
