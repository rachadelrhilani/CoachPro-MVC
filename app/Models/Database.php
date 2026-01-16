<?php
namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getInstance(): PDO
    {
        if (!self::$pdo) {

            $config = require dirname(__DIR__, 2) . '/config/database.php';

            try {
                $dsn = sprintf(
                    "pgsql:host=%s;port=%s;dbname=%s",
                    $config['host'],
                    $config['port'],
                    $config['dbname']
                );

                self::$pdo = new PDO(
                    $dsn,
                    $config['user'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );

            } catch (PDOException $e) {
                throw new \RuntimeException(
                    'Erreur connexion DB : ' . $e->getMessage()
                );
            }
        }

        return self::$pdo;
    }
}
