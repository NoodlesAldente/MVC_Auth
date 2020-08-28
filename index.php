<?php
    // ==========================================================================
    // Session, permet de
    // ==========================================================================
    session_start();
    if (empty($_SESSION['fingerPrint'])) {
        $_SESSION['fingerPrint'] = md5(rand(1,1000000000));
    }
    if (isset($_SESSION['content'])) {
        $_SESSION['content'] = [];
    }
    // ==========================================================================
    // Variable par défaut
    // ==========================================================================
    $contenu = "";
    $link_controleur = "./controllers/";
    $link_view = "./views/";
    $link_model = "./models/";
    $link_template = "./template/";


    // ==========================================================================
    // Require des fichiers de bases
    // ==========================================================================
    require_once $link_controleur . "controller.php";
    require_once $link_model . "model.php";

    // ==========================================================================
    // on regarde si $_get existe si oui on fait afficher le code pour cela et puis on fait la redirection
    // ==========================================================================
    if (!empty($_GET['action']) && $_GET['action'] == "home") {
        $page = "home";
        $total_link_view = $link_view . $page . '_view.php';

        require_once $link_controleur . $page . '_controller.php'; 	// Inclusion du controlleur de la page home
        require_once $link_model . $page . '_model.php'; // Inclusion du model de la page home

        $controller = new home_controller();
        $controller->setDonnees();
        require_once $link_template . 'template.php';

    } else if (!empty($_GET['action']) && $_GET['action'] == "connexion") {
        $page = "connexion";
        $total_link_view = $link_view . $page . '_view.php';

        require_once $link_controleur . $page . '_controller.php';
        require_once $link_model . $page . '_model.php';

        $controller = new connexion_controller();
        $controller->setDonnees();
        require_once $link_template . 'template.php';

    } else if (!empty($_GET['action']) && $_GET['action'] == "deconnexion") {
        $page = "deconnexion";
        $total_link_view = $link_view . $page . '_view.php';

        require_once $link_controleur . $page . '_controller.php';
        require_once $link_model . $page . '_model.php';

        $controller = new deconnexion_controller();
        $controller->setDonnees();
        require_once $link_template . 'template.php';

    } else {
        header("location:./index.php?action=home");
        exit() ;

    }

?>