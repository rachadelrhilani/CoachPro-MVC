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
    public function findByUser(int $userId)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM coach WHERE id_user = :id
    ");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch();
    }
    public function update(int $userId, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE coach SET
                nom = :nom,
                prenom = :prenom,
                discipline = :discipline,
                annees_experience = :annees_experience,
                description = :description
             WHERE id_user = :id_user"
        );

        return $stmt->execute([
            'nom' => htmlspecialchars($data['nom']),
            'prenom' => htmlspecialchars($data['prenom']),
            'discipline' => htmlspecialchars($data['discipline']),
            'annees_experience' => (int) $data['annees_experience'],
            'description' => htmlspecialchars($data['description']),
            'id_user' => $userId
        ]);
    }
}
