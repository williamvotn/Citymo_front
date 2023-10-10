<?php
// Chemin vers le fichier CSV
$csvFile = './Data/paris.csv';

// Récupération des données du formulaire
$codePostal = $_POST['code_postal'];
$nomVoie = $_POST['nom_voie'];
$numeroVoie = $_POST['numero_voie'];
$valeurFonciere = $_POST['valeur_fonciere'];
$surfaceReelle = $_POST['surface_reelle'];
$types = [];
if (isset($_POST['type_appartement'])) {
    $types[] = 'Appartement';
}
if (isset($_POST['type_maison'])) {
    $types[] = 'Maison';
}
$nombrePieces = $_POST['nombre_pieces'];

// Lecture du fichier CSV et création d'un tableau de données
$rows = array_map('str_getcsv', file($csvFile));
$header = array_shift($rows);

// Index des colonnes du CSV
$indexCodePostal = array_search('code_postal', $header);
$indexNomVoie = array_search('adresse_nom_voie', $header);
$indexNumeroVoie = array_search('adresse_numero', $header);
$indexValeurFonciere = array_search('valeur_fonciere', $header);
$indexSurfaceReelle = array_search('surface_reelle_bati', $header);
$indexTypeLocal = array_search('type_local', $header);
$indexNombrePieces = array_search('nombre_pieces_principales', $header);

// Afficher les lignes filtrées directement sur la page
echo '<table border="1">';
echo '<tr>';
echo '<th>Numéro</th>'; // Colonne pour les numéros de résultat
foreach ($header as $columnName) {
    echo '<th>' . $columnName . '</th>';
}
echo '</tr>';

$numeroResultat = 1; // Initialise le numéro de résultat

foreach ($rows as $row) {
    if (
        (!$codePostal || $row[$indexCodePostal] == $codePostal) &&
        (!$nomVoie || $row[$indexNomVoie] == $nomVoie) &&
        (!$numeroVoie || $row[$indexNumeroVoie] == $numeroVoie) &&
        (!$valeurFonciere || ($row[$indexValeurFonciere] >= $valeurFonciere[0] && $row[$indexValeurFonciere] <= $valeurFonciere[1])) &&
        (!$surfaceReelle || ($row[$indexSurfaceReelle] >= $surfaceReelle[0] && $row[$indexSurfaceReelle] <= $surfaceReelle[1])) &&
        (empty($types) || in_array($row[$indexTypeLocal], $types)) &&
        (!$nombrePieces || $row[$indexNombrePieces] == $nombrePieces)
    ) {
        echo '<tr>';
        echo '<td>' . $numeroResultat . '</td>'; // Affiche le numéro de résultat
        foreach ($row as $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
        $numeroResultat++; // Incrémente le numéro de résultat
    }
}
echo '</table>';
?>
