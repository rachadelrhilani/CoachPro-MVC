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
            SELECT 
            s.id_seance,
            s.date_seance,
            s.heure,
            s.duree,
            s.statut,
            c.nom,
            c.prenom,
            c.discipline
        FROM seance s
        JOIN coach c ON c.id_coach = s.id_coach
        WHERE s.statut = 'disponible'
        ORDER BY s.date_seance, s.heure
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
    public function create(array $data)
    {
        $stmt = $this->db->prepare("
        INSERT INTO seance (date_seance, heure, duree, id_coach)
        VALUES (:date_seance, :heure, :duree, :id_coach)
    ");
        $stmt->execute($data);
    }
     public function isReserved(int $id): bool
    {
        $stmt = $this->db->prepare(
            "SELECT statut FROM seance WHERE id_seance = :id"
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetchColumn() === 'reservee';
    }

public function delete(int $id)
{
    $stmt = $this->db->prepare("
        DELETE FROM seance WHERE id_seance = :id
    ");
    $stmt->execute(['id' => $id]);
}
public function statsByCoach(int $coachId)
{
    $stmt = $this->db->prepare("
        SELECT
            COUNT(*) AS total,
            COUNT(*) FILTER (WHERE statut = 'disponible') AS disponible,
            COUNT(*) FILTER (WHERE statut = 'reservee') AS reservee
        FROM seance
        WHERE id_coach = :id
    ");
    $stmt->execute(['id' => $coachId]);
    return $stmt->fetch();
}

}
