const panierArticles = document.querySelector('.panier-articles');
const totalPrixElement = document.querySelector('.total-prix');
const commanderBouton = document.querySelector('.commander');

let panier = []; // Tableau pour stocker les articles du panier

// Fonction pour ajouter un article au panier
function ajouterAuPanier(article) {
    const articleExistant = panier.find(item => item.nom === article.nom);
    if (articleExistant) {
        articleExistant.quantite++;
    } else {
        article.quantite = 1;
        panier.push(article);
    }
    mettreAJourPanier();
}

// Fonction pour mettre à jour l'affichage du panier
function mettreAJourPanier() {
    panierArticles.innerHTML = '';
    let totalPrix = 0;

    panier.forEach(article => {
        const li = document.createElement('li');
        li.innerHTML = `
            <div class="article-info">
                <img src="${article.imageSrc}" alt="${article.nom}">
                <span class="article-nom">${article.nom}</span>
            </div>
            <span class="article-prix">${article.prix.toFixed(2)} €</span>
            <div class="article-quantite">
                <button class="quantite-moins" data-nom="${article.nom}">-</button>
                <input type="number" value="${article.quantite}" min="1" data-nom="${article.nom}">
                <button class="quantite-plus" data-nom="${article.nom}">+</button>
            </div>
            <span class="article-sous-total">${(article.prix * article.quantite).toFixed(2)} €</span>
        `;
        panierArticles.appendChild(li);
        totalPrix += article.prix * article.quantite;
    });

    totalPrixElement.textContent = totalPrix.toFixed(2) + ' €';
    mettreAJourEvenementsQuantite();
}

// Fonction pour mettre à jour les événements des boutons de quantité
function mettreAJourEvenementsQuantite() {
    const quantiteMoinsBoutons = document.querySelectorAll('.quantite-moins');
    const quantitePlusBoutons = document.querySelectorAll('.quantite-plus');
    const quantiteInputs = document.querySelectorAll('.article-quantite input');

    quantiteMoinsBoutons.forEach(bouton => {
        bouton.addEventListener('click', () => {
            changerQuantite(bouton.dataset.nom, -1);
        });
    });

    quantitePlusBoutons.forEach(bouton => {
        bouton.addEventListener('click', () => {
            changerQuantite(bouton.dataset.nom, 1);
        });
    });

    quantiteInputs.forEach(input => {
        input.addEventListener('change', () => {
            changerQuantite(input.dataset.nom, parseInt(input.value) - panier.find(item => item.nom === input.dataset.nom).quantite);
        });
    });
}

// Fonction pour changer la quantité d'un article
function changerQuantite(nom, changement) {
    const article = panier.find(item => item.nom === nom);
    if (!article) return;
    article.quantite += changement;
    if (article.quantite < 1) {
        panier = panier.filter(item => item.nom !== nom); // Supprimer l'article si la quantité est < 1
    }
    mettreAJourPanier();
}

// Exemple d'ajout d'articles (à adapter avec tes données)
// ajouterAuPanier({ nom: 'Sandwich Thon', prix: 8.50, imageSrc: 'https://bakeronline-paris.s3.eu-west-3.amazonaws.com/uploads/products/2780/1987922/thon-crud.jpg' });
// ajouterAuPanier({ nom: 'Gouter Equilibre', prix: 6.20, imageSrc: 'https://www.monbento.com/blog/wp-content/uploads/actus/2015/septembre/monbento-gouter-equilibre.png' });
// ajouterAuPanier({ nom: 'Sandwich Club', prix: 9.00, imageSrc: 'https://www.unileverfoodsolutions.ch/dam/global-ufs/mcos/dach/calcmenu-recipes/ch-recipes/2019/sandwich-club/schinkensandwich/main-header.jpg' });

// Initialisation du panier (vide au départ)
mettreAJourPanier();
