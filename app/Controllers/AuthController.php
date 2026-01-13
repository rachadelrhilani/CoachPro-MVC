<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use App\Models\User;
use App\Models\Coach;
use App\Models\Sportif;
use App\Models\Database;

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
        $db = Database::getInstance();
        $db->beginTransaction();

        try {
            $userModel = new User();

            $userId = $userModel->create(
                $_POST['email'],
                $_POST['password'],
                $_POST['role']
            );

            if ($_POST['role'] === 'coach') {
                (new Coach())->create([
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'discipline' => $_POST['discipline'],
                    'annees' => $_POST['experience'],
                    'description' => $_POST['description'],
                    'id_user' => $userId
                ]);
            } else {
                (new Sportif())->create([
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'id_user' => $userId
                ]);
            }

            $db->commit();
            $this->redirect('/auth/login');

        } catch (\Exception $e) {
            $db->rollBack();
            $this->render('auth/register', [
                'error' => 'Email est deja utiliser'
            ]);
        }
    }

    public function login()
    {
        $user = (new User())->findByEmail($_POST['email']);

        if (!$user || !password_verify($_POST['password'], $user['mot_de_passe'])) {
            return $this->render('auth/login', [
                'error' => 'Email ou mot de passe incorrect'
            ]);
        }

        Session::set('user', $user);

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
