function popUp() {
    // Définition de la fonction popUp
    let cartPopup = document.getElementById('cartPopup');
    // Récupération de l'élément HTML avec l'ID 'cartPopup' et stockage dans la variable cartPopup
    cartPopup.style.display = 'block';
    // Affichage de l'élément en changeant la propriété 'display' à 'block'

    setTimeout(function() {
        // Utilisation de setTimeout pour exécuter une fonction après un délai
        cartPopup.style.display = 'none';
        // Après le délai, masquer à nouveau l'élément en changeant la propriété 'display' à 'none'
    }, 2000);
    // Le délai est de 2000 millisecondes (2 secondes)
}
