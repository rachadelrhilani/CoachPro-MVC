<?php
namespace App\Models;

class Sportif extends User
{
    public function createSportif(array $data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO sportif (nom, prenom, id_user)
             VALUES (:nom, :prenom, :id_user)"
        );

        $stmt->execute($data);
    }
}

