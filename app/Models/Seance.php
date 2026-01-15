<?php

namespace App\Models;

use PDO;

class Seance
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all()
    {
        $stmt = $this->db->query("
            SELECT s.*, c.nom, c.prenom, c.discipline
            FROM seance s
            JOIN coach c ON c.id_user = s.id_coach
            ORDER BY s.date_seance ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function byCoach(int $coachId)
    {
        $stmt = $this->db->prepare("
        SELECT *
        FROM seance
        WHERE id_coach = :id
        ORDER BY date_seance, heure
    ");
        $stmt->execute(['id' => $coachId]);
        return $stmt->fetchAll();
    }
}
