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


$sql = "SELECT commentaires.*, utilisateurs.login 
        FROM commentaires 
        LEFT JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id
        ORDER BY commentaires.date DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'Or</title>
</head>
<body>
    <header>

    </header>
    <main>
        <h2>Livre d'Or</h2>

        <?php
            if ($result->num_rows > 0) {
   
            while($row = $result->fetch_assoc()) {
                $login = !empty($row['login']) ? htmlspecialchars($row['login']) : "Utilisateur inconnu";
                echo "<div>";
                echo "<h4>" . $login . " <small>(" . $row['date'] . ")</small></h4>";
                echo "<p>" . htmlspecialchars($row['commentaire']) . "</p>";
                echo "</div><hr>";
             }
            } else {
                 echo "Aucun commentaire pour le moment.";
            }
        ?>
        <a href="../livre-or/index.php">Retour à l'accueil</a>

    </main>
</body>
</html>

<?php
$conn->close();
?>