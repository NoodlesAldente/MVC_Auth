<?php
    // ==========================================================================
    // Session, permet de
    // ==========================================================================
    session_start();
    if (isset($_SESSION['fingerPrint'])) {
        $_SESSION['fingerPrint'] = md5(rand(1000000));
    }

    // ==========================================================================
    // Variable par défaut
    // ==========================================================================
    $contenu = "";
    $link_controleur = "./controllers/";
    $link_view = "./views/";
    $link_model = "./models/";

    // ==========================================================================
    // Require des fichiers de bases
    // ==========================================================================
    require_once $link_controleur . "controller.php";
    require_once $link_model . "model.php";

    // ==========================================================================
    // on regarde si $_get existe si oui on fait afficher le code pour cela et puis on fait la redirection
    // ==========================================================================
    if (!empty($_GET['home'])) {
        $titre = "home";
        require_once $link_controleur . 'home_controller.php'; 	// Inclusion du controlleur de la page home
        require_once $link_model . 'home_model.php'; // Inclusion du model de la page home

        $controller = new home_controller();
        $controller->setDonnees();

        require_once $link_view . 'home_view.php'; // Inclusion de la vue de la page home

    } else if (!empty($_GET['connexion'])) {
//        $titre = "home";
//        require_once $link_controleur . 'home_controller.php'; 	// Inclusion du controlleur de la page home
//        require_once $link_model . 'home_model.php'; // Inclusion du model de la page home
//
//        $controller = new homeControlleur();
//        $controller->setDonnees();
//
//        require_once $link_view . 'home_view.php'; // Inclusion de la vue de la page home
        echo "page de connexion";
    } else {
        header("location:./index.php?home=1");
        exit() ;

    }

?>