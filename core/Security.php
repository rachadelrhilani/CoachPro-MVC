<?php
namespace Core;

class Security
{
    public static function clean($value)
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
