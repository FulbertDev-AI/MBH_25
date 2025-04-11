<?php
// CourseModel.php - Modèle pour les cours/formations
require_once __DIR__ . '/Model.php';

class CourseModel extends Model
{
    private $id;
    private $title;
    private $description;
    private $category;
    private $level;
    private $duration;
    private $instructor_id;
    private $thumbnail;
    private $status;
    private $created_at;

    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT c.*, u.nom as instructor_name, u.photo as user_photo FROM courses c 
                                  LEFT JOIN utilisateurs u ON c.instructor_id = u.id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT c.*, u.nom as instructor_name FROM courses c 
                                    LEFT JOIN utilisateurs u ON c.instructor_id = u.id 
                                    WHERE c.id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO courses (title, description, category, level, duration, instructor_id, status) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)');
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['category'],
            $data['level'],
            $data['duration'],
            $data['instructor_id'],
            $data['status'] ?? 'draft'
        ]);
    }
}