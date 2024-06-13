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
    <link rel="stylesheet" href="livre-or.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <a class="retouraccueil" href="../livre-or/index.php"><i class="fas fa-home"></i></a>
    </header>
    <main>
        <h1>Livre d'Or</h1>
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
    </main>
</body>
</html>

<?php
$conn->close();
?>