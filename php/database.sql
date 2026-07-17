CREATE DATABASE IF NOT EXISTS `n4k`;

USE `n4k`;

-- Table: users
CREATE TABLE IF NOT EXISTS `users` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'User',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table: matieres
CREATE TABLE IF NOT EXISTS `matieres` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  description TEXT NOT NULL
);

-- Table: groupes
CREATE TABLE IF NOT EXISTS `groupes` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  code VARCHAR(50) NOT NULL,
  visibilite ENUM('Public', 'Prive') NOT NULL DEFAULT 'Public',
  admin_id INTEGER NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: membres
CREATE TABLE IF NOT EXISTS `membres` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  groupe_id INTEGER NOT NULL,
  user_id INTEGER NOT NULL,
  role ENUM('Admin', 'Membre') NOT NULL DEFAULT 'Membre',
  UNIQUE (groupe_id, user_id),
  FOREIGN KEY (groupe_id) REFERENCES groupes(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: ressources
CREATE TABLE IF NOT EXISTS `ressources` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` ENUM('TP', 'TD', 'EXO', 'Cours', 'Examen', 'Rapport', 'Memoire', 'Exercice', 'Presentation', 'Fiche de revision', 'Autre') NOT NULL,
  visibilite ENUM('Public', 'Prive') NOT NULL DEFAULT 'Public',
  matiere_id INTEGER NULL,
  groupe_id INTEGER NOT NULL DEFAULT 0,
  auteur_id INTEGER NOT NULL,
  filepath VARCHAR(500) NULL,
  original_name VARCHAR(255) NULL,
  file_size INTEGER NULL,
  mime_type VARCHAR(100) NULL,
  views INTEGER NOT NULL DEFAULT 0,
  downloads INTEGER NOT NULL DEFAULT 0,
  pinned TINYINT(1) NOT NULL DEFAULT 0,
  FOREIGN KEY (matiere_id) REFERENCES matieres(id) ON DELETE SET NULL,
  FOREIGN KEY (auteur_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: favoris
CREATE TABLE IF NOT EXISTS `favoris` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INTEGER NOT NULL,
  ressource_id INTEGER NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (user_id, ressource_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (ressource_id) REFERENCES ressources(id) ON DELETE CASCADE
);

-- Table: commentaires
CREATE TABLE IF NOT EXISTS `commentaires` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  message TEXT NOT NULL,
  ressource_id INTEGER NOT NULL,
  user_id INTEGER NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (ressource_id) REFERENCES ressources(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);