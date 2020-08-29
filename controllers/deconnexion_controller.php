<?php

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

