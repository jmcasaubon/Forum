<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JMC's Forum</title>
    <!-- Inclusion de UIkit (CSS & JavaScript) -->
    <link rel="stylesheet" href="<?=CSS_PATH.'uikit.min.css'?>" />
    <script src="<?=JS_PATH.'uikit.min.js'?>"></script>
    <script src="<?=JS_PATH.'uikit-icons.min.js'?>"></script>
    <!-- Inclusion des styles personnels -->
    <link rel="stylesheet" href="<?=CSS_PATH.'style.css'?>" />
    <!-- Inclusion de la police de base du site -->
    <link href="https://fonts.googleapis.com/css?family=Archivo&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <!-- Partie gauche de l'en-tête, contenant le logo (cliquable pour retourner en page d'accueil) et le nom du forum -->
        <div id="logo">
            <a href="index.php"><img src="<?=IMG_PATH.'avatar.png'?>" alt="Logo"></a>
            <h1>JMC's Forum</h1>
        </div>
        <!-- Partie droite de l'en-tête, gérant la connexion/déconnexion (et l'inscription via le formulaire de connexion) -->
        <div id="user">
<?php
            if (isset($_SESSION['user'])) {
?>
                <!-- Si un utilisateur est en session, c'est que la connexion a été effectuée avec succès ! -->
                <strong>Welcome <?=ucwords($_SESSION['user']['pseudo'], "-_ \t\r\n\f\v")?> !</strong>&nbsp;
                <a class="button" href="index.php?ctrl=User&action=logout">Sign-Out</a>
    <?php
            } else {
?>
                <!-- Sinon, on reste en mode anonyme, et on suggère de s'identifier -->
                <strong>Please log in to contribuate</strong>&nbsp;
                <a class="button" href="index.php?ctrl=User">Sign-In</a>
<?php
            }
?>
        </div>
    </header>

    <main id="page" class="center">
        <hr>
        <!-- Partie variable du site, qui dépend du contrôleur invoqué et du résultat obtenu -->
<?php
        echo $page ;
?>
        <hr>
    </main>

    <footer>
        <!-- Pied de page réduit à son strict minimum ! -->
        <p class="center">&copy; JMC - Janvier 2020</p>
    </footer>

    <!-- Inclusion de jQuery -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
    <!-- Inclusion de Font Awesome -->
    <script 
        src="https://kit.fontawesome.com/5bda009b12.js" 
        crossorigin="anonymous"></script> 
    <!-- Inclusion du JavaScript local -->
    <script src="<?=JS_PATH.'forum.js'?>"></script>
</body>
</html>