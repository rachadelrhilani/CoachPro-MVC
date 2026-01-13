<?php
namespace App\Models;

use PDO;

class User
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM utilisateur WHERE email = :email"
        );
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function create(string $email, string $password, string $role): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO utilisateur (email, mot_de_passe, role)
             VALUES (:email, :password, :role)
             RETURNING id_user"
        );

        $stmt->execute([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => $role
        ]);

        return $stmt->fetchColumn();
    }
}
