<?php
/*======= C O N T R O L E U R ====================================================================================
	fichier				: ./mvc/controleur/film/accueil.inc.php
	auteur				: Thomas GRAULLE
	date de création	: semptembre 2018
	date de modification:
	rôle				: le contrôleur de la page d'accueil de des films
  ================================================================================================================*/


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
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $_SESSION['content']['connected'] = "Le formulaire a été mal remplie !";
            } else if (!$this->db->userExist($_POST['username'])) { // Si l'utilisateur n'existe pas
                $_SESSION['content']['connected'] = "L'utilisateur ou le mot de passe ne correspond pas";
            } else {
                $user = $_POST['username'];
                $password = $_POST['password'];

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

