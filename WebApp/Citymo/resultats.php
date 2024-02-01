<style>
    /* Style de base pour le bouton */
    .property-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
    }
        /* Style de la classe "property-icon" */
        .proerty-th-list .property-icon {
        background-color: #f1f1f1;
        /* Autres styles si nécessaire */
    }
  .custom-max-height {
    max-height: 640px;
  }
  .custom-max-height2 {
    max-height: 620px;
  }
  .property-icon {
    position:relative;
    bottom: 0;
    right: 0;
    background-color: #f1f1f1; /* Couleur de fond souhaitée */
    /* Autres styles si nécessaire */
  }
  .proerty-th-list .col-md-4 .item-entry{
    padding-right:0;
  }
  .proerty-th-list .proerty-price {
    padding-right:15px;
  }
  p.maximum_height{
    max-height:200px;
    overflow: auto;
  }
          /* Pour WebKit (Safari, Chrome, etc.) */
          ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #5D8AFF;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }
                /* Pour Firefox */
        body {
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }

        /* Pour Microsoft Edge et Internet Explorer */
        body {
            -ms-overflow-style: none; /* Cacher la barre de défilement originale d'IE et Edge */
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }

</style>
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
        echo '<div class="col-sm-6 col-md-4 p0 custom-max-height">';
        echo '<div class="box-two proerty-item custom-max-height2">';
        echo '<form action="appartement.php" method="post">';
        echo '<div class="item-thumb">';
        // Afficher l'image de la colonne 'ImageURL'
        $imageURLs = explode(' ', $property['ImageURL']);
        $firstImageURL = $imageURLs[0];
        echo '<input type="hidden" name="property" value="' . htmlspecialchars(json_encode($property)) . '">';
        echo '<button type="submit" class="property-button"><img src="' . $firstImageURL . '"></button>';
        echo '</div>';
        echo '</form>';
        

        echo '<div class="item-entry overflow">';
        echo '<form action="appartement.php" method="post">';
        echo '<input type="hidden" name="property" value="' . htmlspecialchars(json_encode($property)) . '">
        <h5>
        <button type="submit" class="property-button" name="property_id" value="' . $property['Arrondissement'] . '">Appartement dans le '. $property['Arrondissement'] . '</button></h5></form>';
        echo '<div class="dot-hr"></div>';
        // Afficher la surface de la colonne 'Surface'
        echo '<span class="pull-left"><b>Surface :</b> ' . $property['Surface'] . ' m²</span>';
        // Afficher le prix de la colonne 'Prix'
        echo '<span class="proerty-price pull-right"> € ' . $property['Prix'] . '</span>';
        // Afficher la description de la colonne 'Description'
        echo '<br><p class="maximum_height">' . $property['Description'] . '</p>';
        echo '<div class="property-icon">';
        // Afficher le nombre de chambres de la colonne 'Nombre_de_chambres'
        echo '<img src="assets/img/icon/bed.png">(' . $property['Nombre_de_chambres'] . ')|';
        // Afficher le nombre de salles de bain de la colonne 'Nombre_de_salles_de_bain'
        echo '<img src="assets/img/icon/shawer.png">(' . $property['Nombre_de_salles_de_bain'] . ')|';
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