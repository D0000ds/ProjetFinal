// Récupère l'URL actuelle de la page
let currentURL = window.location.href;

let id = document.getElementById("idArticle").value;

if(currentURL == "http://127.0.0.1:8000/avis/post/"+ id || "http://127.0.0.1:8000/avis/edit/"+ id){
    let check = false;
    const note = document.querySelector("#note");
    
    // Fonction pour gérer la sélection des étoiles au survol de la souris
    function selectStars(e){
        const data = e.target
    
        // Obtenir les étoiles précédentes
        const etoiles = previousSiblings(data);
    
        // Si non vérifié, changer les icônes d'étoiles et ajouter un écouteur d'événements de survol de la souris
        if(!check){
            etoiles.forEach(etoile => {
                etoile.classList.remove("fa-regular", "fa-star");
                etoile.classList.add('fa-solid', 'fa-star');
        
                etoile.addEventListener('mouseover', unselectStars);
            })
        }
    }
    
    // Fonction pour gérer la désélection des étoiles au survol de la souris
    function unselectStars(e){
        const data = e.target
    
        // Obtenir les étoiles suivantes
        const etoiles = nextSiblings(data);
        
        // Si non vérifié, changer les icônes d'étoiles et supprimer l'écouteur d'événements de survol de la souris
        if(!check){
            etoiles.forEach(etoile => {
                etoile.classList.remove("fa-solid", "fa-star");
                etoile.classList.add('fa-regular', 'fa-star');
                
                if(data == etoile){
                    etoile.classList.add('fa-solid', 'fa-star');
                }
                etoile.removeEventListener('mouseover', unselectStars);
            })
        }
    }
    
    // Fonction pour obtenir les éléments précédents d'un élément
    function previousSiblings(data){
        let values = [data];
    
        while(data = data.previousSibling){
            if(data.nodeName === "I"){
                values.push(data);
            }
        }
    
        return values;
    }
    
    // Fonction pour obtenir les éléments suivants d'un élément
    function nextSiblings(data){
        let values = [data];
        
        while(data = data.nextSibling){
            if(data.nodeName === "I"){
                values.push(data);
            }
        }
    
        return values;
    }
    
    // Fonction pour basculer la variable check lors du clic
    function Activeselect(e){
        if(!check){
            check = true;
        } else {
            check = false;
        }
    
        note.value = this.dataset.value;
    }
    
    // Écouteur d'événements lorsque le DOM est entièrement chargé
    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionner toutes les étoiles vides
        const starsVides = document.querySelectorAll(".fa-regular.fa-star");
    
        // Ajouter des écouteurs d'événements de survol de la souris et de clic à chaque étoile vide
        starsVides.forEach(starsVide => {
            starsVide.addEventListener('mouseover', selectStars);
            starsVide.addEventListener('click', Activeselect);
        });
    });
}
