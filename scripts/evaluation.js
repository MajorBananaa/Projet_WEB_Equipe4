document.getElementById("evalButton").addEventListener("click", function() {
    fetch("index.php?controller=search&action=evaluation", { 
        method: "POST",
    })
    .then(response => response.json()) 
    .then(data => {
        console.log("Réponse du serveur:", data);
        alert("Évaluation effectuée !");
    })
    .catch(error => console.error("Erreur :", error));
});