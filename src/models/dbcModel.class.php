<?php
    // Modèle générique de connexion à la base de données
    
    abstract class DBC {
        protected static $_connexion;
        
        protected static function dbConnect(){
            //connexion à la BDD
            try{
                self::$_connexion = new PDO(
                    'mysql:host=localhost:3306;dbname=forum',
                    'root',
                    '',
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
                );
                self::$_connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
?>