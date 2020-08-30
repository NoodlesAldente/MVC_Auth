<?php


/**
 * Class connexion_controller
 */
class connexion_controller extends controller {

    public function __construct() {
        $this->db = new connexion_model();
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
        // Teste de la connexion via les informations récupéré
        // ===============================================================================================================
        // Récupération de la clef privé pour le déchiffrement
        $this->privateKey = $this->dbRsa->getPrivateKeyRsa($this->rsaKeyType);
        $this->checkConnexion();
    }

    /**
     * checkConnexion, verrifie que la connexion ce soit bien faite ou non
     */
    function checkConnexion() {
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
                $user = $clearDatas[0];
                $password = $clearDatas[1];

                if (!$this->db->userExist($user)) { // Si l'utilisateur n'existe pas
                    $_SESSION['content']['connected'] = "L'utilisateur ou le mot de passe ne correspond pas";
                } else {
                    $grainSel = $this->db->getGrainSel($user);
                    $passwordHashed = $this->hashPassword($password, $grainSel);
                    $user = $this->db->getUserIfCorrectCredential($user, $passwordHashed); // Return false if the password is wrong

                    if ($user) {
                        $_SESSION['user'] = $user;
                    } else {
                        $_SESSION['content']['connected'] = "L'utilisateur ou le mot de passe ne correspond pas";
                    }
                }
            }
        }
        sleep(2);
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

