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

     public function exists(int $idSeance): bool
    {
        $stmt = $this->db->prepare(
            "SELECT 1 FROM reservation WHERE id_seance = :id_seance LIMIT 1"
        );

        $stmt->execute([
            'id_seance' => $idSeance
        ]);

        return (bool) $stmt->fetchColumn();
    }


    public function create(int $idSeance, int $idSportif): bool
    {
        try {
            $this->db->beginTransaction();

            // Créer la réservation
            $stmt = $this->db->prepare(
                "INSERT INTO reservation (id_seance, id_sportif)
                 VALUES (:id_seance, :id_sportif)"
            );

            $stmt->execute([
                'id_seance'  => $idSeance,
                'id_sportif' => $idSportif
            ]);

            // Mettre à jour le statut de la séance
            $stmt = $this->db->prepare(
                "UPDATE seance
                 SET statut = 'reservee'
                 WHERE id_seance = :id_seance"
            );

            $stmt->execute([
                'id_seance' => $idSeance
            ]);

            $this->db->commit();
            return true;

        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
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
public function byCoach(int $coachId)
{
    $stmt = $this->db->prepare("
        SELECT 
            s.date_seance,
            s.heure,
            s.duree,
            sp.nom,
            sp.prenom
        FROM reservation r
        JOIN seance s ON s.id_seance = r.id_seance
        JOIN sportif sp ON sp.id_sportif = r.id_sportif
        WHERE s.id_coach = :id
        ORDER BY s.date_seance DESC
    ");

    $stmt->execute(['id' => $coachId]);
    return $stmt->fetchAll();
}


}
