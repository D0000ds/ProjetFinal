function toggleDisplay() {

    var elements = document.getElementsByClassName("sousProfileTextAreaAdresseNone");
    // Récupère tous les éléments avec la classe "sousProfileTextAreaAdresse"
    
  for (var i = 0; i < elements.length; i++) {
    // Boucle à travers tous les éléments récupérés
    if (elements[i].classList.contains("none")) {
    // Vérifie si l'élément a la classe "none" (est masqué)
      elements[i].classList.remove("none");
      // Supprime la classe "none" pour le rendre visible
      elements[i].classList.add("affiche");
      // Ajoute la classe "affiche" pour afficher l'élément
      document.getElementById("bouton").innerText = "Voir moins";
      // Met à jour le texte du bouton pour afficher "Voir moins"
    } else {
      // Si l'élément n'a pas la classe "cache" (est affiché)
      elements[i].classList.remove("affiche");
      // Supprime la classe "affiche" pour le masquer
      elements[i].classList.add("none");
      // Ajoute la classe "none" pour masquer l'élément
      document.getElementById("bouton").innerText = "Voir la liste des adresses";
      // Met à jour le texte du bouton pour afficher "Voir la liste des adresses"
    }
  }
}


document.getElementById("bouton").addEventListener("click", toggleDisplay); // Ajoute la fonction toggleDisplay au bouton