<?php

namespace App\Controllers;

use App\Models\Coach;
use Core\Controller;
use Core\Security;
use Core\Session;

class CoachController extends Controller
{
    public function __construct()
    {
        parent::__construct();

    }


    public function profile()
    {
        Security::requireRole('coach');
        $user = $_SESSION['user'];

        $coachModel = new Coach;
        $coach = $coachModel->findByUser($user['id']);

        $this->render('coach/profile', [
            'coach' => $coach
        ]);
    }

    public function coaches()
    {
        $coachModel = new Coach();
        $coaches = $coachModel->all();

        $this->render('sportif/coaches', [
            'coaches' => $coaches
        ]);
    }
    
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/coach/profile');
        }
           Security::requireRole('coach');
        $coachModel = new Coach();

        $coachModel->update(
            Session::get('user')['id'],
            $_POST
        );

        $this->redirect('/coach/profile');
    }
}
