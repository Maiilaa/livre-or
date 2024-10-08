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
$sql = "SELECT * FROM utilisateurs WHERE login = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo "Erreur: utilisateur non trouvé.";
    $stmt->close();
    mysqli_close($conn);
    exit;
}
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_login = $_POST["login"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    if ($password == $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        $sql = "UPDATE utilisateurs SET login = ?, password = ? WHERE login = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $new_login, $hashed_password, $login);
        
        if ($stmt->execute()) {
            echo "Modifications enregistrées.";
            $_SESSION["login"] = $new_login; 
        } else {
            echo "Erreur: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Mot de passe et confirmation de mot de passe ne correspondent pas.";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="livre-or.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <a class="retouraccueil" href="../livre-or/index.php"><i class="fas fa-home"></i></a>
    </header>
    <main>
        <h1>Modifier les informations</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($user_data["login"]); ?>"><br><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password"><br><br>
            <label for="confirm_password">Confirmation Password</label>
            <input type="password" id="confirm_password" name="confirm_password"><br><br>
            <input type="submit" value="Modifier">
        </form>
    </main>
    <footer>

    </footer>
</body>
</html>
