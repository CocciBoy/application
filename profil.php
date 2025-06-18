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

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: seconnecter.html');
    exit();
}

// Récupérer les informations utilisateur
$user_id = $_SESSION['user_id'];
$email = $_SESSION['user_email'] ?? null; // Récupérer l'email depuis la session

if (!$email) {
    die('Erreur : L\'email de l\'utilisateur n\'est pas défini dans la session.');
}

$query = $bdd->prepare("SELECT * FROM profil WHERE user_id = :user_id");
$query->bindParam(':user_id', $user_id);
$query->execute();
$profil = $query->fetch(PDO::FETCH_ASSOC);

// Si le profil n'existe pas encore, créer une entrée par défaut
if (!$profil) {
    $query = $bdd->prepare("INSERT INTO profil (user_id, email) VALUES (:user_id, :email)");
    $query->bindParam(':user_id', $user_id);
    $query->bindParam(':email', $email);
    $query->execute();

    // Recharger les données
    $query = $bdd->prepare("SELECT * FROM profil WHERE user_id = :user_id");
    $query->bindParam(':user_id', $user_id);
    $query->execute();
    $profil = $query->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
<header>
        <h1>My Profil</h1>
    </header>
    <main>
        <div class="profile-container">
            <!-- Photo de couverture -->
             <div class="cover-picture">
                <img src="<?php echo htmlspecialchars($profil['cover_picture'] ?? 'default-cover.jpg'); ?>" alt="Photo de couverture">
                <form action="php/update_cover.php" method = "POST" enctype="multipart/form-data">
                    <label for="cover_picture">Change your cover picture :</label>
                    <input type="file" name="cover_picture" id="cover_picture">
                    <button type="submit">Update</button>
                </form>
             </div>

            <!-- Photo de profil -->
            <div class="profile-picture">
                <img src="<?php echo htmlspecialchars($profil['profile_picture'] ?? 'default-profile.jpg'); ?>" alt="Photo de profil">
                <form action="php/update_profile_picture.php" method= "POST" enctype="multipart/form-data">
                    <label for="profile_picture">Change your profile picture :</label>
                    <input type="file" name="profile_picture" id="profile_picture">
                    <button type="submit">Update</button>
                </form>
            </div>

            <!-- Informations du profil -->
            <div class="profile-info">
                <form action="php/update_profil.php" method="POST">
                    <label for="organisation_name">Organisation name :</label>
                    <input type="text" name="organisation_name" id="organisation_name" value="<?php echo htmlspecialchars($profil['organisation_name'] ?? ''); ?>">

                    <label for="phone_number">Phone number :></label>
                    <input type="text" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($profil['phone_number'] ?? ''); ?>">

                    <label for="email">Email :</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($profil['email']); ?>">
                    <button type="submit">Edit</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>


