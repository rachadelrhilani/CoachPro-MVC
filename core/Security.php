<?php
namespace Core;

class Security
{
    public static function requireAuth()
    {
        if (!Session::get('user')) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public static function requireRole(string $role)
    {
        self::requireAuth();

        if (Session::get('user')['role'] !== $role) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }
    public static function generateCsrfToken(): string
    {
        if (!Session::get('csrf_token')) {
            Session::set('csrf_token', bin2hex(random_bytes(32)));
        }
        return Session::get('csrf_token');
    }

    public static function checkCsrfToken()
    {
        if (
            !isset($_POST['_csrf']) ||
            $_POST['_csrf'] !== Session::get('csrf_token')
        ) {
            Session::flash('error', 'Session expirée, veuillez réessayer.');
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        }
    }

}
