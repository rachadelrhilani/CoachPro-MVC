<?php
namespace App\Controllers;
use App\Models\Coach;
use App\Models\Seance;
use Core\Controller;
use Core\Security;
use Core\Session;

class SeanceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function available()
    {
        $this->render('sportif/seances');
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
public function seancesport()
    {
        $seanceModel = new Seance();
        $seances = $seanceModel->all();

        $this->render('sportif/seances', [
            'seances' => $seances
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
    public function editSeance($id)
{
    $user = $_SESSION['user'];
    $coach = (new Coach())->findByUser($user['id']);

    $seanceModel = new Seance();
    $seance = $seanceModel->find((int)$id);

    if (!$seance) {
        $this->redirect('/coach/seances');
    }


    if ($seance['id_coach'] != $coach['id_coach']) {
        $this->redirect('/coach/seances');
    }

    $this->render('coach/edit_seance', [
        'seance' => $seance
    ]);
}

public function updateSeance($id)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('/coach/seances');
    }

    $user = $_SESSION['user'];
    $coach = (new Coach())->findByUser($user['id']);

    $seanceModel = new Seance();
    $seance = $seanceModel->find((int)$id);

    // ❌ séance inexistante
    if (!$seance) {
        $this->redirect('/coach/seances');
    }

    // 🔐 sécurité
    if ($seance['id_coach'] != $coach['id_coach']) {
        $this->redirect('/coach/seances');
    }

    $seanceModel->update((int)$id, [
        'date_seance' => $_POST['date_seance'],
        'heure'       => $_POST['heure'],
        'duree'       => $_POST['duree']
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
}
