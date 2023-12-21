<?php
function generateSimilarProperties($propertyID)
{
$serveur = "localhost:5000"; // Nom du conteneur Docker ou adresse IP du conteneur
$utilisateur = "root"; // Nom d'utilisateur de la base de données
$motDePasse = "root"; // Mot de passe de la base de données
$nomDeLaBase = "siteimmo"; // Nom de la base de données
$pythonScript = './python.py';

// Exécutez le script Python et récupérez la sortie
$command = 'C:/Users/Guillaume/AppData/Local/Programs/Python/Python312/python.exe ' . $pythonScript . ' 2>&1';
$generatedIds = shell_exec($command);

// Supprimer les crochets et les espaces de la sortie JSON
$cleanedIds = str_replace(['[', ']', ' '], '', $generatedIds);

// Convertir la chaîne résultante en un tableau d'IDs
$idsArray = explode(",", $cleanedIds);
// Connexion à la base de données
try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Paramètres supplémentaires pour afficher les erreurs PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $results = [];
    $i=0;
    // Boucle sur les IDs et récupération des propriétés
        $sql="SELECT * FROM Paris WHERE ID IN ($cleanedIds)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();

        // Stockage des résultats dans le tableau
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<pre>';
        print_r($result);
        echo '</pre>';*/
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

$properties=$result;

    foreach ($properties as $property) {
        $imageURLs = explode(' ', $property['ImageURL']);
        $firstImageURL = $imageURLs[0];
        echo '
            <div class="panel panel-default sidebar-menu similar-property-wdg wow fadeInRight animated">
                <div class="panel-heading">
                    <h3 class="panel-title">Propriété Similaire :</h3>
                </div>
                <div class="panel-body recent-property-widget">
                    <ul>
                        <li>
                        <form action="property.php" method="post">
                        <input type="hidden" name="property" value="' . htmlspecialchars(json_encode($property)) . '">
                            <div class="col-md-3 col-sm-3 col-xs-3 blg-thumb p0">
                            <button type="submit"><img src="' . $firstImageURL . '"></button>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8 blg-entry">
                                <h6> <button type="submit">' . $property['ID'] . ' </button></h6>
                                <span class="property-price">' . $property['Prix'] . '€</span>
                            </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        ';
    }
}

?>
