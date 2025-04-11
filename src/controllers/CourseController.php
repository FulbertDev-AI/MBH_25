<?php
require_once __DIR__ . '/../models/CourseModel.php';

class CourseController
{
    private $courseModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
    }

    public function index()
    {
        return $this->courseModel->getAll();
    }

    public function show($id)
    {
        return $this->courseModel->getById($id);
    }

    public function create($data)
    {
        if (empty($data['title']) || empty($data['description']) || empty($data['instructor_id'])) {
            throw new Exception('Les champs titre, description et instructeur sont obligatoires');
        }
        return $this->courseModel->create($data);
    }
}