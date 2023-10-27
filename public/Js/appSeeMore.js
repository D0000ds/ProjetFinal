function toggleDisplay() {

    var elements = document.getElementsByClassName("sousContainerDescriptif");
    // Récupère tous les éléments avec la classe "sousContainerDescriptif"
  
  for (var i = 0; i < elements.length; i++) {
    // Boucle à travers tous les éléments récupérés
    if (elements[i].classList.contains("cache")) {
    // Vérifie si l'élément a la classe "cache" (est masqué)
      elements[i].classList.remove("cache");
      // Supprime la classe "cache" pour le rendre visible
      elements[i].classList.add("affiche");
      // Ajoute la classe "affiche" pour afficher l'élément
      document.getElementById("bouton").innerText = "Voir moins";
      // Met à jour le texte du bouton pour afficher "Voir moins"
    } else {
      // Si l'élément n'a pas la classe "cache" (est affiché)
      elements[i].classList.remove("affiche");
      // Supprime la classe "affiche" pour le masquer
      elements[i].classList.add("cache");
      // Ajoute la classe "cache" pour masquer l'élément
      document.getElementById("bouton").innerText = "Voir plus";
      // Met à jour le texte du bouton pour afficher "Voir plus"
    }
  }
}


document.getElementById("bouton").addEventListener("click", toggleDisplay); // Ajoute la fonction toggleDisplay au bouton