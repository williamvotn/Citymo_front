<?php
// Récupération de l'ID de mutation depuis l'URL
$idMutation = $_GET['id_mutation'];

// Chemin vers le script Python recommandation.py
$pythonScript = '../../recommandation/recommandation.py';
$pythonCsv = '../../recommandation/top10.csv';

// Exécutez le script Python avec l'ID de mutation en tant qu'argument
$command = "python3 $pythonScript $idMutation";
// Lecture du fichier CSV et création d'un tableau de données
$rows = array_map('str_getcsv', file($pythonCsv));
$header = array_shift($rows);

// Affichez l'ID de mutation au-dessus du tableau
echo '<h2>ID de Mutation : ' . $idMutation . '</h2>';

// Affichez le tableau des résultats
echo '<table border="1">';
echo '<tr>';
echo '<th>Numéro</th>'; // Colonne pour les numéros de résultat
foreach ($header as $columnName) {
    echo '<th>' . $columnName . '</th>';
}
echo '</tr>';

$numeroResultat = 1; // Initialise le numéro de résultat

foreach ($rows as $row) {
    echo '<tr>';
    echo '<td>' . $numeroResultat . '</td>'; // Affiche le numéro de résultat
    foreach ($row as $value) {
        echo '<td>' . $value . '</td>';
    }
    echo '</tr>';
    $numeroResultat++; // Incrémente le numéro de résultat
}
echo '</table>';
?>
