<?php
namespace App\Models;

use PDO;

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
   public function all(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                c.id_coach,
                c.nom,
                c.prenom,
                c.discipline,
                c.annees_experience,
                c.description,
                u.email
            FROM coach c
            JOIN utilisateur u ON u.id_user = c.id_user
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
