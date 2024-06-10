<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


    if ($password == $confirm_password) {
        
        $conn = mysqli_connect("localhost", "root", "", "livreor");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
      
        
        $sql = "INSERT INTO utilisateurs (login, password) VALUES ('$login', '$password')";
        if (mysqli_query($conn, $sql)) {
            header("Location: connexion.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        $sql = "SELECT * FROM utilisateurs WHERE login='$login'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "Erreur : ce login est déjà utilisé. Veuillez choisir un autre login.";
        }

        mysqli_close($conn);
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
    <title>Inscription</title>
</head>
<body>
    <header>

    </header>
    <main>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="login">Login</label>
            <input type="text" id="login" name="login"><br><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password"><br><br>
            <label for="confirm_password">Confirmation Password</label>
            <input type="password" id="confirm_password" name="confirm_password"><br><br>
            <input type="submit" value="S'inscrire">
        </form>
        <a href="../livre-or/index.php">Retour à l'accueil</a>
    </main>
<footer>

</footer>
</body>
</html>
