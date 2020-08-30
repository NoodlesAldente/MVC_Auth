<?php

/**
 * Class controller, classe générique définissant les services communs à TOUS les contrôleurs
 */
abstract class controller {
    protected $donnees = array (); // Le tableau où sont stockées les données pour la vue

    /**
     * Met à jour le tableau $donnees avec les données communes à TOUTES les pages du site web
     *
     * @throws Exception
     */
    protected function setDonnees() {
        // ===============================================================================================================
        // Encryption part
        // ===============================================================================================================
        $this->prepareTheEncryption(7); // La valeur correspond à la taille de la clef souhaité
    }

    /**
     * Prepare the encryption, this function set all the information for the encryption.
     *   If the public key is not define, I receive it
     *
     * @param $numKey: ( De 1 à 8 en fonction du numChamp dans la base de données)
     *
     */
    private function prepareTheEncryption($numKey) {
        if (empty($_SESSION['rsa'])) {
            $this->dbRsa = new rsa_model();
            $_SESSION['rsa'] = $this->dbRsa->getPublicKeyRsa($numKey);
        }
    }

    /**
     * Méthode MAGIQUE permettant de retourner la valeur de l'élément correspondant à la clé $cle dans le tableau $donnees.
     * Cette méthode se déclenche AUTOMATIQUEMENT lorsqu'on essaie de récupérer la valeur d'un attribut INEXISTANT
     *
     * @param string $cle
     *        	: La cle de l'élément
     * @throws Exception
     * @return string : La valeur de l'élément correspondant à la clé $cle dans le tableau $donnees. Déclenche une exception si non trouvé
     */
    public function __get($cle) {
        if (array_key_exists ( $cle, $this->donnees )) {
            return $this->donnees [$cle];
        } else {
            throw new Exception ( "[fichier] : " . __FILE__ . "<br/>[classe] : " . __CLASS__ . "<br/>[méthode] : " . __METHOD__ . "<br/>[message] : l 'élément dont la clé est " . $cle . " est introuvable" );
        }
    }

    /**
     * Méthode MAGIQUE permettant d'alimenter le tableau $donnees qui se déclenche AUTOMATIQUEMENT lorsqu'on fait référence à un attribut INEXISTANT
     *
     * @param string $cle
     *        	: la clé de l'élément à ajouter au tableau
     * @param string $valeur
     *        	: la valeur de l'élément à ajouter au tableau
     * @return void
     */
    public function __set($cle, $valeur) {
        if (substr ( $cle, 0, 7 ) != 'encarts') {
            $this->donnees [$cle] = $valeur;
        } else {
            if (is_array ( $valeur )) {
                $this->donnees [$cle] = $valeur; // This override the value if is not empty
            } else {
                $this->donnees [$cle] [] = $valeur; // If the rencart value is string then I add
            }
        }
    }

}