<?php
// Informations de connexion à la base de données
$serveur = "db"; // Nom du conteneur Docker ou adresse IP du conteneur
$utilisateur = "root"; // Nom d'utilisateur de la base de données
$motDePasse = "root"; // Mot de passe de la base de données
$nomDeLaBase = "siteimmo"; // Nom de la base de données

// Récupérer la valeur de l'arrondissement
$arrondissement = isset($_POST['arrondissement']) ? $_POST['arrondissement'] : '';

// Récupérer la valeur du nombre_de_piece
$nombre_de_piece = isset($_POST['nombre_de_piece']) ? $_POST['nombre_de_piece'] : '';

// Récupérer les valeurs postées
$prixRange = isset($_POST['prix']) ? $_POST['prix'] : '0,20000000';
$surfaceRange = isset($_POST['surface']) ? $_POST['surface'] : '0,1000';

// Diviser les chaînes en tableaux
$prixArray = explode(',', $prixRange);
$surfaceArray = explode(',', $surfaceRange);
// Récupérer les valeurs minimales et maximales
$prixMin = isset($prixArray[0]) ? $prixArray[0] : 0;
$prixMax = isset($prixArray[1]) ? $prixArray[1] : 20000000;

$surfaceMin = isset($surfaceArray[0]) ? $surfaceArray[0] : 0;
$surfaceMax = isset($surfaceArray[1]) ? $surfaceArray[1] : 1000;
// Simuler 22 résultats
$result = [];

// Connexion à la base de données avec PDO
try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Paramètres supplémentaires pour afficher les erreurs PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sélectionner la base de données "siteimmo"
    $connexion->query("USE $nomDeLaBase");
        // Récupérez les données du formulaire en utilisant la superglobale $_POST
        $sql = "SELECT * FROM Paris WHERE Prix BETWEEN $prixMin AND $prixMax ";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        if (!empty($arrondissement)) {
            $sql .= "AND Arrondissement = :arrondissement ";
        }
        
        if (!empty($nombre_de_piece)) {
            $sql .= "AND Nombre_de_pieces >= :nombre_de_piece ";
        }

/*        if (!empty($prixMin) && !empty($prixMax)) {
            $sql .= "AND Prix BETWEEN :prixMin AND :prixMax ";
        }*/

        if (!empty($surfaceMin) && !empty($surfaceMax)) {
            $sql .= "AND Surface BETWEEN :surfaceMin AND :surfaceMax ";
        }

    }
    
    $stmt = $connexion->prepare($sql);
        
    if (!empty($arrondissement)) {
        $stmt->bindParam(':arrondissement', $arrondissement);
    }
    
    if (!empty($nombre_de_piece)) {
        $stmt->bindParam(':nombre_de_piece', $nombre_de_piece);
    }

    if (!empty($surfaceMin) && !empty($surfaceMax)) {
        $stmt->bindParam(':surfaceMin', $surfaceMin);
        $stmt->bindParam(':surfaceMax', $surfaceMax);
    }

    $stmt->execute();
    
    // Affichage des résultats
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Properties  page</title>
        <meta name="description" content="is a real-estate template">
        <meta name="author" content="">
        <meta name="keyword" content="html5, css, bootstrap, property, real-estate theme , bootstrap template">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="assets/css/normalize.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/fontello.css">
        <link href="assets/fonts/icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet">
        <link href="assets/fonts/icon-7-stroke/css/helper.css" rel="stylesheet">
        <link href="assets/css/animate.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="assets/css/bootstrap-select.min.css"> 
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/icheck.min_all.css">
        <link rel="stylesheet" href="assets/css/price-range.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css">  
        <link rel="stylesheet" href="assets/css/owl.theme.css">
        <link rel="stylesheet" href="assets/css/owl.transitions.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <style>
                .footer-title-line {
        color: #5D8AFF; /* Remplacez #5D8AFF par la couleur de votre choix */
        background: #5D8AFF;
    }
    .footer-menu li {
    border-bottom: 1px solid #5D8AFF;
}
    </style>

    </head>
    
    <body>

        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        <!-- Body content -->
    
       
    
        <!--End top header -->

        <nav class="navbar navbar-default ">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- dimension de logo(155-145)*48-->
                    <a class="navbar-brand" href="index.php"><img src="assets/img/logo3.png" alt=""></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse yamm" id="navigation">
                    <div class="button navbar-right">
                        
                    </div>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- End of nav bar -->

        <div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Citymo</h1>               
                    </div>
                </div>
            </div>
        </div>
        <!-- End page header -->

        <!-- property area -->
        <div class="properties-area recent-property" style="background-color: #FFF;">
            <div class="container">  
                <div class="row">
                     
                <div class="col-md-3 p0 padding-top-40">
                    <div class="blog-asside-right pr0">
                        <div class="panel panel-default sidebar-menu wow fadeInRight animated" >
                            <div class="panel-heading">
                                <h3 class="panel-title">Preference</h3>
                            </div>
                            <div class="panel-body search-widget">
                            <form action="properties.php" method="post" class="form-inline">
                            <fieldset>
                            <div class="row">
    <div class="col-xs-12">
        <label for="arrondissementSelect">Arrondissement:</label>
        <select id="arrondissementSelect" name="arrondissement" class="form-control">
            <?php
            $selectedArrondissement = isset($arrondissement) ? htmlspecialchars($arrondissement) : '';

            // Générer les options pour les arrondissements de Paris (75001 à 75020)
            for ($i = 1; $i <= 20; $i++) {
                $arrondissementValue = '750' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $selected = ($arrondissementValue == $selectedArrondissement) ? 'selected' : '';
                echo "<option value=\"$arrondissementValue\" $selected>$arrondissementValue</option>";
            }
            ?>
        </select>
    </div>
