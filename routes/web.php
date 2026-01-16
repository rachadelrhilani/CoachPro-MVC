<?php

use App\Controllers\CoachController;
use App\Controllers\ReservationController;
use App\Controllers\SportifController;
use Core\Router;

Router::get('/', 'AuthController@loginForm');
Router::get('/login', 'AuthController@loginForm');
Router::post('/login', 'AuthController@login');

Router::get('/register', 'AuthController@registerForm');
Router::post('/register', 'AuthController@register');

Router::get('/logout', 'AuthController@logout');
/* ---------- Seance ---------- */
Router::get('/coach/seances', 'SeanceController@seances');
Router::get('/sportif/seances', 'SeanceController@seancesport');
Router::post('/coach/seances/create', 'SeanceController@createSeance');
Router::post('/coach/seances/delete', 'SeanceController@deleteSeance');
Router::get('/coach/seances/edit/{id}', 'SeanceController@editSeance');
Router::post('/coach/seances/update/{id}', 'SeanceController@updateSeance');
/* ---------- SPORTIF ---------- */
Router::get('/sportif/profile', 'SportifController@profile');
Router::post('/sportif/profile/update', 'SportifController@updateProfile');
/* ---------- COACH ---------- */
Router::get('/coach/profile', 'CoachController@profile');
Router::post('/coach/profile/update','CoachController@updateProfile');
Router::get('/sportif/coaches', 'CoachController@coaches');
/* ---------- RESERVATION ---------- */
Router::get('/reservation/create/{id}', 'ReservationController@create');
Router::post('/reservation/store', 'ReservationController@store');
Router::get('/sportif/history', 'ReservationController@history');
Router::get('/coach/reservations', 'ReservationController@reservations');
Router::post('/sportif/reservations/create', 'ReservationController@store');

