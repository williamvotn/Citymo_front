<?php
// Récupération de l'ID de mutation depuis l'URL
if (isset($_GET['no_id_mutation'])) {
    $noidMutation = $_GET['no_id_mutation'];
} else {
    $noidMutation = null; // Définir la valeur par défaut si elle n'est pas définie
}

$idMutation = $_GET['id_mutation'];

// Chemin vers le script Python recommandation.py
$pythonScript = '../../recommandation/recommandation.py';
$pythonCsv = './top10.csv';
putenv('PATH_TO_PYTHON=C:/Users/Guillaume/AppData/Local/Programs/Python/Python312/python.exe');

// Construire la commande en fonction de la présence ou de l'absence de no_id_mutation
if ($noidMutation !== null) {
    $command = '"' . getenv('PATH_TO_PYTHON') . '" ' . $pythonScript . ' ' . $idMutation . ' --without ' . $noidMutation . ' 2>&1';
} else {
    $command = '"' . getenv('PATH_TO_PYTHON') . '" ' . $pythonScript . ' ' . $idMutation . ' 2>&1';
}

$output = shell_exec($command);

// Lecture du fichier CSV et création d'un tableau de données
$rows = array_map('str_getcsv', file($pythonCsv));
$header = array_shift($rows);

// Affichez l'ID de mutation au-dessus du tableau
echo '<h2>ID de Mutation : ' . $idMutation . '</h2>';
$noidMutation = $idMutation;
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
    $idMutation = $row[0]; // La première colonne contient l'ID de mutation

    // Ajoutez un lien hypertexte autour de l'ID de mutation pour actualiser la page avec le nouvel ID
    echo '<td><a href="fivereco.php?id_mutation=' . $idMutation . '&no_id_mutation=' . $noidMutation . '">' . $idMutation . '</a></td>';


    // Affichez les autres colonnes de données
    for ($i = 1; $i < count($row); $i++) {
        echo '<td>' . $row[$i] . '</td>';
    }

    echo '</tr>';
    $numeroResultat++; // Incrémente le numéro de résultat
}
echo '</table>';
?>