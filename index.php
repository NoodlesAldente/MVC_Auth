<?php
    // ==========================================================================
    // 		page de réaiguillage
    // ==========================================================================
    session_start();
    $contenu = "";
    $link_controleur = "./controllers/";
    $link_view = "./views/";
    $link_model = "./models/";

    // ==========================================================================
    // 		on regarde si $_get existe si oui on fait afficher le code pour cela et puis on fait la redirection
    // ==========================================================================
    if (!empty($_GET['home'])) {
        $titre = "home";
        require_once $link_controleur . 'home_controller.php'; 	// Inclusion du controlleur de la page home
        require_once $link_model . 'home_model.php'; // Inclusion du model de la page home

        $controller = new homeControlleur();
        $controller->setDonnees();

        require_once $link_view . 'home.php'; // Inclusion de la vue de la page home

    } else {
        header("location:./index.php?home=1");
        exit() ;

    }

?>