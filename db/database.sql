-- ============================================================
-- base de données : mvc_db
-- type : MySQL V5.0 (non en vrai je sais pas)
-- date de création : aout 2020
-- auteurs : Vincent Viannay
-- ============================================================
START TRANSACTION;

-- ============================================================================
--   mot de passe par défaut
-- ============================================================================
SET @defautMotDePasse = "1xxxxxX!";

-- ============================================================
--   Suppression et création de la base de données
-- ============================================================

DROP DATABASE IF EXISTS mvc_db;
CREATE DATABASE mvc_db;
USE mvc_db;

CREATE TABLE user (
   id_user              BIGINT UNSIGNED AUTO_INCREMENT,
   pseudo_user          VARCHAR(40) NOT NULL,
   password_user        VARCHAR(130) NOT NULL,
   grain_de_sel_user    VARCHAR(20) NOT NULL,
   CONSTRAINT PK_user PRIMARY KEY (id_user)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE rsa (
	numKeyRsa							TINYINT UNSIGNED AUTO_INCREMENT							COMMENT "Le numéro du couple de clés",
	tailleKeyRsa						SMALLINT UNSIGNED NOT NULL								COMMENT "Le nombre de bits de la clé : 128, 256, 512, 1024, 2048 ou 4096",
	privateKeyRsa						VARCHAR(3300) NOT NULL									COMMENT "La clé privée RSA",
  	publicKeyRsa						VARCHAR(850) NOT NULL									COMMENT "La clé publique RSA",
	CONSTRAINT PK_RSA					PRIMARY KEY (numKeyRsa)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

-- ============================================================================
--   autorisation de création des routines
-- ============================================================================
SET GLOBAL log_bin_trust_function_creators = 1;

-- ============================================================================
--   modification du délimiter
-- ============================================================================
DELIMITER //

-- ============================================================================
--   fonction
-- ============================================================================
CREATE FUNCTION getMotDePasseHache(ppassword_user VARCHAR(40), ppgrain_de_sel_user VARCHAR(20)) RETURNS VARCHAR(128)
BEGIN
	RETURN SHA2(CONCAT(MD5(CONCAT(ppgrain_de_sel_user, ppassword_user)), ppgrain_de_sel_user, MD5(CONCAT(ppassword_user, ppgrain_de_sel_user))), 512);
END //

CREATE FUNCTION getUnCaractereAleatoire() RETURNS VARCHAR(1)
BEGIN
	DECLARE vChaine VARCHAR(62);
	SET vChaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	RETURN SUBSTR(vChaine, CEILING(RAND() * LENGTH(vChaine)), 1);
END //

-- ============================================================================
--   fonction renvoyant un grain de sel aléatoire
-- ============================================================================
CREATE FUNCTION getGrainDeSel() RETURNS VARCHAR(20)
BEGIN
	DECLARE vGrainDeSel VARCHAR(20);
	SET vGrainDeSel = "";
	WHILE LENGTH(vGrainDeSel) < 20 DO
       	SET vGrainDeSel = CONCAT(vGrainDeSel, getUnCaractereAleatoire());
	END WHILE;
	RETURN vGrainDeSel;
END //


CREATE PROCEDURE ajoutUser(IN ppseudo_user VARCHAR(40),
						   IN ppassword_user VARCHAR(120))
BEGIN
	-- génération du grain de sel aléatoire
	DECLARE vGrainDeSel VARCHAR(20);
	SET vGrainDeSel = getGrainDeSel();

	-- insertion de l'utilisateur
    INSERT INTO user (pseudo_user, password_user, grain_de_sel_user) VALUES (ppseudo_user,
	                         getMotDePasseHache(ppassword_user, vGrainDeSel),
							 vGrainDeSel);
END //


DELIMITER ;

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
--   insertion des couples de clés rsa (privées/publiques)
-- ===============================================================================================================
INSERT INTO rsa VALUES (null, 128,
"-----BEGIN RSA PRIVATE KEY-----
MGMCAQACEQDUEldEH3h7oYz3vYD0UnhNAgMBAAECECTcNzzI94kNPy18A5HMfoUC
CQD3acyef1lu2wIJANtuimcI2Xn3AgkAp4Xstbk2/hcCCQDHXosfjHnUBwIIck7+
Lu6dX/s=
-----END RSA PRIVATE KEY-----",
"-----BEGIN PUBLIC KEY-----
MCwwDQYJKoZIhvcNAQEBBQADGwAwGAIRANQSV0QfeHuhjPe9gPRSeE0CAwEAAQ==
-----END PUBLIC KEY-----");

INSERT INTO rsa VALUES (null, 128,
"-----BEGIN RSA PRIVATE KEY-----
MGMCAQACEQCMmuuM6gjAo5my9NdinDQTAgMBAAECEATlun5tTzVVqdNbU40mmckC
CQDG2aJp6UN8SwIJALUD68+31zpZAghjPEVDWbfmFQIJAKfLILYFxj7RAgkAokfS
gAIfGoY=
-----END RSA PRIVATE KEY-----",
"-----BEGIN PUBLIC KEY-----
MCwwDQYJKoZIhvcNAQEBBQADGwAwGAIRAIya64zqCMCjmbL012KcNBMCAwEAAQ==
-----END PUBLIC KEY-----");

INSERT INTO rsa VALUES (null, 256,
"-----BEGIN RSA PRIVATE KEY-----
MIGqAgEAAiEAlmj5JG8CQ5m9iqJZmMiz+FtO9xUbbhZaoTNUuITTr/MCAwEAAQIg
DQrWNm66eLJ/SThcYjoJF5OTsahQBwM4DFOu0fhiob0CEQDf3QKk1J3qjGfjlgS5
B6d/AhEArACNE2T5H6W7MHmbXQMRjQIQCzGU6UMMZmcA5ttgfxQH5wIRAJUESTVT
Vs6HXHzr7qGPxgUCEGSOeBjBaD5W9h5TCoVTg+c=
-----END RSA PRIVATE KEY-----",
"-----BEGIN PUBLIC KEY-----
MDwwDQYJKoZIhvcNAQEBBQADKwAwKAIhAJZo+SRvAkOZvYqiWZjIs/hbTvcVG24W
WqEzVLiE06/zAgMBAAE=
-----END PUBLIC KEY-----");

INSERT INTO rsa VALUES (null, 512,
"-----BEGIN RSA PRIVATE KEY-----
MIIBOwIBAAJBAKdoaos0Pcl+yz5pIr6KcucJ1jYr3F7YTZbfP7wbJ3uLTylgaW8n
wJORR49Z+Sd7OesXwSXA8P8N3la6iceBgcsCAwEAAQJAOwSoPyAxQjaVr5CAI72K
iaIhp2JqI/PM0sos3YOTNU3QjaND4/ipmdtu0Nj1GHcqy1o/2JwXqDPoncb4g83g
2QIhAPoAcuL+ZpDzNbzp0O9SQqb+u+9fmCrHOCu5OSSG0tHZAiEAq2ypllZ3bjv3
TbmkhIYLl2ZAEprxKneu3S7TUB1FhkMCIQDVtYKARsa4zB844YtouaIejQ1soAQ9
NVXwEoMllVcsaQIgYUJaiYhvZGSzcC7Wr7XZ18FUsvmjwMN8u9M4YyjobD8CIQDI
0dPQsu7XgV3NiVgoRTSUMhiXaMkjMfzhBQbHjEHWiQ==
-----END RSA PRIVATE KEY-----",
"-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAKdoaos0Pcl+yz5pIr6KcucJ1jYr3F7Y
TZbfP7wbJ3uLTylgaW8nwJORR49Z+Sd7OesXwSXA8P8N3la6iceBgcsCAwEAAQ==
-----END PUBLIC KEY-----");

INSERT INTO rsa VALUES (null, 512,
"-----BEGIN RSA PRIVATE KEY-----
MIIBOgIBAAJBALjDC3tqISRmbHmgE6gJki+vssIEWoLNWJEw+4E0AvQOaWoWiif3
S9SgiMIFUinVEhlD1B6lg/tVIJfy/JyKB6kCAwEAAQJAYgjsEMIRb9UA/dAYXfMm
JDNf8F6LABihQ/jvmnDUmFYebv/I6afmS9KhLLNzwbkmF88I7chbf58NMewNKWeU
OQIhAN7j08GU9JlKZibER7B9jslt1SzT+DBc9jW1lDPUIX/XAiEA1DVDtjQJfEGE
ETjhigSjohRM6osVYkiWNqjhRaDtxH8CIB79XjvUEg4eIgXR1IXdbzTiaHlLH37Z
7gGZtXlfTSkRAiEAm+IcwWVsalh+OWB9XTOXOGKNNeXBaZdEsRZRlSJoRuUCIAbe
tRAQ0yMNCDCp6KPLF10ONPC1YJLc3Z45JQQ4qf1n
-----END RSA PRIVATE KEY-----",
"-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBALjDC3tqISRmbHmgE6gJki+vssIEWoLN
WJEw+4E0AvQOaWoWiif3S9SgiMIFUinVEhlD1B6lg/tVIJfy/JyKB6kCAwEAAQ==
-----END PUBLIC KEY-----");

INSERT INTO rsa VALUES (null, 1024,
"-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCPOQoG5EXP776sxUGp97FGZK8x0yH95Veh8nOspeWV2sqi1yY6
Yp8dmjd7dUxD8cn7fVKG9+B6lvL17aU4t4cfogLzLgq0B8BFT6ZOM7KNgv83+/td
AyDzhZOjiVF8iR0S3NaBmFmpLRw2rfU0amOglYb0uDUnJSbkN/AkAAzzBwIDAQAB
AoGAMDBGXeQ/UwO82X+zJL94r5Ef2zlJJhacwhoD7pKQ6TdI17phG+Lj239wbIMe
anv3dD0J3+yV5FlWnQVdAnTJqworeNqm3YWGUBU+O7C2vePGrMRMuR9rkXbGZHSh
saBsTw5hUNID/b5QMk7STjXUG8P3IMLaVpQijQL25J2gbq0CQQCkbSEnmsfYxgGn
KjqTy6GDQuz3/5sX6DnP4qOkygxUASzVGesTJMlUl4zISsFCt1nLqmGaXbkNQGNs
i4ZB9WmdAkEA3vzZvQVHkJmMXn+Dj283/XoHs+ZVKcXC9ukfwtX/jR3+jbVdSVHs
uSTHEndlTw+ep+GX3vfMeY9P/LHdxReP8wJBAJRPHs2jTclYaFtIusdesBM+hZH3
ywPYYnUBX0ufN1l6Kd8ZXrDIyJR1kfWDgChWSzdqOllLWkP6pPNeMj5CRv0CQHY4
5E/8zpZxciRfwqZ3Nt4ippbQlXJSMS2rJ3Wq85QjxOPotg67aqA2SX0W5BVomJs1
VcmW40fHnYbB3mwyM9UCQG8w49SPi4FDsLmBex0AaJmBCr+0Z/ZzSoArVUA2hOWx
rMuyRfT3OyevT71SdtdotMYSETCZXVBaIrkubOSM2ek=
-----END RSA PRIVATE KEY-----",
"-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCPOQoG5EXP776sxUGp97FGZK8x
0yH95Veh8nOspeWV2sqi1yY6Yp8dmjd7dUxD8cn7fVKG9+B6lvL17aU4t4cfogLz
Lgq0B8BFT6ZOM7KNgv83+/tdAyDzhZOjiVF8iR0S3NaBmFmpLRw2rfU0amOglYb0
uDUnJSbkN/AkAAzzBwIDAQAB
-----END PUBLIC KEY-----");

INSERT INTO rsa VALUES (null, 2048,
"-----BEGIN RSA PRIVATE KEY-----
MIIEpgIBAAKCAQEAwWUJqw3C5KFmy65U7CnM9pxcOR+EYFTmKQb04QN4XOI/g1vx
EM8G5sh9ZkOCr+CL9UyIKXwE4BqSETPhEWhqBXjW4/OVFWpfR/oCDvFfjMfABzRc
QpwYPCi16TgfVPrehkBJw5sTYJG9Ylr3DFBneij09awjlVOeArAhdaeEF1q1WWq9
tGns9LlPKerQ4RFZmbFKo1ZBGxnoY1+mVOMmObIaTNj+Nu8ig33vZQFX/Q+gulyl
7eORacVYzGUtelndDYuAVhTgCDq1BQu29SYo/U3Z8TYgN/xGIxuaHJdEL5A5kclg
z1htvj1HiegsjVDChyQeoSEqK9L6XV1EVFx6JQIDAQABAoIBAQCx2KSndSRA9Fx/
+nWGKHqgXvJAZcdqfyiZmhgfxP0vDbCysB5kAr6qBL2tCXBpJOoQTqz42V/yZvzk
bP0Q8SBun82eGyaCZyvwGO1DqJzh7d+dwH0HlFyFFjsTmdTWZU21z/EFvNp4+A1d
IaIG5PoD0R5TvlWKwTaR6j8a304N2nOr17tafmNc1H/QQB/4ux2+Ond2sKegOWCT
PNLCm5wQWeQoYFq4APsN2G5jyJt01GHQLCHdGKvaW6sJByrdsRQJdJukL3V/o7L7
ay5XTvFjD3shsgRsFXJl/sgo4wkAw9ns16bfaBTLFicdTb8tQ80QNz8NA3mXZmL1
blwqQxWRAoGBAP/BXnODtqCw3cLdhjektyDJB5d7xujmDWiCWfyTfp3cs/HogesU
dRRPhOQMEWPFnLguOdoAOl73ShZJu5Nfry9vSs7c1LhfVL8QFV59Cg5d9Dtd6svV
pgQB2ziroP91v8dCB1n6PENNg+PtLTMYOY9BudB+84WKxFFXwa3EFHM3AoGBAMGU
ZcRCbm0pm4HP2dEmFNaNPhtnrsArh5x9JPf3ZXSwJ4LbsroRSIxhqcgHb9RrtpJI
a19efGNrMckoyfhHxwdI42jESSLJiFA/5j9yvDjbhxgsYFI7/3Eg9Sc/z6PxZ4i4
LTBPmdh/Ut/Z4GLWnzxLDgxlJSutNKzyko8rgyODAoGBALGgzoWyDAxM6qhljMtm
ph2qIZCvUfX9mYBlUDRhCEaBu6Se1GS9/5bMp8JvM0C1ReSRjnJ/SAse+yDBsvpn
MVfjlvRXYZJv+377n6vRckOKM49r6iAJ0dTkqSoR4a6rTDgK/uoaJvKjip+p4YOk
Jo39mx1Ynq+4MiNArO6PyZg/AoGBAKJqKcAypIe+YxTVGUGbm9wvgS5pHXtqiktH
zF6oGV1/9oaaYigvHBl8T4DejHtDLFkrnbrUgbTAWXMXX+2J+3knNHXQSjR/tnju
Q/Z0A2wI9B3aDa6xXC7EoiueJE6+2kkhjfh8sO2uVhAus076F3v01QKdUkSE/C8n
DsREk7CVAoGBAM3zt0qZQp/U+eBRr2ACvHm7mhsTqhGh7BCH/jBA/PkNi+Qh1vQQ
WpSun8ELXBCxDsufTuDgRdo8KJSY7egSpxB1rAbzpp82iq51znNNJeIfHnXzYE0h
yo+2DVdapj3mQsNZIGnKSNRvg6KqrrnexCDRKpDZFuC8LAkbLy1dm54x
-----END RSA PRIVATE KEY-----",
"-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwWUJqw3C5KFmy65U7CnM
9pxcOR+EYFTmKQb04QN4XOI/g1vxEM8G5sh9ZkOCr+CL9UyIKXwE4BqSETPhEWhq
BXjW4/OVFWpfR/oCDvFfjMfABzRcQpwYPCi16TgfVPrehkBJw5sTYJG9Ylr3DFBn
eij09awjlVOeArAhdaeEF1q1WWq9tGns9LlPKerQ4RFZmbFKo1ZBGxnoY1+mVOMm
ObIaTNj+Nu8ig33vZQFX/Q+gulyl7eORacVYzGUtelndDYuAVhTgCDq1BQu29SYo
/U3Z8TYgN/xGIxuaHJdEL5A5kclgz1htvj1HiegsjVDChyQeoSEqK9L6XV1EVFx6
JQIDAQAB
-----END PUBLIC KEY-----");

INSERT INTO rsa VALUES (null, 4096,
"-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----",
"-----BEGIN PUBLIC KEY-----
MIICITANBgkqhkiG9w0BAQEFAAOCAg4AMIICCQKCAgBghaDFmV3uO+obJS5JzTaQ
uapf9zAdCpvhenzqjeJBahAPD7k7XsQWCiXe2NJ0yitvLECtqGqSZM+YJirZTGtv
tlZ34vMuz/Wj7lyZploiFCi7VHAwSQIoWIXj2gNuFC9fneRh7VskdfYDkFzYNe9X
qaCC/UTQv7ARsIVXkaHs0jR0v8etKq8p6/gqqWCCy6Uq/RgB3KPlN83ROcXFMoHD
75lRitnqfC5LKwrHw7qokmNbrQ967Jl7Uxw2Gnm/+hqlDNHq8L9QwkWDbSZaPIlf
wS32N0w2xsaZmLeVM2dj9zqvVGOco2KwxrRj+Hvr6HVx6KNbORIjaksGZurXtehr
ZfDb3viE+tekcnMYzPGfg4/M99Lhxvd1//V/pJv0AnE6RAJJKGx8MS75Oh8e2+cN
7p/u3grgtfa6YYdv/Qe8phgHgBtL/NlWQara41eEcsgJPJoeyg04CPMrFEG+J0TT
lFSlFXTxt4zXfJ7sJzJ8+MmYFIV0Sy9BOhVhPxIqTyUcTVWQzTaa9PKB8API2/bn
MRtypwTy2M1Iv3C/lKS/BLn09aXS2rct9M8AH7QKksVkMN7zYp3HcOp4q4E17nBR
WczJkDh/AHQbW6K3+FdtlGa/MRi4V1kyohQEAw4V/4QKlXRITENYPqA+7rsgTxEo
wDS9+7s4MQGMuXued1/3ZQIDAQAB
-----END PUBLIC KEY-----");


-- ===============================================================================================================
--   validation de la transaction
-- ===============================================================================================================
COMMIT;
