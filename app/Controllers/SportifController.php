<?php

namespace App\Controllers;

use App\Models\Coach;
use Core\Controller;
use Core\Security;

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
        $this->render('sportif/seances');
    }

    public function history()
    {
        $this->render('sportif/history');
    }
}
