<?php
    // ==========================================================================
    // Session, permet de
    // ==========================================================================
    session_start();
    if (empty($_SESSION['fingerPrint'])) {
        $_SESSION['fingerPrint'] = md5(rand(1000000));
    }
    if (($_SESSION['content'] !== [] )) {
        $_SESSION['content'] = [];
    }
    if ($_GET['test'] == 1) {
        unset($_SESSION['user']);
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
    if (!empty($_GET['action'] == "home")) {
        $page = "home";
        require_once $link_controleur . $page . '_controller.php'; 	// Inclusion du controlleur de la page home
        require_once $link_model . $page . '_model.php'; // Inclusion du model de la page home

        $controller = new home_controller();
        $controller->setDonnees();

        require_once $link_view . $page . '_view.php'; // Inclusion de la vue de la page home

    } else if (!empty($_GET['action'] == "connexion")) {
        $page = "connexion";
        require_once $link_controleur . $page . '_controller.php'; 	// Inclusion du controlleur de la page home
        require_once $link_model . $page . '_model.php'; // Inclusion du model de la page home

        $controller = new connexion_controller();
        $controller->setDonnees();

        require_once $link_view . $page . '_view.php'; // Inclusion de la vue de la page home
    } else {
        header("location:./index.php?action=home");
        exit() ;

    }

?>