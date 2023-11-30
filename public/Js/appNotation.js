function selectStarts(e){
    const data = e.target

    const etoiles = previousSiblings(data);

    etoiles.forEach(etoile => {
        etoile.classList.remove("fa-regular", "fa-star");
        etoile.classList.add('fa-solid', 'fa-star');
    })

    data.addEventListener('mouseover', unselectStarts);
}

function unselectStarts(e){
    const data = e.target

    const etoiles = previousSiblings(data);

    etoiles.forEach(etoile => {
        etoile.classList.remove("fa-solid", "fa-star");
        data.classList.add('fa-regular', 'fa-star');
    })

    data.removeEventListener('mouseover', unselectStarts);
}

function previousSiblings(data){
    let values = [data];
    while(data = data.previousSibling){
        if(data.nodeName === "I"){
            values.push(data);
        }
    }

    return values;
}

document.addEventListener('DOMContentLoaded', function() {
    const starsVides = document.querySelectorAll(".fa-regular.fa-star");

    starsVides.forEach(starsVide => {
        starsVide.addEventListener('mouseover', selectStarts);
    });
});