<?php
    // Modèle de gestion d'un message (interface BdD associée au contrôleur de gestion des messages)
    
    require_once MODEL_PATH."dbcModel.class.php" ;

    final class PostModel extends DBC {
        public function __construct() {
            parent::dbConnect() ;
        }

        // Obtention des données du sujet auqeul appartient le message
        public function getTopic($tid) {
            $sql = "SELECT t.id_topic, t.title, t.description, t.created_at, t.is_closed, u.pseudo, COUNT(p.id_post) AS nb_posts FROM topic t
                    JOIN user u
                    ON t.id_user = u.id_user
                    AND t.id_topic = :tid
                    LEFT JOIN post p
                    ON t.id_topic = p.id_topic" ;
    
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array("tid" => $tid);
            $stmt->execute($args) ;

            return ($stmt->fetch()) ;
        }

        // Obtention de la liste complète des contributions sur un sujet
        public function getPostsList($tid) {
            $sql = "SELECT p.id_post, u.pseudo, p.text, p.submitted_at FROM post p, user u
                    WHERE p.id_user = u.id_user
                    AND p.id_topic = :tid
                    ORDER BY p.submitted_at ASC" ;
            
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array("tid" => $tid);
            $stmt->execute($args) ;

            return ($stmt->fetchAll()) ;
        }

        // Obtention d'un message en particulier
        public function getPost($pid) {
            $sql = "SELECT p.id_post, u.pseudo, p.text, p.submitted_at FROM post p, user u
                    WHERE p.id_user = u.id_user
                    AND p.id_post = :pid
                    ORDER BY p.submitted_at ASC" ;
            
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array("pid" => $pid);
            $stmt->execute($args) ;

            return ($stmt->fetch()) ;
        }

        // Ajout d'un nouveau message avec ses informations (validées au préalable)
        public function addPost($text, $tid, $uid) {
            $sql = "INSERT INTO post (text, id_topic, id_user) 
                    VALUES (:text, :tid, :uid)" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array(
                "text" => $text,
                "tid"  => $tid,
                "uid"  => $uid) ;

            return ($stmt->execute($args)) ;
        }

        // Modification d'un message existant avec de nouvelles informations (validées au préalable)
        public function updatePost($pid, $text) {
            $sql = "UPDATE post 
                    SET text = :text
                    WHERE id_post = :pid" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array(
                "text" => $text,
                "pid"  => $pid) ;

            return ($stmt->execute($args)) ;
        }

        // Suppression d'un message existant (après vérification et confirmation)
        public function deletePost($pid) {
            $sql = "DELETE FROM post 
                    WHERE id_post = :pid" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array(
                "pid"   => $pid) ;

            return ($stmt->execute($args)) ;
        }
   }
?>