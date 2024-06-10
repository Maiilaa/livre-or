<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    
    $conn = mysqli_connect("localhost", "root", "", "livreor");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    
    $sql = "SELECT * FROM utilisateurs WHERE login='$login'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION["login"] = $login;
            header("Location: profil.php");
            exit;
        } else {
            echo "Erreur de connexion.";
        }
    } else {
        echo "Erreur de connexion.";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
            <input type="submit" value="Se connecter">
        </form>
            <a href="../index.php">Retour à l'accueil</a>
    </main>
    <footer>

    </footer>
</body>
</html>

