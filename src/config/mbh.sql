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

-- Insertion de quelques utilisateurs supplémentaires
INSERT INTO utilisateurs (nom, email, pass, photo) VALUES
('Ditorga NANGA', 'ditorga.nanga@gmail.com', '$2y$10$toh9cT82ZiQUYUZDwKkqhe7ffIJmWMy2q55PCn/dr.sbRDfZnbe/.', 'default.png'),
('Ali BARRY', 'ali.barry@gmail.com', '$2y$10$toh9cT82ZiQUYUZDwKkqhe7ffIJmWMy2q55PCn/dr.sbRDfZnbe/.', 'default.png'),
('Darryl-win LOGOSSOU', 'darryl.logossou@gmail.com', '$2y$10$toh9cT82ZiQUYUZDwKkqhe7ffIJmWMy2q55PCn/dr.sbRDfZnbe/.', 'default.png');

-- Insertion des profils
INSERT INTO profiles (user_id, full_name, bio, interests, skills, education, experience, location) VALUES
(1, 'Toï Ewaza TCHAMOUZA', 'Développeur Full Stack passionné', 'Développement web, IA', 'PHP, JavaScript, Python', 'Master en Informatique', '3 ans d''expérience en développement', 'Lomé, Togo'),
(2, 'Ditorga NANGA', 'Expert en cybersécurité', 'Sécurité informatique, Réseaux', 'Cybersécurité, Administration système', 'License en Sécurité informatique', '2 ans en tant qu''analyste sécurité', 'Lomé, Togo'),
(3, 'Ali BARRY', 'Mentor en développement personnel', 'Coaching, Leadership', 'Communication, Management', 'Master en Management', '5 ans d''expérience en coaching', 'Kara, Togo'),
(4, 'Darryl-win LOGOSSOU', 'Designer UX/UI', 'Design d''interface, Expérience utilisateur', 'Figma, Adobe XD', 'Formation en Design numérique', '2 ans en design d''interface', 'Lomé, Togo');

-- Insertion des cours
INSERT INTO courses (title, description, category, level, duration, instructor_id, status) VALUES
('Introduction au Développement Web', 'Fondamentaux du développement web', 'Développement', 'beginner', 30, 1, 'published'),
('Cybersécurité pour Débutants', 'Bases de la sécurité informatique', 'Sécurité', 'beginner', 20, 2, 'published'),
('Leadership et Management', 'Développer ses compétences en leadership', 'Soft Skills', 'intermediate', 25, 3, 'published'),
('UX Design Avancé', 'Conception d''interfaces utilisateur', 'Design', 'advanced', 40, 4, 'published');

-- Insertion des évaluations
INSERT INTO assessments (title, type, questions, duration) VALUES
('Test d''Orientation Professionnelle', 'personality', '{"q1": "Quel est votre domaine préféré ?", "q2": "Quels sont vos points forts ?"}', 30),
('Évaluation Technique Web', 'skills', '{"q1": "Qu''est-ce que HTML ?", "q2": "Expliquez CSS"}', 45),
('Test d''Intérêts Professionnels', 'interests', '{"q1": "Quel secteur vous attire ?", "q2": "Environnement de travail idéal ?"}', 25);

-- Insertion des certificats
INSERT INTO certificates (user_id, course_id, certificate_number, status) VALUES
(2, 1, 'CERT-2025-001', 'issued'),
(3, 2, 'CERT-2025-002', 'issued'),
(4, 3, 'CERT-2025-003', 'issued');

-- Insertion des relations de mentorat
INSERT INTO mentorships (mentor_id, mentee_id, status, start_date, end_date, field, objectives) VALUES
(1, 2, 'active', '2025-04-01', '2025-07-01', 'Développement Web', 'Maîtriser les frameworks modernes'),
(3, 4, 'active', '2025-04-01', '2025-07-01', 'Leadership', 'Développer des compétences en management');

-- Insertion des messages
INSERT INTO messages (sender_id, receiver_id, content, status) VALUES
(1, 2, 'Bonjour, comment se passe votre progression ?', 'delivered'),
(2, 1, 'Très bien, merci ! J''ai des questions sur le dernier module.', 'read'),
(3, 4, 'N''oubliez pas notre session de mentorat demain !', 'sent');

-- Insertion des progrès
INSERT INTO progress (user_id, course_id, status, completion_rate) VALUES
(2, 1, 'in_progress', 65.50),
(3, 2, 'completed', 100.00),
(4, 3, 'in_progress', 45.75);