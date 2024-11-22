<?php
// Configuration de la base de données
$host = "localhost";
$user = "root";
$pass = ""; // Remplacez par votre mot de passe MySQL
$db_name = "gestion_voyages";

// Connexion à la base de données
$conn = new mysqli($host, $user, $pass, $db_name);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>