// Sélectionne l'élément HTML avec l'ID "search" et le stocke dans la variable searchInput.
const searchInput = document.querySelector("#search");

// Sélectionne l'élément HTML avec la classe "card-result" et le stocke dans la variable searchResult.
const searchResult = document.querySelector(".card-result");

// Déclare une variable globale dataArray.
let dataArray;

// Définit la fonction getUsers.
function getUsers() {
    // Sélectionne tous les éléments avec la classe "input-hidden" et les stocke dans la variable listUsers.
    const listUsers = document.querySelectorAll(".input-hidden");

    // Initialise un tableau vide listEmails.
    const listEmails = [];

    // Parcourt chaque élément de listUsers.
    listUsers.forEach(user => {
        // Ajoute la valeur de l'élément actuel à listEmails.
        listEmails.push(user.value);
    });

    // Trie les emails dans l'ordre alphabétique et stocke le résultat dans dataArray.
    dataArray = orderList(listEmails);

    // Appelle la fonction createUserList avec dataArray en argument.
    createUserList(dataArray);
}

// Appelle la fonction getUsers.
getUsers();

// Définit la fonction orderList qui trie les éléments dans l'ordre alphabétique.
function orderList(data) {
    const orderedData = data.sort((a, b) => {
        if (a.toLowerCase() < b.toLowerCase()) {
            return -1;
        }
        if (a.toLowerCase() > b.toLowerCase()) {
            return 1;
        }
        return 0;
    });

    // Retourne le tableau trié.
    return orderedData;
}

// Définit la fonction createUserList qui crée des éléments HTML pour chaque utilisateur.
function createUserList(usersList) {
    // Parcourt chaque utilisateur dans usersList.
    usersList.forEach(user => {
        // Crée un élément div avec la classe "userCard" et le stocke dans la variable listItem.
        const listItem = document.createElement("div");
        listItem.setAttribute("class", "userCard");

        // Ajoute du HTML à l'élément listItem avec le nom de l'utilisateur et un lien.
        listItem.innerHTML = `
        <span>${user}</span>
        <a href="/admin/ban/${user}"><i class="fa-regular fa-circle-xmark" style="color: #ffffff;"></i></a>
        `;

        // Ajoute l'élément listItem à searchResult.
        searchResult.appendChild(listItem);
    });
}

// Ajoute un écouteur d'événements sur l'input pour déclencher la fonction filterData.
searchInput.addEventListener("input", filterData);

// Définit la fonction filterData qui filtre les utilisateurs en fonction de la saisie dans l'input.
function filterData(e) {
    // Efface le contenu de searchResult.
    searchResult.innerHTML = "";

    // Convertit la saisie en minuscules.
    const searchString = e.target.value.toLowerCase();

    // Filtre dataArray en fonction de la saisie et stocke le résultat dans filteredArr.
    const filteredArr = dataArray.filter(el => el.toLowerCase().includes(searchString));

    // Appelle la fonction createUserList avec filteredArr en argument.
    createUserList(filteredArr);
}
