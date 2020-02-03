<!-- Formulaire d'enregistrement d'un nouvel utilisateur -->
<div class="center">
    <h1>Register</h1>
    <form action="index.php?ctrl=User&action=register" method="post">
        <p>
        <input type="text" size="32" name="pseudo" id="pseudo" placeholder="Your pseudo" required>
        <input type="email" size="32" name="mail" id="mail" placeholder="Your mail" required>
        </p>
        <p>
        <input type="password" size="32" name="passwd" id="passwd" placeholder="Your password" required>
        <input type="password" size="32" name="vrfpwd" id="vrfpwd" placeholder="Confirm your password" required>
        </p>
        <p>
        <input type="text" size="32" name="firstname" id="firstname" placeholder="First Name">
        <input type="text" size="32" name="lastname" id="lastname" placeholder="Last Name">
        </p>
        <p><input class="button" type="submit" value="Register"></p>
    </form>
    <span class="error"><?=$result['data']?></span>
</div>