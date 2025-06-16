<?php

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

if(isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


$request = $bdd->prepare("INSERT INTO utilisateur (name, surname, email, password) VALUES ( :name, :surname, :email, :password)");
$request->execute(array(
    'name' => $name,
    'surname' => $surname,
    'email' => $email,
    'password' => $password
));

echo "Inscription réussie !";
    header('Location: ../index.html'); // Redirigez l'utilisateur vers la page principale
    exit();
} else {
    echo "Erreur lors de l'inscription.";
}
?>