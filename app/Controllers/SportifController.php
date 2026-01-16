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


}
