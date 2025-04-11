<?php

require_once __DIR__ . "/Model.php";

// UserModel.php - Modèle pour tous les utilisateurs
class UserModel extends Model
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $role; // étudiant, mentor, admin
    private $avatar;
    private $created_at;
    private $updated_at;

    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM utilisateurs');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO utilisateurs (nom, email, pass, photo) VALUES (?, ?, ?, ?)');
        return $stmt->execute([
            $data['nom'],
            $data['email'],
            password_hash($data['pass'], PASSWORD_DEFAULT),
            $data['photo'] ?? 'default.jpg'
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE utilisateurs SET nom = ?, email = ?, photo = ? WHERE id = ?');
        return $stmt->execute([
            $data['nom'],
            $data['email'],
            $data['photo'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM utilisateurs WHERE id = ?');
        return $stmt->execute([$id]);
    }
}