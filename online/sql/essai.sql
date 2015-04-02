/*
 * JEU D'ESSAI
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

INSERT INTO UTILISATEURS (email, code, valide) VALUES
('user1@mail.com', '12a3zz1e', false),
('user2@mail.com', 'cle0256a', true);

INSERT INTO PREINSCRIPTIONS (idPreInscription, estArrive, nom, prenom, sexe, dateNaissance, federation, clubOuVille, departement, parcours, inscriveur) VALUES
(NULL, 'false', 'FAVIER', 'MARC', 'F', '1986-06-18', 'NL', 'ZSTPERAY', 7, 1, 'user2@mail.com'),
(NULL, 'false', 'TAILLEFER', 'THOMAS', 'H', '1974-04-01', 'NL', 'ZROMANS', 26, 4, 'user2@mail.com'),
(NULL, 'false', 'WEIL', 'SEBASTIEN', 'H', '1964-07-17', 'NL', 'ZBOFFRES', 7, 5, 'user2@mail.com'),
(NULL, 'false', 'THEOBALD', 'JULES', 'H', '1999-02-09', 'NL', 'ZVALENCE', 26, 1, 'user2@mail.com');
