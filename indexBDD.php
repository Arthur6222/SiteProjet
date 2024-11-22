<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = $_POST['identifiant'];
    $mot_de_passe = md5($_POST['mot_de_passe']); // Hashage simple

    // Vérification des identifiants
    $sql = "SELECT role FROM utilisateurs WHERE identifiant = ? AND mot_de_passe = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $identifiant, $mot_de_passe);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['role'] = $user['role'];
        $_SESSION['identifiant'] = $identifiant;

        // Rediriger en fonction du rôle
        if ($user['role'] === 'administrateur') {
            header("Location: admin.php");
        } else {
            header("Location: client.php");
        }
        exit();
    } else {
        $error = "Identifiant ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Authentification</title>
</head>
<body>
    <div class="login-form">
        <h2>Connexion</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <label for="identifiant">Identifiant:</label>
            <input type="text" id="identifiant" name="identifiant" required>
            
            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>