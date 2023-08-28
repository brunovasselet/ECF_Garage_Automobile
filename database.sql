CREATE DATABASE Garage;

USE Garage;

CREATE TABLE Administrator (
    id INT PRIMARY KEY,
    mail VARCHAR(255),
    mdp VARCHAR(255)
);

CREATE TABLE Staff (
    id INT PRIMARY KEY,
    mail VARCHAR(255),
    mdp VARCHAR(255)
);

CREATE TABLE Services (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    description(255)
);

INSERT INTO Administrator (id, mail, mdp)
VALUES (1, patron@gmail.com, 123456)

