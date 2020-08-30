<?php

class rsa_model extends model {

    /**
     * Récupère la clé publique RSA
     *
     * @param integer $num : le numéro du couple de clé RSA
     * @return string : la clé publique du couple de clé RSA dont le numéro est passé en paramètre
     */
    public function getPublicKeyRsa($num) {
        $result = "";

        try {
            $request = "
            	SELECT publicKeyRsa 
	            FROM rsa 
	            WHERE numKeyRsa = ?
            ";

            $param = array($num);

            $pdoRequest = $this->executerRequete($request, $param);
            $result = $pdoRequest->fetchObject()->publicKeyRsa;

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
     * Récupère la clé privée RSA
     * @param integer $num : le numéro du couple de clé RSA
     * @return string : la clé privée du couple de clé RSA dont le numéro est passé en paramètre
     */
    public function getPrivateKeyRsa($num) {
        $result = false;

        try {

            $request = "
            	SELECT privateKeyRsa as privateKey
	            FROM rsa 
	            WHERE numKeyRsa = ?
            ";

            $param = array($num);

            $pdoRequest = $this->executerRequete($request, $param);
            $result = $pdoRequest->fetchObject()->privateKey;

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
