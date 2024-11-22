<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est client
if ($_SESSION['role'] !== 'client') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Client</title>
</head>
<body>
    <h2>Espace Client</h2>

    <h3>Liste des voyages disponibles</h3>
    <ul>
        <?php
        $result = $conn->query("SELECT * FROM voyages");
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['nom']} - {$row['prix']} €</li>";
        }
        ?>
    </ul>
</body>
</html>