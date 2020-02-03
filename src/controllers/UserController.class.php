<?php 
    require_once CTRL_PATH."ControllerInterface.class.php";
    require_once MODEL_PATH."UserModel.class.php";

    final class UserController implements ControllerInterface {

        private $_user ;

        public function __construct(){
            $this->_user = new UserModel();
        }

        // Méthode par défaut, initiant la demande de connexion
        public function indexAction(){
            return array(
                "view" => 'viewLoginUser.php',
                "data" => null
            );
        }

        // Méthode appelée pour déconnecter l'utilisateur courant (=> nettoyage des variables de session)
        public function logoutAction() {
            unset($_SESSION['user']) ;

            if (isset($_SESSION['topic'])) 
                unset($_SESSION['topic']) ;

            if (isset($_SESSION['post'])) 
                unset($_SESSION['post']) ;
                
            header("Location:index.php");
        }
        
        // Méthode appelée en validation du formulaire de connexion
        public function loginAction() {
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING, (FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH)) ;
            $passwd = filter_input(INPUT_POST, 'passwd', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW) ;

            if ($this->_user->verifyUser($pseudo, $passwd)) {
                // En cas de succès, redirection vers la page d'accueil, avec mémorisation des attributs de l'utilisateur
                $_SESSION['user']=$this->_user->getUserByPseudo($pseudo) ;
                header("Location:index.php");
            } else {
                $error = "Invalid pseudo or passwd !!! Please try again..." ;
            }

            // En cas d'erreur, revient à la vue de connexion, avec le message d'erreur
            return array(
                "view" => 'viewLoginUser.php',
                "data" => $error
            );
        }

        // Méthode appelée pour initier l'enregistrement d'un nouvel utilisateur
        public function signInAction() {
            return array(
                "view" => 'viewRegisterUser.php',
                "data" => null
            );
        }
        
        // Méthode appelée en validation du formulaire d'enregistrement d'un nouvel utilisateur
        public function registerAction() {
            // Le pseudo doit contenir entre 6 et 32 caractères alphanumériques, dont le premier est une lettre
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_VALIDATE_REGEXP, [
                "options" => [
                    "regexp" => '#^[A-Za-z][A-Za-z0-9_-]{5,31}$#'
                ]
            ]) ;
        
            if ($pseudo) {
        
                // Le mot de passe doit contenir au moins 8 caractères, dont une minuscule, une majuscule, un chiffre et un caractère spécial
                $passwd = filter_input(INPUT_POST, 'passwd', FILTER_VALIDATE_REGEXP, [
                    "options" => [
                        "regexp" => '#^.*(?=.{8,63})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).*$#'
                    ]
                ]) ;
        
                if ($passwd) {
        
                    // Recherche d'un utilisateur existant avec le pseudo indiqué
                    $user = $this->_user->getUserByPseudo($pseudo);
        
                    if (is_array($user)) {

                        // Si un utilisateur est effectivement retrouvé, enregistrement d'un message d'erreur
                        $error = "This pseudo is already in use !!! Please choose another one..." ;

                    } else {
        
                        // Sinon, vérification de la saisie du mot de passe (récupération du second champ de saisie et comparaison avec le premier)
                        $vrfpwd = filter_input(INPUT_POST, 'vrfpwd', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW) ;
        
                        if ($passwd === $vrfpwd) {

                            // Récupération et validation de l'adresse mail
                            $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL) ;

                            if ($mail) {
                                // Récupération et validation des champs optionnels (prénom et nom)
                                $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW) ;
                                $lastname  = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW) ;
                                
                                // Tentative d'enregistrement du nouvel utilisateur en base de données
                                $status = $this->_user->addUser($pseudo, $passwd, $mail, $firstname, $lastname) ;
                               
                                if ($status) {
                                    if (is_array($user)) {
                                        // Si OK, on enregistre cet utilisateur en session (-> devient l'utilisateur courant)
                                        $_SESSION['user']=$this->_user->getUserByPseudo($pseudo) ;
                                    } else {
                                        // Sinon, on efface l'utilisateur courant (cela ne devrait jamais arriver)
                                        unset($_SESSION['user']) ;
                                    }

                                    // Et on redirige vers la page d'accueil
                                    header("Location:index.php") ;
                                } else {

                                    // Erreur retournée en cas d'échec de l'enregistrement en base de données
                                    $error = "Unknown error !!! Please try again..." ;

                                }
                            } else {

                                // Erreur retournée en cas d'échec de validation de l'adresse mail
                                $error = "Invalid or misformed mail address !!! Please try again..." ;

                            }
                        } else {

                            // Erreur retournée lorsque les deux mots de passe saisis ne concordent pas
                            $error = "The two passwds are not identical !!! Please try again..." ;

                        }
                   }
                } else {

                    // Erreur retournée en cas de mot de passe ne respectant pas les critères de sécurité imposés
                    $error = "passwd must contain at lest 8 characters, et must contain a lowercase letter, a uppercase letter, a digit and and a special character !!! Please try again..." ;

                }
            } else {

                // Erreur retournée en cas de format de pseudo invalide
                $error = "Username must contain between 6 and 32 alphanumeric characters, et must start with a letter !!! Please try again..." ;

            }

            // On réaffichera le formulaire d'enregistrement, avec le message d'erreur approprié
            return array(
                "view" => 'viewRegisterUser.php',
                "data" => $error
            );
        }
    }
?>