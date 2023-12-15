#!/bin/bash

# Creez la base de donnees si elle n'existe pas
mysql -h localhost -u root -proot <<EOF
CREATE DATABASE IF NOT EXISTS siteimmo;
USE siteimmo;
SET GLOBAL local_infile=1;
EOF


# Utilisez la base de donnees
mysql -h localhost -u root -proot --local-infile=1 siteimmo <<EOF
# Creez la table si elle n'existe pas
CREATE TABLE IF NOT EXISTS paris (
    ID INT PRIMARY KEY,
    Lien_source TEXT,
    ImageURL TEXT,
    Prix INT,
    Arrondissement INT,
    Features TEXT,
    Classe_de_performance_energetique CHAR(1),
    Classe_d_emission_a_effet_de_serre CHAR(1),
    Description TEXT,
    Latitude DECIMAL(9,6),
    Longitude DECIMAL(9,6),
    Surface DECIMAL(9,2),
    Nombre_de_pieces INT,
    Nombre_de_chambres INT,
    Nombre_de_salles_de_bain INT,
    Nombre_de_salles_d_eau INT,
    Chauffage VARCHAR(255),
    Cave BOOLEAN,
    Ascenseur BOOLEAN,
    Balcon BOOLEAN,
    Box BOOLEAN,
    Digicode BOOLEAN,
    Gardien BOOLEAN,
    Exposition VARCHAR(255),
    Interphone BOOLEAN,
    Garage BOOLEAN,
    Parking BOOLEAN,
    Cheminee BOOLEAN,
    Alarme BOOLEAN,
    Climatisation BOOLEAN,
    Dependance BOOLEAN,
    Terrasse BOOLEAN,
    Radiateurs BOOLEAN,
    Jardin BOOLEAN
);

-- Utiliser LOAD DATA INFILE pour charger les données depuis le fichier CSV
LOAD DATA LOCAL INFILE '/docker-entrypoint-initdb.d/paris.csv'
INTO TABLE paris
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES; -- Ignore la première ligne (en-tête)
EOF