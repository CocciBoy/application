const burgerMenuButton = document.querySelector('.burger-menu-button');
         const burgerMenuButtonIcon = document.querySelector('.burger-menu-button i');
         const burgerMenu = document.querySelector('.burger-menu');

         burgerMenuButton.onclick = function(){
             burgerMenu.classList.toggle('open');
             const isOpen = burgerMenu.classList.contains('open');
             burgerMenuButtonIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
         }
     const ajouterAuPanierButons = document.querySelectorAll('.ajouter-panier');
     ajouterAuPanierButons.forEach(bouton => {
         bouton.addEventListener('click', () => {
             const mainContainer = bouton.closest('.main-container');
             const nom = mainContainer.dataset.nom;
             const prix = parseFloat(mainContainer.dataset.prix);
             const imageSrc = mainContainer.dataset.image;

             const article = { nom : nom, prix : prix, imageSrc : imageSrc, quantite : 1};
             ajouterAuPanier(article);
             window.location.href = 'panier.html';
         });
     });

     function ajouterAuPanier(article) {
         let panier = JSON.parse(localStorage.getItem('panier')) || [];
         const articleExistant = panier.find(item => item.nom === article.nom);
         if (articleExistant) {
             articleExistant.quantite++;
         } else {
             panier.push(article);
         }
         localStorage.setItem('panier', JSON.stringify(panier));
     }