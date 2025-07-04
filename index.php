<?php
session_start();

// definir la condition isConnected
$isConnected = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Welcome</title>
</head>
<body>
    <header>
        <div class="navbar">
        <div class="logo">
            <a href="index.html">ParisPicNic</a>
        </div>
        <ul class="links">
            <li><a href="menu.html">Menu</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="panier.html">My Basket</a></li>
            <?php if ($isConnected): ?>
                <li><a href="profil.php" class="active-button">Profil</a></li>
            <?php endif; ?>
        </ul>
        <div class="buttons">
            <?php if (!$isConnected): ?>
                <a href="seconnecter.html" class="action-button">Login</a>
            <?php else: ?>
                <a href="php/logout.php" class="action-button">Logout</a>
            <?php endif; ?>
        </div>
        <div class="burger-menu-button">
            <i class="fa-solid fa-bars"></i>
        </div>
        </div>
        <div class="burger-menu">
            <ul class="links">
                <li><a href="menu.html">Menu</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="panier.html">My Basket</a></li>
                <div class="divider"></div>
                <div class="buttons-burger-menu">
                    <?php if ($isConnected): ?>
                        <<!-- Si l'utilisateur est connecté, affiche le bouton logout -->
                        <li>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?></li>
                        <a href="php/logout.php" class="action-button">Logout</a>
                    <?php else: ?>
                        <!-- Si l'utilisateur n'est pas connecté, affiche le bouton Login -->
                        <a href="seconnecter.html" class="action-button">Login</a>
                    <?php endif; ?>
                </div>
            </ul>
        </div>
    </header>

    <section>
        <div class="presentation">
            <h1>
                Bonjour et bienvenue sur notre application de commande pour les paniers repart paris par ParisPicNic !<br>
                Nous sommes ravis de vous accueillir et de vous offrir une expérience de commande en ligne pratique et rapide.
                Notre application vous permet de commander facilement vos paniers repas préférés, que ce soit pour un pique-nique dans le parc.
                J'ai concu cette application pour vous faciliter la tache de passer des commande plus rapidement au lieu de passer toujours par mail.
            </h1>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <h3>Contact Us</h3>
                <p>Email: tamouna22@gmail.com</p>
                <p>Phone: +33 6 05 64 70 73</p>
                <p>Adresse: 22 rue de tanger, 75019 Paris</p>
            </div>
            <div class="footer-content">
                <h3>Quick Links</h3>
                <ul class="list">
                    <li><a href="index.html">Acceuil</a></li>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href="about.html">A propos</a></li>
                </ul>
            </div>
            <div class="footer-content">
                <h3>Follow Us</h3>
            <ul class="social-icons">
                <li><a href=""><i class="fab fa-facebook"></i></a></li>
                <li><a href=""><i class="fab fa-twitter"></i></a></li>
                <li><a href=""><i class="fab fa-instagram"></i></a></li>
            </ul>
            </div>
        </div>
        <div class="buttom-bar">
            <p>&copy; 2026 your company. All rights reserved</p>
        </div>
        
    </footer>
    
    <script>
        const burgerMenuButton = document.querySelector('.burger-menu-button');
        const burgerMenuButtonIcon = document.querySelector('.burger-menu-button i');
        const burgerMenu = document.querySelector('.burger-menu');

        burgerMenuButton.onclick = function(){
            burgerMenu.classList.toggle('open');
            const isOpen = burgerMenu.classList.contains('open');
            burgerMenuButtonIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
        }
    </script>
    
</body>
</html>