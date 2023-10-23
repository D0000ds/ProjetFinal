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

// Slider 2 
const slides2 = document.querySelectorAll(".slide2") // Récupère tout les éléments class "slide"
let counter2 = 0

// Configurez la position de départ pour chaque diapositive
slides2.forEach(
    (slide2,index2) => {
        slide2.style.left = `${index2 * 100}%`
    }
)

// Fonction pour passer à la diapositive précédente
const goPrevs = () => {
    counter2--
    // Vérifiez si nous sommes au début du slider
    if (counter2 < 0) {
        // Si oui, revenez à la dernière diapositive
        counter2 = slides2.length - 1;
        
    }
    slideImage2() // Mettez à jour l'affichage
}

// Vérifiez si nous sommes à la fin du slider
const goNexts = () => {
    counter2++
    // Vérifiez si nous sommes à la fin du slider
    if (counter2 >= slides2.length) {
        // Si oui, revenez à la première diapositive
        counter2 = 0;
    }
    slideImage2() // Mettez à jour l'affichage
}

// Fonction pour mettre à jour la position des diapositives en fonction du compteur
const slideImage2 = () => {
    slides2.forEach(
        (slide2) => {
            slide2.style.transform = `translateX(-${counter2 * 100}%)` //Faire la transformation pour déplacer la diapositive
        }
    )
}

document.getElementById("prevButton").addEventListener("click", goPrevs); // Ajoute la function goPrevs au click sur l'élément qui possède l'id prevButton
document.getElementById("nextButton").addEventListener("click", goNexts); // Ajoute la function goNexts au click sur l'élément qui possède l'id nextButton