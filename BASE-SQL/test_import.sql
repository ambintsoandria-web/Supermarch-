CREATE DATABASE test_import;

\ c test_import;

CREATE TABLE Utilisateur (
    id SERIAL PRIMARY KEY,
    matricule VARCHAR(10),
    ; VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100)
);

CREATE TABLE filiere(
    id SERIAL PRIMARY KEY,
    filiere VARCHAR(100)
);

CREATE TABLE niveau(
    id SERIAL PRIMARY KEY,
    niveau VARCHAR(100)
);

CREATE TABLE Utilisateur_info (
    id SERIAL PRIMARY KEY,
    id_utilisateur INT REFERENCES Utilisateur(id),
    id_filiere INT REFERENCES filiere(id),
    id_niveau INT REFERENCES niveau(id)
);

SELECT table_name
FROM information_schema.tables
WHERE table_schema = 'public' ;
  AND table_type = 'test_import';
  