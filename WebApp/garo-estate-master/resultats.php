<?php
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Accéder aux données
$pageNumber = isset($data['page']) ? intval($data['page']) : 1;
$result = isset($data['result']) ? $data['result'] : [];

/*echo '<pre>';
print_r($result);
echo '</pre>';*/

if (!is_array($result)) {
    // En cas d'erreur, vous pouvez renvoyer un message d'erreur ou une réponse appropriée.
    echo "Erreur : Aucun résultat valide reçu.";
    exit;
}

// Pagination
$propertiesPerPage = 9;
$totalProperties = count($result);
$totalPages = ceil($totalProperties / $propertiesPerPage);


// Calculer l'index de départ dans le tableau $result
$startIndex = ($pageNumber - 1) * $propertiesPerPage;

// Extraire les propriétés pour la page actuelle
$propertiesOnPage = array_slice($result, $startIndex, $propertiesPerPage);


// Votre code PHP existant pour récupérer les résultats et la pagination

if (!empty($propertiesOnPage)) {
    echo '<div class="col-md-12 clear">';
    echo '<div id="list-type" class="proerty-th-list">';

    foreach ($propertiesOnPage as $property) {
        echo '<div class="col-sm-6 col-md-4 p0">';
        echo '<div class="box-two proerty-item">';
        echo '<form action="property.php" method="post">';
        echo '<div class="item-thumb">';
        // Afficher l'image de la colonne 'ImageURL'
        $imageURLs = explode(' ', $property['ImageURL']);
        $firstImageURL = $imageURLs[0];
        echo '<input type="hidden" name="property" value="' . htmlspecialchars(json_encode($property)) . '">';
        echo '<button type="submit"><img src="' . $firstImageURL . '"></button>';
        echo '</div>';
        echo '</form>';
        

        echo '<div class="item-entry overflow">';
        echo '<h5><form action="property.php" method="post"><button type="submit" name="property_id" value="' . $property['ID'] . '">' . $property['ID'] . '</button></form></h5>';
        echo '<div class="dot-hr"></div>';
        // Afficher la surface de la colonne 'Surface'
        echo '<span class="pull-left"><b>Surface :</b> ' . $property['Surface'] . ' m²</span>';
        // Afficher le prix de la colonne 'Prix'
        echo '<span class="proerty-price pull-right"> $ ' . $property['Prix'] . '</span>';
        // Afficher la description de la colonne 'Description'
        echo '<p>' . $property['Description'] . '</p>';
        echo '<div class="property-icon">';
        // Afficher le nombre de chambres de la colonne 'Nombre_de_chambres'
        echo '<img src="assets/img/icon/bed.png">(' . $property['Nombre_de_chambres'] . ')|';
        // Afficher le nombre de salles de bain de la colonne 'Nombre_de_salles_de_bain'
        echo '<img src="assets/img/icon/shawer.png">(' . $property['Nombre_de_salles_de_bain'] . ')|';
        // Afficher le nombre de garages de la colonne 'Garage'
        echo '<img src="assets/img/icon/cars.png">(' . $property['Garage'] . ')';

        // Afficher l'arrondissement de la colonne 'Arrondissement'
        echo '<p><b>Arrondissement :</b> ' . $property['Arrondissement'] . '</p>';
        // Afficher le nombre de pièces de la colonne 'Nombre_de_pieces'
        echo '<p><b>Nombre de pièces :</b> ' . $property['Nombre_de_pieces'] . '</p>';

        echo '</div>';
        echo '</div>';

        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
    // ...
// Afficher la pagination
echo '<div class="col-md-12">';
echo '<div class="pull-right">';
echo '<div class="pagination">';
echo '<ul>';
$prevPage = max($pageNumber - 1, 1);
$nextPage = min($pageNumber + 1, $totalPages);

// Générer le lien pour la page précédente
echo '<li><a href="#" class="ajax-pagination" data-page="' . $prevPage . '">Prev</a></li>';
// Afficher le lien pour la première page si nécessaire
if ($pageNumber > 5) {
    echo '<li><a href="#" class="ajax-pagination" data-page="1">1</a></li>';
}
// Générer les liens pour les dernières pages
if ($pageNumber - 5 > 1) {
    echo '<li class="disabled"><span>...</span></li>';
}
// Générer les liens pour les premières pages
for ($i = max(1, $pageNumber - 4); $i <= min($pageNumber + 4, $totalPages); $i++) {
    echo '<li ' . ($pageNumber == $i ? 'class="active"' : '') . '><a href="#" class="ajax-pagination" data-page="' . $i . '">' . $i . '</a></li>';
}

// Afficher les ellipses si nécessaire pour les pages suivantes
if ($pageNumber + 5 < $totalPages) {
    echo '<li class="disabled"><span>...</span></li>';
}


// Afficher le lien pour la dernière page
if ($pageNumber < $totalPages-4) {
echo '<li ' . ($pageNumber == $totalPages ? 'class="active"' : '') . '><a href="#" class="ajax-pagination" data-page="' . $totalPages . '">' . $totalPages . '</a></li>';
}

// Générer le lien pour la page suivante
echo '<li><a href="#" class="ajax-pagination" data-page="' . $nextPage . '">Next</a></li>';

echo '</ul>';
echo '</div>';
echo '</div>';
echo '</div>';
    // ...

} else {
 echo "Aucun résultat trouvé.";
}





?>