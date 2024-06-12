<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $conn = mysqli_connect("localhost", "root", "", "livreor");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE login = ?");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param("s", $login); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION["login"] = $login;
            header("Location: profil.php");
            exit;
        } else {
            echo "Erreur de connexion : Mot de passe incorrect.";
        }
    } else {
        echo "Erreur de connexion : Utilisateur non trouvé.";
    }

    $stmt->close();
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <header>
    </header>
    <main>
    <h1>Se connecter</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" required><br><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Se connecter">
        </form>
        <a href="../livre-or/index.php">Retour à l'accueil</a>
    </main>
    <footer>
        
    </footer>
</body>
</html>



