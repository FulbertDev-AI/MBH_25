<?php
// Configuration de la base de données
$host = 'localhost';
$port = 3306;
$dbname = 'mbh';
$username = 'root';
$password = 'password';

try {
    // Connexion à la base de données avec PDO en incluant le port
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "success";
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}