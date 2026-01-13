<?php
namespace App\Controllers;

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
        // insertion réservation
        $this->redirect('/sportif/history');
    }
}
