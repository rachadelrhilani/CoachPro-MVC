<?php
namespace App\Models;

class Coach extends User
{
    public function createCoach(array $data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO coach (nom, prenom, discipline, annees_experience, description, id_user)
             VALUES (:nom, :prenom, :discipline, :annees, :description, :id_user)"
        );

        $stmt->execute($data);
    }
}
