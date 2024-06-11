<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password == $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $conn = mysqli_connect("localhost", "root", "", "livreor");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Erreur : ce login est déjà utilisé. Veuillez choisir un autre login.";
        } else {
            // Insérer l'utilisateur avec le mot de passe haché
            $stmt = $conn->prepare("INSERT INTO utilisateurs (login, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $login, $hashed_password);

            if ($stmt->execute()) {
                header("Location: connexion.php");
                exit;
            } else {
                echo "Erreur : " . $stmt->error;
            }
        }

        $stmt->close();
        mysqli_close($conn);
    } else {
        echo "Mot de passe et confirmation de mot de passe ne correspondent pas.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
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
            <input type="text" id="login" name="login" required><br><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br><br>
            <label for="confirm_password">Confirmation Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            <input type="submit" value="S'inscrire">
        </form>
        <a href="../livre-or/index.php">Retour à l'accueil</a>
    </main>
    <footer>
        
    </footer>
</body>
</html>

