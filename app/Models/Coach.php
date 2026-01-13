<?php
namespace App\Models;

use PDO;

class Coach
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO coach (nom, prenom, discipline, annees_experience, description, id_user)
             VALUES (:nom, :prenom, :discipline, :annees, :description, :id_user)"
        );

        $stmt->execute($data);
    }
}
