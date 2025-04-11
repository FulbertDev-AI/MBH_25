-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 10 avr. 2025 à 23:27
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS mbh;
USE mbh;


--
-- Base de données : `mbh`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs`
(
    `id`               int(11)   NOT NULL,
    `nom`              varchar(100)       DEFAULT NULL,
    `email`            varchar(100)       DEFAULT NULL,
    `pass`             varchar(255)       DEFAULT NULL,
    `photo`            varchar(255)       DEFAULT NULL,
    `date_inscription` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `pass`, `photo`, `date_inscription`)
VALUES (1, 'Toï Ewaza TCHAMOUZA', 'tchamouzabeni6@gmail.com',
        '$2y$10$toh9cT82ZiQUYUZDwKkqhe7ffIJmWMy2q55PCn/dr.sbRDfZnbe/.',
        '67f8517e45d0a_Capture d\'écran 2025-04-03 095355.png', '2025-04-10 23:17:18');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;


-- Autres tables à créer : --

CREATE TABLE profiles
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    user_id    INT          NOT NULL,
    full_name  VARCHAR(100) NOT NULL,
    bio        TEXT,
    interests  TEXT,
    skills     TEXT,
    education  TEXT,
    experience TEXT,
    location   VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES utilisateurs (id)
);

CREATE TABLE courses
(
    id            INT PRIMARY KEY AUTO_INCREMENT,
    title         VARCHAR(255) NOT NULL,
    description   TEXT,
    category      VARCHAR(100),
    level         ENUM ('beginner', 'intermediate', 'advanced'),
    duration      INT,
    instructor_id INT,
    thumbnail     VARCHAR(255),
    status        ENUM ('draft', 'published', 'archived'),
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES utilisateurs (id)
);

CREATE TABLE assessments
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    title      VARCHAR(255) NOT NULL,
    type       ENUM ('personality', 'skills', 'interests'),
    questions  JSON,
    duration   INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE certificates
(
    id                 INT PRIMARY KEY AUTO_INCREMENT,
    user_id            INT NOT NULL,
    course_id          INT NOT NULL,
    issued_date        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    certificate_number VARCHAR(50) UNIQUE,
    status             ENUM ('issued', 'revoked'),
    FOREIGN KEY (user_id) REFERENCES utilisateurs (id),
    FOREIGN KEY (course_id) REFERENCES courses (id)
);

CREATE TABLE mentorships
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    mentor_id  INT NOT NULL,
    mentee_id  INT NOT NULL,
    status     ENUM ('pending', 'active', 'completed', 'canceled'),
    start_date DATE,
    end_date   DATE,
    field      VARCHAR(100),
    objectives TEXT,
    FOREIGN KEY (mentor_id) REFERENCES utilisateurs (id),
    FOREIGN KEY (mentee_id) REFERENCES utilisateurs (id)
);

CREATE TABLE messages
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    sender_id   INT  NOT NULL,
    receiver_id INT  NOT NULL,
    content     TEXT NOT NULL,
    status      ENUM ('sent', 'delivered', 'read'),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES utilisateurs (id),
    FOREIGN KEY (receiver_id) REFERENCES utilisateurs (id)
);

CREATE TABLE progress
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    user_id         INT NOT NULL,
    course_id       INT NOT NULL,
    status          ENUM ('not_started', 'in_progress', 'completed'),
    completion_rate DECIMAL(5, 2) DEFAULT 0.00,
    last_accessed   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateurs (id),
    FOREIGN KEY (course_id) REFERENCES courses (id)
);


-- Insertion de quelques données dans les tables

