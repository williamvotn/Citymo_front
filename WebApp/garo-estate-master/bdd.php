<?php
// Informations de connexion à la base de données
$serveur = "siteimmo"; // Nom du conteneur Docker ou adresse IP du conteneur
$utilisateur = "root"; // Nom d'utilisateur de la base de données
$motDePasse = "root"; // Mot de passe de la base de données
$nomDeLaBase = "siteimmo"; // Nom de la base de données

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Paramètres supplémentaires pour afficher les erreurs PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Sélectionner la base de données "siteimmo"
$connexion->query("USE $nomDeLaBase");

// Requête pour sélectionner toutes les lignes de la table "paris"
$requete = $connexion->query("SELECT * FROM paris");

    // Récupérer les résultats de la requête
    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les résultats (à titre d'exemple)
    foreach ($resultats as $row) {
        echo "ID: " . $row['id'] . ", Titre: " . $row['titre'] . ", Description: " . $row['description'] . "<br>";
    }

    // Fermer la connexion lorsque vous avez fini
    $connexion = null;
} catch (PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
?>
