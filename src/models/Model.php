<?php
class Model {
    protected $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/config.php';
        /** @var ?PDO $pdo */
        $this->pdo = $pdo;
    }
}