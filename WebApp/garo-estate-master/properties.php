<?php
// Informations de connexion à la base de données
$serveur = "localhost:5000"; // Nom du conteneur Docker ou adresse IP du conteneur
$utilisateur = "root"; // Nom d'utilisateur de la base de données
$motDePasse = "root"; // Mot de passe de la base de données
$nomDeLaBase = "siteimmo"; // Nom de la base de données
// Récupérer la valeur de l'arrondissement
$arrondissement = isset($_GET['arrondissement']) ? $_GET['arrondissement'] : '';

// Récupérer la valeur du nombre_de_piece
$nombre_de_piece = isset($_GET['nombre_de_piece']) ? $_GET['nombre_de_piece'] : '';
// Simuler 22 résultats
$result = [];
// Initialisation des données de test
/*for ($i = 1; $i <= 22; $i++) {
    $result[] = [
        'ID' => $i,
        'image' => 'https://picsum.photos/200/300?random=' . $i, // Exemple de URL d'image de Lorem Picsum
        'Surface' => rand(80, 200),
        'Prix' => rand(100000, 500000),
        'Description' => 'Description de la propriété ' . $i,
        'nb_chambre' => rand(1, 5),
        'douche' => rand(1, 3),
        'Garages' => rand(0, 2),
        // Ajoutez d'autres champs simulés au besoin
    ];
}*/
// Connexion à la base de données avec PDO
try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Paramètres supplémentaires pour afficher les erreurs PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sélectionner la base de données "siteimmo"
    $connexion->query("USE $nomDeLaBase");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérez les données du formulaire en utilisant la superglobale $_POST
        if (empty($arrondissement)) {
        $arrondissement = isset($_POST["arrondissement"]) ? $_POST["arrondissement"] : "";
        }
        if (empty($nombre_de_piece)) {
        $nombre_de_piece = isset($_POST["nombre_de_piece"]) ? $_POST["nombre_de_piece"] : "";
        }
        /*$prix = isset($_POST["prix"]) ? $_POST["prix"] : "";
        $surface = isset($_POST["surface"]) ? $_POST["surface"] : "";

        // Vérifiez si les cases à cocher sont cochées
        $type_appartement = isset($_POST["type_appartement"]) ? "Appartement" : null;
        $type_maison = isset($_POST["type_maison"]) ? "Maison" : null;*/

        $sql = "SELECT * FROM Paris WHERE 1=1 ";

        if (!empty($arrondissement)) {
            $sql .= "AND Arrondissement = :arrondissement ";
        }
        
        if (!empty($nombre_de_piece)) {
            $sql .= "AND Nombre_de_pieces >= :nombre_de_piece ";
        }
        
        /*if (!empty($prix)) {
            $sql .= "AND nom_colonne_prix = :prix ";
        }
        
        if (!empty($surface)) {
            $sql .= "AND nom_colonne_surface = :surface ";
        }
        
        if (!empty($type_appartement) || !empty($type_maison)) {
            $sql .= "AND (nom_colonne_type = :type_appartement OR nom_colonne_type = :type_maison) ";
        }*/
        
        // Exécution de la requête SQL
        $stmt = $connexion->prepare($sql);
        
        if (!empty($arrondissement)) {
            $stmt->bindParam(':arrondissement', $arrondissement);
        }
        
        if (!empty($nombre_de_piece)) {
            $stmt->bindParam(':nombre_de_piece', $nombre_de_piece);
        }
        /*$stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':surface', $surface);
        $stmt->bindParam(':type_appartement', $type_appartement);
        $stmt->bindParam(':type_maison', $type_maison);*/
        
        $stmt->execute();
        
        // Affichage des résultats
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        /*echo '<pre>';
        print_r($result);
        echo '</pre>';*/
    }
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
                    <a class="navbar-brand" href="index.html"><img src="assets/img/logo2.png" alt=""></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse yamm" id="navigation">
                    <div class="button navbar-right">
                        <button class="navbar-btn nav-button wow bounceInRight login" onclick=" window.open('register.html')" data-wow-delay="0.4s">Se connecter</button>
                        
                    </div>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- End of nav bar -->

        <div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">List Layout With Sidebar</h1>               
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
            <input type="text" class="form-control" name="arrondissement" placeholder="Arrondissement" value="<?php echo isset($arrondissement) ? htmlspecialchars($arrondissement) : ''; ?>">
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
                <input type="text" class="span2" name="prix" value="" data-slider-min="0"
                    data-slider-max="600" data-slider-step="5"
                    data-slider-value="[0,450]" id="price-range" ><br />
                <b class="pull-left color">0€</b>
                <b class="pull-right color">20,000,000€</b>
            </div>
        </div>
    </fieldset>

    <fieldset class="padding-5">
        <div class="row">
            <div class="col-xs-12">
                <label for="min-baths">Surface</label>
                <input type="text" class="span2" name="surface" value="" data-slider-min="0"
                    data-slider-max="600" data-slider-step="5"
                    data-slider-value="[250,450]" id="min-baths" ><br />
                <b class="pull-left color">1m²</b>
                <b class="pull-right color">120m²</b>
            </div>
        </div>
    </fieldset>

    <fieldset class="padding-5">
        <div class="row">
            <div class="col-xs-6">
                <div class="checkbox">
                    <label> <input type="checkbox" name="type_appartement" checked> Appartement</label>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="checkbox">
                    <label> <input type="checkbox" name="type_maison" checked> Maison</label>
                </div>
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

                        <div class="panel panel-default sidebar-menu wow fadeInRight animated">
                            <div class="panel-heading">
                                <h3 class="panel-title">Recommendé</h3>
                            </div>
                            <div class="panel-body recent-property-widget">
                                        <ul>
                                        <li>
                                            <div class="col-md-3 col-sm-3 col-xs-3 blg-thumb p0">
                                                <a href="single.html"></a>
                                                <span class="property-seeker">
                                                    <b class="b-1">A</b>
                                                    <b class="b-2">S</b>
                                                </span>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 blg-entry">
                                                <h6> <a href="single.html"></a></h6>
                                                <span class="property-price">200€</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col-md-3 col-sm-3  col-xs-3 blg-thumb p0">
                                                <a href="single.html"><img src="assets/img/demo/small-property-1.jpg"></a>
                                                <span class="property-seeker">
                                                    <b class="b-1">A</b>
                                                    <b class="b-2">S</b>
                                                </span>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 blg-entry">
                                                <h6> <a href="single.html"></a></h6>
                                                <span class="property-price">300000€</span>
                                            </div>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9  pr0 padding-top-40 properties-page">
                    <div class="col-md-12 clear"> 
                        <div class="col-xs-10 page-subheader sorting pl0">
                            <ul class="sort-by-list">
                                <li class="active">
                                    <a href="javascript:void(0);" class="order_by_date" data-orderby="property_date" data-order="ASC">
                                        Property Date <i class="fa fa-sort-amount-asc"></i>					
                                    </a>
                                </li>
                                <li class="">
                                    <a href="javascript:void(0);" class="order_by_price" data-orderby="property_price" data-order="DESC">
                                        Property Price <i class="fa fa-sort-numeric-desc"></i>						
                                    </a>
                                </li>
                            </ul><!--/ .sort-by-list-->


                        </div>

                        <div class="col-xs-2 layout-switcher">
                            <a class="layout-list active" href="javascript:void(0);"> <i class="fa fa-th-list"></i>  </a>
                            <a class="layout-grid" href="javascript:void(0);"> <i class="fa fa-th"></i> </a>                          
                        </div><!--/ .layout-switcher-->
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
    </body>
</html>