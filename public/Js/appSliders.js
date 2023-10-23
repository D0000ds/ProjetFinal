const slides = document.querySelectorAll(".slide") // Récupère tout les éléments class "slide"
let counter = 0

// Configurez la position de départ pour chaque diapositive
slides.forEach(
    (slide,index) => {
        slide.style.left = `${index * 100}%`
    }
)

// Fonction pour passer à la diapositive précédente
const goPrev = () => {
    counter--
    // Vérifiez si nous sommes au début du slider
    if (counter < 0) {
        // Si oui, revenez à la dernière diapositive
        counter = slides.length - 1;
        
    }
    slideImage() // Mettez à jour l'affichage
}

// Vérifiez si nous sommes à la fin du slider
const goNext = () => {
    counter++
    // Vérifiez si nous sommes à la fin du slider
    if (counter >= slides.length) {
        // Si oui, revenez à la première diapositive
        counter = 0;
    }
    slideImage() // Mettez à jour l'affichage
}

// Fonction pour mettre à jour la position des diapositives en fonction du compteur
const slideImage = () => {
    slides.forEach(
        (slide) => {
            slide.style.transform = `translateX(-${counter * 100}%)` //Faire la transformation pour déplacer la diapositive
        }
    )
}