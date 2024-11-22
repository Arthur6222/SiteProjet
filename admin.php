<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est administrateur
if ($_SESSION['role'] !== 'administrateur') {
    header("Location: index.php");
    exit();
}

// Ajouter un voyage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];

    $sql = "INSERT INTO voyages (nom, description, prix) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $nom, $description, $prix);

    if ($stmt->execute()) {
        $message = "Voyage ajouté avec succès.";
    } else {
        $error = "Erreur lors de l'ajout.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Administrateur</title>
</head>
<body>
    <h2>Espace Administrateur</h2>
    <?php if (isset($message)) echo "<p class='success'>$message</p>"; ?>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label for="nom">Nom du voyage:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>

        <label for="prix">Prix:</label>
        <input type="number" step="0.01" id="prix" name="prix" required>

        <button type="submit">Ajouter</button>
    </form>

    <h3>Liste des voyages</h3>
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