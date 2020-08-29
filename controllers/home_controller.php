<?php

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

