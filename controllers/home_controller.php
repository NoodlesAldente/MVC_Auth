<?php
/*======= C O N T R O L E U R ====================================================================================
	fichier				: ./mvc/controleur/film/accueil.inc.php
	auteur				: Thomas GRAULLE
	date de création	: semptembre 2018
	date de modification:
	rôle				: le contrôleur de la page d'accueil de des films
  ================================================================================================================*/


/**
 * Class home_controlleur
 */
class home_controller extends controller {

    public function __construct() {
        $this->db = new home_model();
    }

    /**
     *
     */
    public function setDonnees() {


        // ===============================================================================================================
        // alimentation des données COMMUNES à toutes les pages
        // ===============================================================================================================
        parent::setDonnees();
    }


} // class

?>

