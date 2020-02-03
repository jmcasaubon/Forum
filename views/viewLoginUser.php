<!-- Formulaire de connexion d'un utilisateur existant -->
<div class="center">
    <h1>Sign-In</h1>
    <form action="index.php?ctrl=User&action=login" method="post">
        <p><input type="text" size="32" name="pseudo" id="pseudo" placeholder="Your pseudo" required></p>
        <p><input type="password" size="32" name="passwd" id="passwd" placeholder="Your password" required></p>
        <p><input class="button" type="submit" value="Sign In"></p>
    </form>
    <span>Forgot password ?</span>&nbsp;<a href="index.php?ctrl=User&action=signIn">Not yet a member ?</a>
    <p class="error"><?=$result['data']?></p>
</div>