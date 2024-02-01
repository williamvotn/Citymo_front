<?php
function generateSimilarProperties($propertyID, $noidMutation)
{
$serveur = "db"; // Nom du conteneur Docker ou adresse IP du conteneur
$utilisateur = "root"; // Nom d'utilisateur de la base de données
$motDePasse = "root"; // Mot de passe de la base de données
$nomDeLaBase = "siteimmo"; // Nom de la base de données
$pythonScript = './recommander_clean_2.py';
// Récupération de l'ID de mutation depuis l'URL
// Exécutez le script Python et récupérez la sortie
if ($noidMutation == null) {
$command = 'python3 ' . $pythonScript . ' ' . $propertyID;
}
else{
    $command = 'python3 ' . $pythonScript . ' ' . $propertyID .' --without ' . $noidMutation ;
}
$generatedIds = shell_exec($command);

// Supprimer les crochets et les espaces de la sortie JSON
$cleanedIds = str_replace(['[', ']', ' '], '', $generatedIds);
//echo "SAUVEZ MOI AAAAAAAAAAAAAAAAAAAAAAAA cleaned ids = $cleanedIds";
// Convertir la chaîne résultante en un tableau d'IDs
$idsArray = explode(",", $cleanedIds);
// Connexion à la base de données
$noID = $propertyID;
try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Paramètres supplémentaires pour afficher les erreurs PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $i=0;
    // Boucle sur les IDs et récupération des propriétés
        $sql="SELECT * FROM Paris WHERE ID IN ($cleanedIds)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();

        // Stockage des résultats dans le tableau
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

$properties=$result;
echo '            <div class="panel panel-default sidebar-menu similar-property-wdg wow fadeInRight animated">
                    <div class="panel-heading">
                        <h3 class="panel-title">Propriétés Similaires :</h3>
                    </div>
                    <div class="panel-body recent-property-widget">';
    foreach ($properties as $property) {
        $imageURLs = explode(' ', $property['ImageURL']);
        $firstImageURL = $imageURLs[0];
        echo '
            <form action="appartement.php" method="post">
                <button type="submit">
                    <ul>
                        <li>
                        <input type="hidden" name="property" value="' . htmlspecialchars(json_encode($property)) . '">
                        <input type="hidden" name="no_id_mutation" value="' . $noID . '">
                            <div class="col-md-3 col-sm-3 col-xs-3 blg-thumb p0">
                            <img src="' . $firstImageURL . '">
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8 blg-entry">
                            <span>Appartement de ' . $property['Surface'] . ' m²</span>
                                <span class="property-price">' . $property['Prix'] . '€</span>
                            </div>
                        </li>
                    </ul>
                </button>
            </form>
        ';
    }
    echo'                </div>
                    </div>';
}

?>
