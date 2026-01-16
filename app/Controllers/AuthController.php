<?php

namespace App\Controllers;

use Core\Controller;
use Core\Session;
use App\Models\User;
use App\Models\Coach;
use App\Models\Sportif;
use App\Models\Database;
use Core\Security;

class AuthController extends Controller
{
    public function loginForm()
    {
        $this->render('auth/login');
    }

    public function registerForm()
    {
        $this->render('auth/register');
    }

    public function register()
    {
        Security::checkCsrfToken();
        $db = Database::getInstance();
        $db->beginTransaction();

        try {
            $user = new User();

            $userId = $user->createUser(
                $_POST['email'],
                $_POST['password'],
                $_POST['role']
            );

            if ($_POST['role'] === 'coach') {
                (new Coach())->createCoach([
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'discipline' => $_POST['discipline'],
                    'annees' => $_POST['experience'],
                    'description' => $_POST['description'],
                    'id_user' => $userId
                ]);
            } else {
                (new Sportif())->createSportif([
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'id_user' => $userId
                ]);
            }

            $db->commit();
            $this->redirect('/login');
        } catch (\Exception $e) {
            $db->rollBack();
            $this->render('auth/register', [
                'error' => 'Email déjà utilisé'
            ]);
        }
    }


    public function login()
{
    Security::checkCsrfToken();

    $user = (new User())->findByEmail($_POST['email']);

    if (!$user || !password_verify($_POST['password'], $user['mot_de_passe'])) {
        return $this->render('auth/login', [
            'error' => 'Email ou mot de passe incorrect'
        ]);
    }

    if ($user['role'] === 'coach') {
        $profil = (new Coach())->findByUserId($user['id_user']);
    } else {
        $profil = (new Sportif())->findByUserId($user['id_user']);
    }

    Session::set('user', [
        'id' => $user['id_user'],
        'email' => $user['email'],
        'role' => $user['role'],
        'nom' => $profil['nom'] ?? null,
        'prenom' => $profil['prenom'] ?? null
    ]);

    $this->redirect(
        $user['role'] === 'coach'
            ? '/coach/seances'
            : '/sportif/coaches'
    );
}


    public function logout()
    {
        Session::destroy();
        $this->redirect('/login');
    }
}
