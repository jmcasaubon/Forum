<?php  
    // Définition de l'ensemble des chemins d'accès aux divers composants de l'application
    define("BASE_PATH",  "src/");
    define("CTRL_PATH",  BASE_PATH."controllers/");
    define("MODEL_PATH", BASE_PATH."models/");
    define("VIEW_PATH",  "views/");
    define("PUB_PATH",   "public/");
    define("CSS_PATH",   PUB_PATH."css/");
    define("IMG_PATH",   PUB_PATH."img/");
    define("JS_PATH",    PUB_PATH."js/");

    // require_once MODEL_PATH."UserModel.class.php";
    session_start();

    // Récupération du contrôleur à utiliser, avec choix d'un contrôleur par défaut sinon
    if(isset($_GET["ctrl"])){
        $ctrl = $_GET["ctrl"];
    }
    else $ctrl = "Topic";

    // Détermination automatique du nom du contrôleur et de son chemin d'accès
    $ctrlname = $ctrl."Controller"; 
    $ctrlpath = CTRL_PATH.$ctrlname.".class.php";

    // Vérification de l'existence du contrôleur sélectionné, et remplacement par le contrôleur par défaut sinon (en cas de manipulation directe de l'URL)
    if(!file_exists($ctrlpath)){
        $ctrlname = "TopicController"; 
        $ctrlpath = CTRL_PATH."TopicController.class.php";
    }

    // Chargement du contrôleir demandé
    require $ctrlpath;

    // Instanciation du contrôleur
    $controller = new $ctrlname();

    // Récupération de l'action à déckencher, avec choix de l'action par défaut (qui sera toujours "indexAction" -> cf. ControllerInterface.php)
    if(isset($_GET["action"])){
        $action = $_GET["action"];
    }
    else $action = "index";

    // Détermination automatique du nom de la méthode à déclencher (implémentée dans le contrôleur)
    $method = $action.'Action';

    // Vérification de l'existence de la méthode sélectionnée, et remplacement par la méthode par défaut sinon (en cas de manipulation directe de l'URL)
    if(!method_exists($controller, $method)){
        $method = "indexAction";
    }

    // Récupération de l'éventuel paramètre "id" (transmis dans l'URL, optionnel, et donc mis à "null" sinon)
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    else $id = null;
    
    // Appel de la méthode du contrôleur déterminés auparavant !
    $result = $controller->$method($id);

    // Détermination de l'affichage de la page
	
    if(isset($_GET['ajax'])){
        // Si on a utilisé Ajax, le résultat est à afficher directement (sans raffraîchissement complet)
        echo $result;
    }
    else{
        // Sinon la méthode appelée (dans le contrôleur) a retourné un tableau contenant la vue à afficher, et le résultat à afficher par celle-ci

        // var_dump($result) ;

        ob_start();//démarre un buffer (tampon de sortie)
        /*la vue s'affiche dans le buffer qui devra être inséré
        au milieu du template*/
        include(VIEW_PATH.$result['view']);
        /*je mets cet affichage dans une variable*/
        $page = ob_get_contents();
        /*j'efface le tampon*/
        ob_end_clean();
        /*j'affiche le template principal*/
        include VIEW_PATH."layout.php";
    }
?>
