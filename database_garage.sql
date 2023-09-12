CREATE DATABASE IF NOT EXISTS Garage;

USE Garage;

CREATE TABLE IF NOT EXISTS Administrator (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255),
    mdp VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Employees (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255),
    mdp VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT,
    price FLOAT
);


CREATE TABLE IF NOT EXISTS Contact (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(10),
    subject VARCHAR(255),
    message TEXT
);

CREATE TABLE IF NOT EXISTS Testimonial (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    comment TEXT,
    score INT,
    approved BOOLEAN
);

CREATE TABLE IF NOT EXISTS Vehicles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    price FLOAT,
    picture VARCHAR(255),
    date VARCHAR(255),
    mileage VARCHAR(10),
    description VARCHAR(255)
);

INSERT INTO Administrator (email, mdp)
VALUES ('admin@gmail.com', '123456789');

INSERT INTO Services (name, description, price)
VALUES ('Réparation Carrosserie', 'Jantes éraflées, griffure sur le tableau de bord ou intérieur de portière, bosse ou rayure sur votre carrosserie voiture…? Confiez nous la réparation carrosserie de votre véhicule.', '50');

INSERT INTO Services (name, description, price)
VALUES ('Réparation Vitrage et Pare-brise', 'Bénéficiez d\'un diagnostic vitrage rapide et confiez le remplacement ou la réparation de votre pare-brise à nos experts.', '70');

INSERT INTO Services (name, description, price)
VALUES ('Mécanique et entretien', 'Besoin d\'un entretien ou de changer des pièces sur votre véhicule ? Pas de panique ! Nos experts s\'en charge.', '65');

INSERT INTO Services (name, description, price)
VALUES ('Entretien et Révision véhicule électrique', 'Nous proposons une révision spécifique pour les véhicules électriques conforme aux préconisations constructeurs, qui inclut 8 points de contrôles spécifiques liés à la gestion électrique du véhicule, dont l\’état de santé de votre pack batterie, le SOH (State Of Health), élément essentiel qui représente une part importante de la valeur du véhicule.', '60');

INSERT INTO vehicles (name, price, picture, date, mileage, description)
VALUES ('Alfa Romeo Mito', '5990', '43da2d998c4a9ef33a6f27d2cadb57649b02e3a3.jpg', '2011', '113500', 'ALFA ROMEO MITO 1.4 MPi 105 cv,Boîte manuel 6 rapports, Finition SELECTIVE, Entretien suivi à jour, Contrôle technique Ok.');

INSERT INTO vehicles (name, price, picture, date, mileage, description)
VALUES ('Peugeot 207', '6000', '69d40215ac44d2e25369c0c30caf0c981625b519.jpg', '2008', '73000', 'Vente d\'une Peugeot 207. - Essence, - 73000 km, - Mise en circulation 21/08/2008.');

INSERT INTO vehicles (name, price, picture, date, mileage, description)
VALUES ('Range Rover Evoque', '24500', '6082de801728c435d6fd2b3f4980edabd00bf231.jpg', '2017', '125000', 'Excellent Etat, Aucun accident à declarer depuis sa mise en circulation. Carnet d\’entretient à jour. CT à jour depuis 03/2023, Pneu Neuf');

INSERT INTO vehicles (name, price, picture, date, mileage, description)
VALUES ('Renault Captur', '12990', '44b369273767cf586cc9375162e399a8478df256.jpg', '2019', '106000', 'Puissance : 5 CV, Puissance réelle : 90 Ch, Energie : Diesel, Couleur : Bleu, Boite de vitesse : Boîte Manuelle 5 vitesse, Nombre de portes : 5');

INSERT INTO vehicles (name, price, picture, date, mileage, description)
VALUES ('Volkswagen Golf VII', '14990', '67c95a3b99db7fc7efdcdfe92c391a5e402e365a.jpg', '2013', '80370', 'Energie : Essence, Boite de vitesse : Manuelle, Couleur :blanc verni, Sellerie :tissu noir, Nombre de portes : 5, Nombre de places : 5, Puissance fiscale : 7 CV, Puissances : 140 ch');
