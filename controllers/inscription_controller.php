<?php

/**
 * Class connexion_controller
 */
class inscription_controller extends controller {

    public function __construct() {
        $this->db = new inscription_model();
    }

    /**
     *
     */
    public function setDonnees() {
        // ===============================================================================================================
        // alimentation des données COMMUNES à toutes les pages
        // ===============================================================================================================
        parent::setDonnees();

        // ===============================================================================================================
        // Fait l'inscription
        // ===============================================================================================================
        // Récupération de la clef privé pour le déchiffrement
        $this->privateKey = $this->dbRsa->getPrivateKeyRsa($this->rsaKeyType);
        $this->inscription();
    }

    /**
     * inscription, fait l'inscription du nouvelle utilisateur une fois les vérifications faites
     *
     * @throws Exception
     */
    function inscription() {
        if ($_POST['fingerPrint'] != $_SESSION['fingerPrint']) {
            // Il y a eu un rejeu de requête
            $_SESSION['content']['connected'] = "Tentative d'usurpation d'itentié, si erreur veuillez contacter l'administrateur du site";
        } else {
            // Suppression du fingerprint pour pas qu'il soit rejoué
            unset($_SESSION['fingerPrint']);

            if (empty($_POST['username']) || empty($_POST['password'])) {
                $_SESSION['content']['connected'] = "Le formulaire a été mal remplie !";
            } else {
                // Déchiffrement des données envoyés
                $dateCrypted = array($_POST['username'], $_POST['password']);
                $clearDatas = $this->uncrypt($dateCrypted, $this->privateKey);
                $username = $clearDatas[0];
                $password = $clearDatas[1];

                if ($this->db->userExist($username)) {
                    $_SESSION['content']['connected'] = "Le nom d'utilisateur est déjà utilisé";
                } else {
                    // La création de l'utilisateur peut se faire correctement après avoir vérifier ses informations
                    if (!$this->passwordIsValid($password)) {
                        $_SESSION['content']['connected'] = "Le mot passe ne respecte pas les règles, pour les voir ...";
                    } else {
                        $userCreated = $this->db->ajoutUser($username, $password); // Return false si problème

                        if ($userCreated) {
                            $_SESSION['content']['connected'] = "L'inscription a bien été faite, vous pouvez maintenant vous connecter";
                        } else {
                            $_SESSION['content']['connected'] = "Une erreur innatendu s'est produit, veuillez contacter le gestionnaire du site";
                        }
                    }
                }
            }
        }
        sleep(2);
    }

    /**
     * passwordIsValid, renvoie true ou false si le mot de passe est valide ou non
     *
     * @param $password
     * @return bool
     */
    function passwordIsValid($password) {
        $lowerChar  = 'abcdefghijklmnopqrstuvwxyzéèàâêîïöû';
        $upperChar = strtoupper($lowerChar);
        $numberChar = '0123456789';
        $specialChar = '!*+/$%£';
        $maxLength = 39;
        $minLength = 5;

        $stringValid = $lowerChar . $upperChar . $numberChar . $specialChar;
        $size = strlen($password);

        return ($size >= $minLength && $size <= $maxLength && $this->haveCharOfThisType($lowerChar, $password)
            && $this->haveCharOfThisType($upperChar, $password) && $this->haveCharOfThisType($numberChar, $password)
            && $this->haveCharOfThisType($specialChar, $password) && $this->allCharOfThisType($stringValid, $password)
        );
    }

    /**
     * allCharOfThisType, vérifie que tout les char de la string soit de se type
     *  @example :
     *      $stringOfType = 'abcdefghijklmnopqrstuvwxyz'
     *      $stringUsed = 'stringAvecDesMajuscule'
     *      result = False;
     *
     * @param $stringOfType
     * @param $stringUsed
     * @return bool
     */
    function allCharOfThisType($stringOfType, $stringUsed) {
        $find = true;
        foreach (str_split($stringUsed, 1) as $char) { // Découpe la string en char
            if (strpos($stringOfType, $char) === false) {
                $find = false;
                break;
            }
        }

        return $find;
    }

    /**
     * haveCharOfThisType, vérifie que si il y a un type de caractère dans la chaîne de caractère donné
     *  @example :
     *      $stringOfType = '123456789'
     *      $stringUsed = 'StringSansNombre'
     *      result = False;
     *
     *
     * @param $stringOfType
     * @param $stringUsed
     * @return bool
     */
    function haveCharOfThisType($stringOfType, $stringUsed) {
        $find = false;
        foreach (str_split($stringUsed, 1) as $char) { // Découpe la string en char
            if (strpos($stringOfType, $char) !== false) {
                $find = true;
                break;
            }
        }

        return $find;
    }

    /**
     * Hash string with grain sel, this function hash 2 string with the "grain de sel" technique
     *
     * @param string $aPassword
     * @param string $grainDeSel
     *
     * @return string, return the hashed string
     */
    protected function hashPassword($aPassword, $grainDeSel) {
        return hash('sha512',
            hash('md5', $grainDeSel . $aPassword) .
            $grainDeSel .
            hash('md5', $aPassword . $grainDeSel)
        );
    }


} // class

?>

