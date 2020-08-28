<?php

class inscription_model extends model {

    /**
     * User exist, check into the database if the user exist and return true or false
     *
     * @throws Exception
     *
     * @param string $loginUser
     *
     * @return bool, return true if the loginUserExist
     */
    public function userExist($loginUser) {
        $result = false;

        try {

            $request = "SELECT (EXISTS (SELECT 1 FROM user WHERE pseudo_user LIKE ?)) AS isExist";
            $param = array($loginUser);

            $pdoRequest = $this->executerRequete($request, $param);
            $result = $pdoRequest->fetchObject()->isExist;

        } catch (Exception $e) {
            throw new Exception(
                "[fichier] : " . __FILE__
                . "<br/>[classe] : " . __CLASS__
                . "<br/>[méthode] : " . __METHOD__
                . "<br/>[message] : \"Erreur lors de la récurération de données dans la bdd \" . " . $e->getMessage()
                . "<br/>"
            );
        }
        return $result;
    }

    /**
     * ajoutUser, Ajoute un nouvelle utilisateur à la base de données
     *      En utilisant la procédure sql pour l'ajout
     *
     * @param $loginUser
     *
     * @return bool, return true if the user is added
     *
     * @throws Exception
     */
    public function ajoutUser($loginUser, $password) {
        $result = false;
        try {
            $request = "
                CALL ajoutUser(?, ?)
    		"; // Utilisation de la procédure sql pour l'ajout d'utilisateur

            $param = array($loginUser, $password);
            $pdoRequest = $this->executerRequete($request, $param);
            $result = $this->userExist($loginUser); // Vérifie si l'utilisateur a bien été créé

        } catch (Exception $e) {
            throw new Exception(
                "[fichier] : " . __FILE__
                . "<br/>[classe] : " . __CLASS__
                . "<br/>[méthode] : " . __METHOD__
                . "<br/>[message] : \"Erreur lors de la récurération de données dans la bdd \" . " . $e->getMessage()
                . "<br/>"
            );
        }

        return $result;
    }

}

