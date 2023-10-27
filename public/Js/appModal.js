// Récupère l'élément modal par son ID "myModal" et le stocke dans la variable "modal".
var modal = document.getElementById("myModal");

// Récupère l'élément image par son ID "myImg" et le stocke dans la variable "img".
var img = document.getElementById("myImg");

// Récupère l'élément de l'image dans la modal par son ID "img01" et le stocke dans la variable "modalImg".
var modalImg = document.getElementById("img01");

// Associe un gestionnaire d'événements au clic de l'élément "img".
img.onclick = function(){
  // Rend la modal visible en changeant la propriété "display" à "block".
  modal.style.display = "block";
  // Définit la source de l'image de la modal avec la source de l'image actuellement cliquée.
  modalImg.src = this.src;
}

// Récupère le premier élément avec la classe "close" et le stocke dans la variable "span".
var span = document.getElementsByClassName("close")[0];

// Associe un gestionnaire d'événements au clic de l'élément "span".
span.onclick = function() { 
  // Masque la modal en changeant la propriété "display" à "none".
  modal.style.display = "none";
}