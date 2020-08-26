<?php

/**
 * Class model, ici que la connexion à la base de données est faite
 */
abstract class model {

    private static $bd = null;	// l'instance de la connexion à la base de données

    /**
     * getBd, fait la connexion avec la base de données
     * @return PDO|null
     */
    private static function getBd() {
        if (self::$bd === null) {
            // ===============================================================================================================
            // récupération des paramètres de configuration relatifs à la base de données
            // ===============================================================================================================
            $serveur 	= "127.0.0.1";
            $base 		= "cinepassion38";
            $login 		= "admin"; // Indiquer le bon user de la base de données
            $mdp 		= "admin"; // Indiquer le bon mot de passe de la base de données

            // ===============================================================================================================
            // création de la connexion à la base de données. PDO émettra une exception en cas de problème de connexion
            // ===============================================================================================================
            self::$bd = new PDO("mysql:host=" . $serveur . ";dbname=" . $base . ";charset=utf8", $login, $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return self::$bd;
    }

    /**
     * @param string $sql, la requête SQL à exécuter
     * @param null $params, paramètre si on veut faire une requête préparé
     * @return bool|PDOStatement
     */
    protected function executerRequete($sql, $params = null) {
        if ($params == null) {
            // ===============================================================================================================
            // exécution directe
            // ===============================================================================================================
            $resultat = self::getBd()->query($sql);

        }else {
            // ===============================================================================================================
            // exécution d'une requête préparée
            // ===============================================================================================================
            $resultat = self::getBd()->prepare($sql);
            $resultat->execute($params);
        }
        return $resultat;
    }

} // class

?>
