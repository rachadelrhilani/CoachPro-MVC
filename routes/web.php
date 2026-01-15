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
/* ---------- SPORTIF ---------- */
Router::get('/sportif/coaches', 'SportifController@coaches');
Router::get('/sportif/seances', 'SportifController@seances');
Router::get('/sportif/history', 'SportifController@history');
Router::post('/coach/seances/create', 'CoachController@createSeance');
/* ---------- COACH ---------- */
Router::get('/coach/profile', 'CoachController@profile');
Router::get('/coach/seances', 'CoachController@seances');
Router::get('/coach/reservations', 'CoachController@reservations');
Router::get('/coach/dashboard', 'CoachController@dashboard');
Router::post('/coach/profile/update','CoachController@updateProfile');
Router::post('/coach/seances/delete', 'CoachController@deleteSeance');
/* ---------- RESERVATION ---------- */
Router::get('/reservation/create/{id}', 'ReservationController@create');
Router::post('/reservation/store', 'ReservationController@store');
Router::post('/sportif/reservations/create', 'ReservationController@store');

