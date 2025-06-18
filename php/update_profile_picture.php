<?php
session_start();

$serveur = "localhost";
$username = "root";
$password = "root";
$port = "8889";
$database = "paris-pic-nic";
// Connexion à la base de données

try {
    $bdd = new PDO("mysql:host=$serveur;dbname=paris-pic-nic", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../seconnecter.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$profile_picture = $_FILES['profile_picture']['name'];
$target_dir = "../uploads/";
$target_file = $target_dir . basename($profile_picture);

if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
    $query = $bdd->prepare("UPDATE profil SET profile_picture = :profile_picture WHERE user_id = :user_id");
    $query->bindParam(':profile_picture', $profile_picture);
    $query->bindParam(':user_id', $user_id);
    $query->execute();
}

header('Location: ../profil.php');
exit();