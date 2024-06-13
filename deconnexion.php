<?php
session_start();
session_destroy();
header("Location: ../livre-or/index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
</head>
<body>
    <header>
        <a class="retouraccueil" href="../livre-or/index.php"><i class="fas fa-home"></i></a>
    </header>
    
</body>
</html>