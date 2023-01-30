var current = -1;
var deleteForm = document.querySelector('#deleteForm');
console.log("Fichier Javascript chargé : delete");

function supprimer(id) {
    current = id;
    console.log("Activité séléctionnée :");
    console.log(current);
}
function confirmer(url) {
    console.log("Suppression");
    deleteForm.action = url + "/" + current;
    deleteForm.submit();
}