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
    
}
