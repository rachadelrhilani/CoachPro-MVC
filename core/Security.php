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
}
