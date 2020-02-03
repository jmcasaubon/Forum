<?php 
    require_once CTRL_PATH."ControllerInterface.class.php";
    require_once MODEL_PATH."TopicModel.class.php";

    final class TopicController implements ControllerInterface {

        private $_topic ;

        public function __construct(){
            $this->_topic = new TopicModel();
        }

        // Méthode par défaut, appelée pour afficher la liste des sujets du forum
        public function indexAction(){
            return array(
                "view" => 'viewTopics.php',
                "data" => $this->_topic->getTopicsList()
            );
        }

        // Méthode appelée pour clôturer ou rouvrir un sujet
        public function toggleAction($tid) {
            $status = $this->_topic->toggleTopic($tid) ;

            if ($status) {
                // Si ajout OK, on redirige vers la page d'accueil
                header("Location:index.php?ctrl=Topic") ;
            } else {
                // Sinon, on affiche le message d'erreur
                $error = "Unknown error !!! Please try again..." ;
            }
        
            return array(
                "view" => 'viewTopics.php',
                "data" => $this->_topic->getTopicsList()
            );
        }

        // Méthode appelée pour initier l'ajout d'un nouveau sujet
        public function newAction() {
            return array(
                "view" => 'viewAddTopic.php',
                "data" => null
            );
        }

        // Méthode appelée en validation du formulaire d'ajout d'un nouveau sujet
        public function addAction() {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW) ;
            $descr = filter_input(INPUT_POST, 'descr', FILTER_SANITIZE_STRING) ;

            if (isset($_SESSION['user'])) {
                $uid = $_SESSION['user']['id_user'] ;

                $status = $this->_topic->addTopic($title, $descr, $uid) ;

                if ($status) {
                    // Si ajout OK, on redirige vers la page d'accueil
                    header("Location:index.php?ctrl=Topic") ;
                } else {
                    // Sinon, on affiche le message d'erreur
                    $error = "Unknown error !!! Please try again..." ;
                }
            } else {
                $error = "Unregistred user !!! Please sign-in first..." ;
            }
        
            return array(
                "view" => 'viewAddTopic.php',
                "data" => $error
            );
        }
            // Méthode appelée pour initier la modification d'un sujet existant
            public function updateAction($tid) {
                $_SESSION['topic'] = $this->_topic->getTopic($tid) ;
    
                return array(
                    "view" => 'viewUpdateTopic.php',
                    "data" => null
                );
            }
    
            // Méthode appelée en validation du formulaire de modification d'un sujet existant
            public function doUpdateAction($tid) {
                $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW) ;
                $descr = filter_input(INPUT_POST, 'descr', FILTER_SANITIZE_STRING) ;
    
                $status = $this->_topic->updateTopic($tid, $title, $descr) ;
    
                if ($status) {
                    // Si ajout OK, on redirige vers la page d'accueil
                    header("Location:index.php?ctrl=Topic") ;
                } else {
                    // Sinon, on affiche le message d'erreur
                    $error = "Unknown error !!! Please try again..." ;
                }
    
                $_SESSION['topic'] = $this->_topic->getTopic($tid) ;
            
                return array(
                    "view" => 'viewUpdateTopic.php',
                    "data" => $error
                );
            }
    
            // Méthode appelée pour supprimer un sujet existant (après confirmation côté client)
            public function deleteAction($tid) {
                $status = $this->_topic->deleteTopic($tid) ;
                header("Location:index.php?ctrl=Topic") ;
            }
    }
?>