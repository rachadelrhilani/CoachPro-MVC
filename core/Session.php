<?php
namespace Core;

class Session
{
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy()
    {
        session_destroy();
    }
    public static function flash(string $key, ?string $message = null)
    {
        if ($message !== null) {
            $_SESSION['flash'][$key] = $message;
            return;
        }
        if (isset($_SESSION['flash'][$key])) {
            $msg = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]); // auto delete
            return $msg;
        }

        return null;
    }
}
