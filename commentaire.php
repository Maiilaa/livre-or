<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: connexion.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "livreor";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $commentaire = $_POST["commentaire"];
    $id_utilisateur = $_SESSION["id"]; 
    $date = date("Y-m-d H:i:s"); 

    if (!empty($commentaire)) {
        $stmt = $conn->prepare("INSERT INTO commentaires (id_utilisateur, commentaire, date) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Erreur de préparation : " . $conn->error);
        }
        $stmt->bind_param("iss", $id_utilisateur, $commentaire, $date);

        if ($stmt->execute()) {
            echo "Commentaire ajouté avec succès.";
        } else {
            echo "Erreur d'exécution : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Veuillez entrer un commentaire.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de commentaires</title>
    <link rel="stylesheet" href="livre-or.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <a class="retouraccueil" href="../livre-or/index.php"><i class="fas fa-home"></i></a>
        <p>Vous êtes connecté en tant que <?php echo $_SESSION["login"]; ?>. <a href="deconnexion.php">Déconnexion</a></p>
    </header>
    <main>
        <h1>Ajoutez un commentaire</h1>
        <form action="commentaire.php" method="post">
            <label for="commentaire">Commentaire </label>
            <input type="text" name="commentaire" id="commentaire" required>
            <input type="submit" value="Valider">
        </form>
    </main>
    <footer>

    </footer>
</body>
</html>



