<?php
  // ==========================================================================
  // 		page de réaiguillage
  // ==========================================================================
  session_start();
  $contenu = "";
  $link_controleur = "./controllers/";
  $link_view = "./views/";


	
  // ==========================================================================
  // 		on regarde si $_get existe si oui on fait afficher le code pour cela et puis on fait la redirection 
  // ==========================================================================
  if (!empty($_GET['home'])) {
	$titre = "home";
	// appelle du controller dans la page home
	require_once $link_controleur.'home_controller.php';
    // envois sur la view home.php
    require_once $link_view.'home.php';
  }
/*
  } elseif (!empty($_GET['admin'])) {
	$titre = "Administration";
	$hdp = hdp("identification", False);
	include $link_controleur.'controleur_admin.php';
	require $link_view.'admin.php';

  } elseif (!empty($_GET['compte'])) {
	$titre = "Mon compte";
	$hdp = hdp("identification", False);
	include $link_controleur.'controleur_compte.php';
	require $link_view.'compte.php';


  } elseif (!empty($_GET['help'])) {
	$titre = "Besoin d'aide ?";
	$hdp = hdp("help", False);
	include $link_controleur.'controleur_help.php';
	require $link_view.'help.php';

  } elseif (!empty($_GET['identification'])) {
	$titre = "Identification";
	$hdp = hdp("identification", False);
	include $link_controleur.'controleur_identification.php';
	require $link_view.'identification.php';

  } elseif (!empty($_GET['informations'])) {
	$titre = "Information sur le compte";
	$hdp = hdp("informations", False);
	include $link_controleur.'controleur_information.php';
	require $link_view.'informations.php';


  } elseif (!empty($_GET['produit'])) {
	$titre = "Produit";
	$hdp = hdp("produit", False);
    $ancre = $_GET['produit'];
	include $link_controleur.'controleur_produit.php';
	require $link_view.'produits.php';


  } elseif (!empty($_GET['ref_produits'])) {
	$titre = "Produit : ". $_GET['ref_produits'];
	$hdp = hdp("produit", False);
	include $link_controleur.'controleur_caract_produit.php' ;
	require $link_view.'caract_produit.php';

  } elseif (!empty($_GET['deconnexion'])) {
	include './include/deconnexion.php' ;
	header("location:./?accueil=1");
	exit() ;
*/
   else {
	header("location:./?home=1");
	exit() ;
		
  }






?>