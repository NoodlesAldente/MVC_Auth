<?php
/*======= C O N T R O L E U R ====================================================================================
	fichier				: ./mvc/controleur/film/accueil.inc.php
	auteur				: Thomas GRAULLE
	date de création	: semptembre 2018
	date de modification:
	rôle				: le contrôleur de la page d'accueil de des films
  ================================================================================================================*/


/**
 * Class deconnexion_controller
 */
class deconnexion_controller extends controller {

    public function __construct() {
        $this->db = new deconnexion_model();
    }

    /**
     *
     */
    public function setDonnees() {

        session_unset();
        session_destroy();
        session_write_close();
        // ===============================================================================================================
        // alimentation des données COMMUNES à toutes les pages
        // ===============================================================================================================
        parent::setDonnees();
    }


} // class

?>

