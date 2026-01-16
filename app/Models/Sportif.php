<?php

namespace App\Models;

class Sportif extends User
{
    protected string $table = 'sportif';
    public function createSportif(array $data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO sportif (nom, prenom, id_user)
             VALUES (:nom, :prenom, :id_user)"
        );

        $stmt->execute($data);
    }


    public function findByUser(int $userId)
    {
        $stmt = $this->db->prepare(
            "SELECT s.*, u.email
             FROM sportif s
             JOIN utilisateur u ON u.id_user = s.id_sportif
             WHERE u.id_user = :id"
        );
        $stmt->execute(['id' => $userId]);

        return $stmt->fetch();
    }

    public function update(int $userId, array $data)
    {
        // update table sportif
        $stmt = $this->db->prepare(
            "UPDATE sportif 
             SET nom = :nom, prenom = :prenom
             WHERE id_sportif = :id_user"
        );

        $stmt->execute([
            'nom'     => $data['nom'],
            'prenom'  => $data['prenom'],
            'id_user' => $userId
        ]);


        $stmt = $this->db->prepare(
            "UPDATE utilisateur SET email = :email WHERE id_user = :id"
        );

        $stmt->execute([
            'email' => $data['email'],
            'id'    => $userId
        ]);
    }
    public function findByUserId($userId)
    {
        $stmt = $this->db->prepare("
        SELECT nom, prenom 
        FROM sportif 
        WHERE id_user = :id_user
    ");
        $stmt->execute(['id_user' => $userId]);
        return $stmt->fetch();
    }
}
