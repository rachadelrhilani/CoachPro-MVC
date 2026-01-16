<?php

namespace App\Controllers;

use App\Models\Coach;
use App\Models\Reservation;
use App\Models\Seance;
use App\Models\Sportif;
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
    public function profile()
    {
        Security::requireRole('sportif');
        $user = Session::get('user');

        $sportifModel = new Sportif();
        $sportif = $sportifModel->findByUser($user['id']);

        $this->render('sportif/profile', [
            'sportif' => $sportif
        ]);
    }


    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/sportif/profile');
        }

        $user = Session::get('user');

        $sportifModel = new Sportif();
        $sportifModel->update($user['id'], [
            'nom'     => $_POST['nom'],
            'prenom'  => $_POST['prenom'],
            'email'   => $_POST['email']
        ]);

        Session::flash('success', 'Profil mis à jour avec succès');
        $this->redirect('/sportif/profile');
    }

}
