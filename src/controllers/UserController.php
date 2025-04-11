<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return $this->userModel->getAll();
    }

    public function show($id)
    {
        return $this->userModel->getById($id);
    }

    public function create($data)
    {
        if (empty($data['nom']) || empty($data['email']) || empty($data['pass'])) {
            throw new Exception('Tous les champs sont obligatoires');
        }
        return $this->userModel->create($data);
    }

    public function update($id, $data)
    {
        return $this->userModel->update($id, $data);
    }

    public function delete($id)
    {
        return $this->userModel->delete($id);
    }
}