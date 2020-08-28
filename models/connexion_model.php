<?php

class connexion_model extends model {

    /**
     * Get user if correct credential, this function get the user information if the credential is right
     *
     * @author Thomas Graulle
     * @date 27/03/2019
     *
     * @throws Exception
     *
     * @param string $loginUser
     * @param string $password
     *
     * @return bool|object, return false if the login and the password is wrong
     */
    public function getUserIfCorrectCredential($loginUser, $password) {
        $result = false;

        try {
            $request = "
                SELECT id_user, pseudo_user, password_user
                FROM user 
                WHERE pseudo_user LIKE ?
                AND password_user LIKE ?
            ";
            $param = array($loginUser, $password);

            $pdoRequest = $this->executerRequete($request, $param);
            $result = $pdoRequest->fetchObject();

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
     * Get date last connexion, this function return the date of the last connexion for a user
     *
     * @param $loginUser
     *
     * @return string|bool, return the "grain de sel" or false if the connexion failed
     *
     * @throws Exception
     */
    public function getGrainSel($loginUser) {
        $result = false;
        try {
            $request = "
    				SELECT grain_de_sel_user AS sel
    				FROM user
    				WHERE pseudo_user = ?
    		";

            $param = array($loginUser);
            $pdoRequest = $this->executerRequete($request, $param);

            $result = $pdoRequest->fetchObject()->sel;

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

