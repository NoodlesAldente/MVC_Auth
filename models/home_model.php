<?php

require_once "./model.php";

class homeModel extends model {

    /**
     * Get nb film, return interger count movie
     *
     * @throws Exception
     *
     * @return integer : le nombre de films
     */
    public function getNbFilm() {
        $result = false;
        try {
            $pdoRequest = parent::executerRequete('SELECT COUNT(*) as nb FROM film;');
            $result = $pdoRequest->fetchObject();
            $result = $result->nb;
        } catch (Exception $e) {
            throw new Exception("[fichier] : " . __FILE__ . "<br/>[classe] : " . __CLASS__ . "<br/>[méthode] : "
                . __METHOD__ . "<br/>[message] : \"Erreur lors de la récurération de données dans la bdd  ''
                . " . $e->getMessage() . "<br/>"
            );
        }
        return (int) $result;
    }

}


