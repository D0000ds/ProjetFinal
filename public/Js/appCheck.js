// Récupérer les boutons radio et le paragraphe pour afficher le prix
const radioLivraison = document.querySelectorAll('input[name="livraison"]');
const prixLivraison = document.getElementById('prixLiv');
const prixTotal = document.getElementById('prixTotal');
const inputAdresseList = document.getElementsByName('adresse');

// Convertir le contenu actuel de prixTotal en un nombre
let ancienPrix = parseFloat(prixTotal.innerText);

// Calculer le nouveau prix en soustrayant 10 de l'ancien prix
let nouveauPrix = ancienPrix - 10;

// Calculer un deuxième nouveau prix en ajoutant 10 à l'ancien prix
let nouveauPrix2 = ancienPrix + 10;

if (inputAdresseList.length > 0) {
    const inputAdresse = inputAdresseList[0];

    // Ajouter des écouteurs d'événements pour les changements de bouton radio
    radioLivraison.forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Mettre à jour le prix en fonction de la sélection du bouton radio
            if (radio.value === 'standard') {
                // Mettre à jour le texte avec la nouvelle valeur et ajouter " €"
                prixLivraison.textContent = '10 €';

                // Mettre à jour le prix total en soustrayant 10 du deuxième nouveau prix
                prixTotal.textContent = nouveauPrix2 - 10;

            } else if (radio.value === 'clickAndCollect') {
                // Mettre à jour le texte avec la nouvelle valeur
                prixLivraison.textContent = 'Gratuit';

                // Mettre à jour le prix total avec le premier nouveau prix
                prixTotal.textContent = nouveauPrix;
            }
        });
    });
} else {
    console.error('Aucun élément avec le nom "adresse" trouvé.');
}

