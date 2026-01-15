<?php
namespace App\Models;

use PDO;

class Reservation
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function bySportif(int $sportifId)
{
    $stmt = $this->db->prepare("
        SELECT 
            r.id_reservation,
            r.date_reservation,
            s.date_seance,
            s.heure,
            s.duree,
            c.nom,
            c.prenom,
            c.discipline
        FROM reservation r
        JOIN seance s ON s.id_seance = r.id_seance
        JOIN coach c ON c.id_coach = s.id_coach
        WHERE r.id_sportif = :id
        ORDER BY s.date_seance DESC
    ");

    $stmt->execute(['id' => $sportifId]);
    return $stmt->fetchAll();
}

}
