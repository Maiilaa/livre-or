<?php
session_start();
if (isset($_SESSION["login"])) {
    echo "<p>Vous êtes connecté en tant que " . $_SESSION["login"] . ".<br/> <a href='./profil.php'>Mon profil</a> <br/> <a href='./deconnexion.php'>Déconnexion</a></p>";
} else {
    echo "<p><a href='./inscription.php'>Créer un compte</a>  <a href='./connexion.php'>Se connecter</a>  <a href='./profil.php'>Modifier les informations</a>  <a href='./commentaire.php'>Ajouter un commentaire</a> <a href='./livre-or.php'>Livre d'Or</a></p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="livre-or.css">
</head>
<body>
    <header>

    </header>
        <main>
        <a class="bienvenue" href="../livre-or/index.php"><h1>Bienvenue sur mon site</h1></a>
        </main>
    <footer>

    </footer>

</body>
</html>

