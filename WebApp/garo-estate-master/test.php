<?php
// Informations de connexion à la base de données
$serveur = "localhost:5000"; // Nom du conteneur Docker ou adresse IP du conteneur
$utilisateur = "root"; // Nom d'utilisateur de la base de données
$motDePasse = "root"; // Mot de passe de la base de données
$nomDeLaBase = "siteimmo"; // Nom de la base de données

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Paramètres supplémentaires pour afficher les erreurs PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Exécuter la commande SHOW TABLES
    $resultats = $connexion->query("SHOW TABLES");

    // Récupérer les résultats de la requête
    $tables = $resultats->fetchAll(PDO::FETCH_COLUMN);

    // Afficher les noms des tables
    echo "Tables dans la base de données $nomDeLaBase :<br>";
    foreach ($tables as $table) {
        echo $table . "<br>";
    }

    // Fermer la connexion lorsque vous avez fini
    $connexion = null;
} catch (PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
?>
