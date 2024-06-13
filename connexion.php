<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "livreor";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $stmt = $conn->prepare("SELECT id, login, password FROM utilisateurs WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            header("Location: commentaire.php");
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="livre-or.css">
</head>
<body>
    <header>
    <a class="retouraccueil" href="../livre-or/index.php"></a>
    </header>
    <main>
        <h1>Connexion</h1>
        <form action="connexion.php" method="post">
            <label for="login">Login</label>
            <input type="text" name="login" id="login" required><br><br>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required><br><br>
            <input type="submit" value="Se connecter">
        </form>
    </main>
    <footer></footer>
</body>
</html>



