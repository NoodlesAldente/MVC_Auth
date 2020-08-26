-- ============================================================
-- base de données : todochange
-- type : MySQL V5.0 (non en vrai je sais pas)
-- date de création : aout 2020
-- auteurs : Vincent Viannay
-- ============================================================

START TRANSACTION;

-- ============================================================================
--   mot de passe par défaut
-- ============================================================================
SET @defautMotDePasse = "1xxxxxx!";

-- ============================================================
--   Suppression et création de la base de données
-- ============================================================

DROP DATABASE IF EXISTS todochange;
CREATE DATABASE todochange;
USE todochange;

CREATE TABLE user (
   id_user              BIGINT UNSIGNED AUTO_INCREMENT,
   pseudo_user          VARCHAR(40) NOT NULL,
   password_user        VARCHAR(120) NOT NULL,
   grain_de_sel_user    VARCHAR(20) NOT NULL,
   CONSTRAINT PK_user PRIMARY KEY (id_user)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE PROCEDURE ajoutUser(IN ppseudo_user VARCHAR(40),
						   IN ppassword_user VARCHAR(120)
BEGIN
	-- génération du grain de sel aléatoire
	DECLARE vGrainDeSel VARCHAR(20);
	SET vGrainDeSel = getGrainDeSel();

	-- insertion de l'utilisateur
    INSERT INTO user VALUES (pLoginUser,
	                         getMotDePasseHache(pMotDePasseUser, vGrainDeSel),
							 vGrainDeSel);
END //

CREATE FUNCTION getMotDePasseHache(ppassword_user VARCHAR(40), ppgrain_de_sel_user VARCHAR(20)) RETURNS VARCHAR(128)
BEGIN
	RETURN SHA2(CONCAT(MD5(CONCAT(pGrainDeSel, pMotDePasse)), pGrainDeSel, MD5(CONCAT(pMotDePasse, pGrainDeSel))), 512);
END //

CREATE FUNCTION getUnCaractereAleatoire() RETURNS VARCHAR(1)
BEGIN
	DECLARE vChaine VARCHAR(62);
	SET vChaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	RETURN SUBSTR(vChaine, CEILING(RAND() * LENGTH(vChaine)), 1);
END //

-- ===============================================================================================================
--   insertion des enregistrements relatifs aux utilisateurs
-- ===============================================================================================================
CALL ajoutUser("admin", @defautMotDePasse);
CALL ajoutUser("utilisateur1", @defautMotDePasse);
CALL ajoutUser("utilisateur2", @defautMotDePasse);
CALL ajoutUser("utilisateur3", @defautMotDePasse);
CALL ajoutUser("utilisateur4", @defautMotDePasse);
CALL ajoutUser("utilisateur5", @defautMotDePasse);
CALL ajoutUser("utilisateur6", @defautMotDePasse);
CALL ajoutUser("utilisateur7", @defautMotDePasse);
CALL ajoutUser("utilisateur8", @defautMotDePasse);
CALL ajoutUser("utilisateur9", @defautMotDePasse);

-- ===============================================================================================================
--   validation de la transaction
-- ===============================================================================================================
COMMIT;
