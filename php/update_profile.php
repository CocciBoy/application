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
$organisation_name = $_POST['organisation_name'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];

$query = $bdd->prepare("UPDATE profil SET organisation_name = :organisation_name, phone_number = :phone_number, email = :email WHERE user_id = :user_id");
$query->bindParam(':organisation_name', $organisation_name);
$query->bindParam(':phone_number', $phone_number);
$query->bindParam(':email', $email);
$query->bindParam(':user_id', $user_id);
$query->execute();

header('Location: ../profil.php');
exit();
?>