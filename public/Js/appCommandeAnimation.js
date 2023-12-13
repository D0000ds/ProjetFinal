// Attend que le DOM soit entièrement chargé avant d'exécuter le script
document.addEventListener("DOMContentLoaded", function() {
    // Récupère les éléments HTML avec les IDs "semaine", "mois", "annee" et "tout"
    const semaine = document.getElementById("semaine");
    const mois = document.getElementById("mois");
    const annee = document.getElementById("annee");
    const tout = document.getElementById("tout");
    const click = document.getElementById("click");

    // Récupère l'URL actuelle de la page
    let currentURL = window.location.href;

    // Vérifie si l'URL est égale à "http://127.0.0.1:8000/commande/semaine"
    if (currentURL == "http://127.0.0.1:8000/commande/semaine") {
        // Si oui, supprime la classe "commandLink" et ajoute la classe "commandBarre" à l'élément avec l'ID "semaine"
        semaine.classList.remove("commandLink");
        semaine.classList.add("commandBarre");
    }

    // Vérifie si l'URL est égale à "http://127.0.0.1:8000/commande/mois"
    if (currentURL == "http://127.0.0.1:8000/commande/mois") {
        // Si oui, supprime la classe "commandLink" et ajoute la classe "commandBarre" à l'élément avec l'ID "mois"
        mois.classList.remove("commandLink");
        mois.classList.add("commandBarre");
    }

    // Vérifie si l'URL est égale à "http://127.0.0.1:8000/commande/annee"
    if (currentURL == "http://127.0.0.1:8000/commande/annee") {
        // Si oui, supprime la classe "commandLink" et ajoute la classe "commandBarre" à l'élément avec l'ID "annee"
        annee.classList.remove("commandLink");
        annee.classList.add("commandBarre");
    }

    // Vérifie si l'URL est égale à "http://127.0.0.1:8000/commande"
    if (currentURL == "http://127.0.0.1:8000/commande") {
        // Si oui, supprime la classe "commandLink" et ajoute la classe "commandBarre" à l'élément avec l'ID "tout"
        tout.classList.remove("commandLink");
        tout.classList.add("commandBarre");
    }

    // Vérifie si l'URL est égale à "http://127.0.0.1:8000/commande/votreClickAndCollect"
    if (currentURL == "http://127.0.0.1:8000/commande/votreClickAndCollect") {
        // Si oui, supprime la classe "commandLink" et ajoute la classe "commandBarre" à l'élément avec l'ID "tout"
        click.classList.remove("commandLink");
        click.classList.add("commandBarre");
    }
});