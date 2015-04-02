/* 
 * CREATION DE LA BASE DE DONNEES
 */

CREATE TABLE UTILISATEURS (
	email VARCHAR (50) UNIQUE NOT NULL,
	code CHAR(8) NOT NULL,
	valide BOOLEAN NOT NULL,
	PRIMARY KEY (email) 
) ENGINE=InnoDB;

CREATE TABLE PARCOURS (
	idParcours int(11) NOT NULL AUTO_INCREMENT,
	distance INT,
	type VARCHAR(5),
	PRIMARY KEY (idParcours) 
) ENGINE=InnoDB;

CREATE TABLE PREINSCRIPTIONS (
	idPreInscription int(11) NOT NULL AUTO_INCREMENT,
	estArrive BOOLEAN NOT NULL,
	nom VARCHAR(30),
	prenom VARCHAR(30),
	sexe CHAR(1),
	dateNaissance DATE,
	federation VARCHAR (6),
	clubOuVille VARCHAR (40),
	departement INT,
	parcours int(11) NOT NULL,
	inscriveur VARCHAR (50) NOT NULL,
	PRIMARY KEY (idPreInscription)
) ENGINE=InnoDB;

ALTER TABLE PREINSCRIPTIONS
  ADD CONSTRAINT preinscription_1 FOREIGN KEY (parcours) REFERENCES PARCOURS (idParcours);

﻿/* 
 * INSERTION DES PARCOURS
 */

INSERT INTO PARCOURS (idParcours, distance, type) VALUES 
(NULL, 15, 'VTT'),
(NULL, 25, 'VTT'),
(NULL, 40, 'VTT'),
(NULL, 50, 'VTT'),
(NULL, 30, 'ROUTE'),
(NULL, 60, 'ROUTE'),
(NULL, 85, 'ROUTE'),
(NULL, 95, 'ROUTE'),
(NULL, 110, 'ROUTE'),
(NULL, 120, 'ROUTE');
