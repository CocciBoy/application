<?php
session_start();

$serveur = "localhost";
$username = "root";
$password = "root";
$port = "8889";
// Correction ici: Utilise le bon nom de base de données
$database = "paris-pic-nic"; 

try {
    $bdd = new PDO("mysql:host=$serveur;dbname=$database;port=$port", $username, $password); // Ajout du port
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si les clés existent avant d'essayer de les utiliser
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password_saisi = $_POST['password']; // Renommé pour éviter la confusion avec le $password de la connexion BDD
        $error_msg = "";

        if (!empty($email) && !empty($password_saisi)) {
            $req = $bdd->prepare("SELECT id, password, name, surname FROM utilisateur WHERE email = :email"); // Ajout de surname pour la session si nécessaire
            $req->bindParam(':email', $email);
            $req->execute();
            $user = $req->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Vérification du mot de passe haché
                if (password_verify($password_saisi, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name']; // Stocke le nom correct (lowercase)
                    $_SESSION['user_surname'] = $user['surname']; // Stocke le prénom si tu veux aussi
                    $_SESSION['user_email'] = $email; // Stocke l'email pour le profil
                    header('Location: ../index.php'); // Redirige vers la page de profil
                    exit();
                } else {
                    $error_msg = "Erreur : Mot de passe incorrect.";
                }
            } else {
                $error_msg = "Erreur : Email incorrect.";
            }
        } else {
            $error_msg = "Erreur : Veuillez remplir tous les champs.";
        }
    } else {
        $error_msg = "Erreur : Données du formulaire manquantes.";
    }
     // Afficher le message d'erreur si redirection n'a pas eu lieu
    if (!empty($error_msg)) {
        echo $error_msg;
        // Optionnel: tu peux rediriger vers la page de connexion avec le message d'erreur
        // header('Location: ../seconnecter.html?error=' . urlencode($error_msg));
        // exit();
    }
} else {
    // Ce bloc est exécuté si le script est accédé directement (GET request)
    // Tu peux rediriger l'utilisateur ou afficher un message approprié
    echo "Accès non autorisé.";
    // header('Location: ../seconnecter.html'); // Redirige vers la page de connexion
    // exit();
}
?>