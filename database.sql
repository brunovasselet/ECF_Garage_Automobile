CREATE DATABASE IF NOT EXISTS Garage;

USE Garage;

CREATE TABLE IF NOT EXISTS Administrator (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255),
    mdp VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Staff (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255),
    mdp VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT
);

INSERT INTO Administrator (email, mdp)
VALUES ('admin@gmail.com', '123456');

INSERT INTO Services (name, description)
VALUES ('Réparation Carrosserie', 'Jantes éraflées, griffure sur le tableau de bord ou intérieur de portière, bosse ou rayure sur votre carrosserie voiture…? Confiez nous la réparation carrosserie de votre véhicule.');

INSERT INTO Services (name, description)
VALUES ('Réparation Vitrage et Pare-brise', 'Bénéficiez d\'un diagnostic vitrage rapide et confiez le remplacement ou la réparation de votre pare-brise à nos experts.');

INSERT INTO Services (name, description)
VALUES ('Mécanique et entretien', 'Besoin d\'un entretien ou de changer des pièces sur votre véhicule ? Pas de panique ! Nos experts s\'en charge.');

INSERT INTO Services (name, description)
VALUES ('Entretien et Révision véhicule électrique', 'Nous proposons une révision spécifique pour les véhicules électriques conforme aux préconisations constructeurs, qui inclut 8 points de contrôles spécifiques liés à la gestion électrique du véhicule, dont l\’état de santé de votre pack batterie, le SOH (State Of Health), élément essentiel qui représente une part importante de la valeur du véhicule.');


