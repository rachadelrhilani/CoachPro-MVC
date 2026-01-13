<?php
namespace App\Models;

use PDO;

class Sportif
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO sportif (nom, prenom, id_user)
             VALUES (:nom, :prenom, :id_user)"
        );

        $stmt->execute($data);
    }
}