</div>
</fieldset>

<fieldset>
    <div class="row">
        <div class="col-xs-12">
            <label for="lunchBegins">Nombre de pièces:</label>
            <select id="lunchBegins" name="nombre_de_piece" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Select Nombre">
                <?php
                $selectedNombreDePiece = isset($nombre_de_piece) ? htmlspecialchars($nombre_de_piece) : '';
                for ($i = 0; $i <= 9; $i++) {
                    $selected = ($i == $selectedNombreDePiece) ? 'selected' : '';
                    echo "<option $selected>$i</option>";
                }
                ?>
            </select>
        </div>
    </div>
</fieldset>


<fieldset class="padding-5">
    <div class="row">
        <div class="col-xs-12">
            <label for="price-range">Prix(€):</label>
            <input type="text" class="span2" name="prix" value="<?php echo isset($_POST['prix']) ? htmlspecialchars($_POST['prix']) : '0,20000000'; ?>" data-slider-min="0"
                data-slider-max="20000000" data-slider-step="5"
                data-slider-value="[<?php echo isset($_POST['prix']) ? htmlspecialchars($_POST['prix']) : '0,20000000'; ?>]" id="price-range"><br />
            <b class="pull-left color">0€</b>
            <b class="pull-right color">20,000,000€</b>
        </div>
    </div>
</fieldset>

<fieldset class="padding-5">
    <div class="row">
        <div class="col-xs-12">
            <label for="min-baths">Surface</label>
            <input type="text" class="span2" name="surface" value="<?php echo isset($_POST['surface']) ? htmlspecialchars($_POST['surface']) : '0,1000'; ?>" data-slider-min="0"
                data-slider-max="1000" data-slider-step="5"
                data-slider-value="[<?php echo isset($_POST['surface']) ? htmlspecialchars($_POST['surface']) : '0,1000'; ?>]" id="min-baths"><br />
            <b class="pull-left color">0m²</b>
            <b class="pull-right color">1000m²</b>
        </div>
    </div>
</fieldset>



    <fieldset>
        <div class="row">
            <div class="col-xs-12">  
                <input class="button btn largesearch-btn" value="Rechercher" type="submit">
            </div>  
        </div>
    </fieldset>
</form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9  pr0 padding-top-40 properties-page">
                    <div class="col-md-12 clear"> 
                        <!--/ .layout-switcher<div class="col-xs-2 layout-switcher">
                            <a class="layout-list active" href="javascript:void(0);"> <i class="fa fa-th-list"></i>  </a>
                            <a class="layout-grid" href="javascript:void(0);"> <i class="fa fa-th"></i> </a>                          
                        </div>-->
                    </div>
<div id="results-container"></div>

<script>
$(document).ready(function() {
    // Fonction pour charger les résultats en utilisant AJAX
    function loadResults(pageNumber) {
        $.ajax({
            url: 'resultats.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                page: pageNumber,
                result: <?php echo json_encode($result); ?>
                // Ajoutez d'autres paramètres si nécessaire
            }),
            success: function(data) {
                $('#results-container').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', status, error);
            }
        });
    }

    // Charger les résultats au chargement de la page
    loadResults(1);

    // Attacher un gestionnaire d'événement au clic sur un bouton de pagination
    $(document).on('click', '.ajax-pagination', function(e) {
        e.preventDefault();
        var pageNumber = $(this).data('page');
        loadResults(pageNumber);
    });
});


</script>
                </div> 
                </div>              
            </div>
        </div>



      <script src="assets/js/modernizr-2.6.2.min.js"></script>
        <script src="assets/js/jquery-1.10.2.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/bootstrap-select.min.js"></script>
        <script src="assets/js/bootstrap-hover-dropdown.js"></script>
        <script src="assets/js/easypiechart.min.js"></script>
        <script src="assets/js/jquery.easypiechart.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/wow.js"></script>
        <script src="assets/js/icheck.min.js"></script>
        <script src="assets/js/price-range.js"></script>
        <script src="assets/js/main.js"></script>
          <!-- Footer area-->
  <div class="footer-area">

<div class=" footer">
    <div class="container">
        <div class="row">

            <div class="col-md-3 col-sm-6 wow fadeInRight animated">
                <div class="single-footer">
                    <h4>About us </h4>
                    <div class="footer-title-line"></div>

                    <img src="assets/img/logo3.png" alt="" class="wow pulse" data-wow-delay="1s">
                    <p>Pour contacter Citymo</p>
                    <ul class="footer-adress">
                        <li><i class="pe-7s-map-marker strong"> </i> 9089 rue du Succès</li>
                        <li><i class="pe-7s-mail strong"> </i> email@Citymo.com</li>
                        <li><i class="pe-7s-call strong"> </i> +33 633333333</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 wow fadeInRight animated">
                <div class="single-footer">
                    <h4>Quick links </h4>
                    <div class="footer-title-line"></div>
                    <ul class="footer-menu">
                        <li><a href="properties.php">Properties</a>  </li> 
                        <li><a href="index.php">Services</a>  </li> 
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </body>
</html>