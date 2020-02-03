<?php 
    require_once CTRL_PATH."ControllerInterface.class.php";
    require_once MODEL_PATH."PostModel.class.php";

    final class PostController implements ControllerInterface {

        private $_post ;

        public function __construct(){
            $this->_post = new PostModel();
        }

        public function indexAction() {
            // Never used !!!
        }

        // Méthode appelée pour afficher la liste des messages associés à un sujet
        public function listAction($tid) {
            $_SESSION['topic'] = $this->_post->getTopic($tid) ;

            return array(
                "view" => 'viewPosts.php',
                "data" => $this->_post->getPostsList($tid)
            );
        }

        // Méthode appelée pour initier l'ajout d'un nouveau sujet
        public function newAction($tid) {
            return array(
                "view" => 'viewAddPost.php',
                "data" => null
            );
        }

        // Méthode appelée en validation du formulaire d'ajout d'un nouveau message
        public function addAction($tid) {
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING) ;

            if (isset($_SESSION['user'])) {
                $uid = $_SESSION['user']['id_user'] ;

                if (isset($_SESSION['topic'])) {
                    $tid = $_SESSION['topic']['id_topic'] ;
    
                    $status = $this->_post->addPost($text, $tid, $uid) ;

                    if ($status) {
                        // Si ajout OK, on redirige vers la page d'accueil
                        header("Location:index.php?ctrl=Post&action=list&id=$tid") ;
                    } else {
                        // Sinon, on affiche le message d'erreur
                        $error = "Unknown error !!! Please try again..." ;
                    }
                } else {
                $error = "Unreferenced topic !!! Please sign-in first..." ;
                }
            } else {
                $error = "Unregistred user !!! Please sign-in first..." ;
            }

            return array(
                "view" => 'viewAddPost.php',
                "data" => $error
            );
        }


        // Méthode appelée pour initier la modification d'un message existant
        public function updateAction($pid) {
            $_SESSION['post'] = $this->_post->getPost($pid) ;

            return array(
                "view" => 'viewUpdatePost.php',
                "data" => null
            );
        }

        // Méthode appelée en validation du formulaire de modification d'un message existant
        public function doUpdateAction($pid) {
            $tid  = filter_input(INPUT_POST, 'id_topic', FILTER_VALIDATE_INT) ;
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING) ;

            $status = $this->_post->updatePost($pid, $text) ;

            if ($status) {
                // Si ajout OK, on redirige vers la page d'accueil
                header("Location:index.php?ctrl=Post&action=list&id=$tid") ;
            } else {
                // Sinon, on affiche le message d'erreur
                $error = "Unknown error !!! Please try again..." ;
            }

            $_SESSION['post'] = $this->_post->getPost($pid) ;
        
            return array(
                "view" => 'viewUpdatePost.php',
                "data" => $error
            );
        }

        // Méthode appelée pour supprimer un message existant (après confirmation côté client)
        public function deleteAction($pid) {
            $status = $this->_post->deletePost($pid) ;
            header("Location:index.php?ctrl=Topic") ;
        }
    }
?>