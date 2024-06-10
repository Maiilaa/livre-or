<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: connexion.php");
    exit;
}


$conn = mysqli_connect("localhost", "root", "", "livreor");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$login = $_SESSION["login"];
$sql = "SELECT * FROM utilisateurs WHERE login='$login'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    echo "Erreur: utilisateur non trouvé.";
}

mysqli_close($conn);

if (isset($_SESSION["login"]) && $_SESSION["login"] == "admin") {
    echo '<a href="./admin.php">Accéder à la page admin</a>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $conn = mysqli_connect("localhost", "root", "", "livreor");

    if ($password == $confirm_password) {
        
        $sql = "UPDATE utilisateurs SET prenom='$prenom', nom='$nom', password='$password' WHERE login='$login'";
        if (mysqli_query($conn, $sql)) {
            echo "Modifications enregistrées.";
        } else {
            echo "Erreur: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Mot de passe et confirmation de mot de passe ne correspondent pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
<header>

</header>
<main>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="login">login</label>
    <input type="text" id="login" name="login" value="<?php echo $user_data["login"]; ?>"><br><br>
    <label for="password">Password</label>
    <input type="password" id="password" name="password"><br><br>
    <label for="confirm_password">Confirmation Password</label>
    <input type="password" id="confirm_password" name="confirm_password"><br><br>
    <input type="submit" value="Modifier">
</form>
        <a href="../index.php">Retour à l'accueil</a>
</main>
<footer>

</footer>
</body>
</html>