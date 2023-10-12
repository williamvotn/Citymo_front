<?php
// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "projet_immo";

// Créez une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Chemin vers le fichier CSV
$csvFile = './Data/paris.csv';

// Ouvrez le fichier CSV en lecture
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Les données du CSV sont stockées dans le tableau $data
        // Insérez ces données dans votre base de données
        $sql = "INSERT INTO transactions (id_mutation, type_local, valeur_fonciere, adresse_numero, adresse_nom_voie, code_postal, surface_reelle_bati, nombre_pieces_principales, longitude, latitude)
                VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]')";

        if ($conn->query($sql) === TRUE) {
            echo "Enregistrement inséré avec succès.<br>";
        } else {
            echo "Erreur lors de l'insertion de l'enregistrement : " . $conn->error . "<br>";
        }
    }
    fclose($handle);
} else {
    echo "Impossible d'ouvrir le fichier CSV.";
}

// Fermez la connexion à la base de données
$conn->close();
?>
