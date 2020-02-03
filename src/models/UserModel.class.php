<?php
    // Modèle de gestion d'un utilisateur (interface BdD associée au contrôleur de gestion des utilisateurs)
    
    require_once MODEL_PATH."dbcModel.class.php" ;

    final class UserModel extends DBC {
        public function __construct() {
            parent::dbConnect() ;
        }

        // Obtention des informations d'un utilisateur (par identifiant)
        public function getUser($uid) {
            $sql = "SELECT id_user, pseudo, registered_at, last_visit, mail, firstname, lastname FROM user 
                    WHERE id_user = :uid" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array("uid" => $uid);
            $stmt->execute($args) ;

            return ($stmt->fetch()) ;
        }

        // Obtention des informations d'un utilisateur (par son pseudo)
        public function getUserByPseudo($pseudo) {
            $sql = "SELECT id_user, pseudo, registered_at, last_visit, mail, firstname, lastname FROM user
                    WHERE pseudo = :pseudo" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array("pseudo" => strtolower($pseudo)) ;
            $stmt->execute($args) ;

            return ($stmt->fetch()) ;
        }

        // Sign-In : vérification de l'existence d'un pseudo et de la concordance du mot de passe (hashé)
        public function verifyUser($pseudo, $passwd) {
            $sql = "SELECT passwd FROM user 
                    WHERE user.pseudo = :pseudo" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array("pseudo" => strtolower($pseudo)) ;
            $stmt->execute($args) ;

            $hash = $stmt->fetch() ;

            return ($hash ? password_verify($passwd, $hash['passwd']) : $hash) ;
        }

        // Registration : ajout d'un nouvel utilisateur avec ses informations (validées au préalable)
        public function addUser($pseudo, $passwd, $mail, $firstname="", $lastname="") {
            $sql = "INSERT INTO user (pseudo, passwd, mail, firstname, lastname) 
                    VALUES (:pseudo, :passwd, :mail, :firstname, :lastname)" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array(
                "pseudo"    => strtolower($pseudo),					
                "passwd"    => password_hash($passwd, PASSWORD_ARGON2I),
                "mail"      => $mail,
                "firstname" => $firstname,
                "lastname"  => $lastname) ;

            return ($stmt->execute($args)) ;
        }

        // Sign-Out : mise à jour de la date de dernière visite de l'utilisateur
        public function logUser($uid) {

        }
    }
?>