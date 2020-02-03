<?php
    // Modèle de gestion d'un sujet (interface BdD associée au contrôleur de gestion des sujets)
    
    require_once MODEL_PATH."dbcModel.class.php" ;
    
    final class TopicModel extends DBC {
        public function __construct() {
            parent::dbConnect() ;
        }

        // Obtention de la liste complète des sujets
        public function getTopicsList() {
            $sql = "SELECT t.id_topic, t.title, t.description, t.created_at, t.is_closed, u.pseudo, COUNT(p.id_post) AS nb_posts FROM topic t
                    JOIN user u
                    ON t.id_user = u.id_user
                    LEFT JOIN post p
                    ON t.id_topic = p.id_topic 
                    GROUP BY t.id_topic
                    ORDER BY t.created_at DESC" ;
        
            $stmt = self::$_connexion->query($sql) ;

            return ($stmt->fetchAll()) ;
        }

        // Obtention d'un topic en particulier (par son identifiant)
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

        // Méthode appelée pour clôturer ou rouvrir un sujet (drapeau binaire <=> bascule)
        public function toggleTopic($tid) {
            $sql = "UPDATE topic 
                    SET is_closed = (1 - is_closed) 
                    WHERE id_topic = :tid" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array(
                "tid"   => $tid) ;

            return ($stmt->execute($args)) ;
        }

        // Ajout d'un nouveau topic avec ses informations (validées au préalable)
        public function addTopic($title, $descr, $uid) {
            $sql = "INSERT INTO topic (title, description, id_user) 
                    VALUES (:title, :descr, :uid)" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array(
                "title" => $title,
                "descr" => $descr,
                "uid"   => $uid) ;

            return ($stmt->execute($args)) ;
        }

        // Modification d'un topic existant avec de nouvelles informations (validées au préalable)
        public function updateTopic($tid, $title, $descr) {
            $sql = "UPDATE topic 
                    SET title = :title, description = :descr
                    WHERE id_topic = :tid" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array(
                "title" => $title,
                "descr" => $descr,
                "tid"   => $tid) ;

            return ($stmt->execute($args)) ;
        }

        // Suppression d'un topic existant (après vérification et confirmation)
        public function deleteTopic($tid) {
            $sql = "DELETE FROM topic 
                    WHERE id_topic = :tid" ;
        
            $stmt = self::$_connexion->prepare($sql) ;
            $args = array(
                "tid"   => $tid) ;

            return ($stmt->execute($args)) ;
        }
    }
?>