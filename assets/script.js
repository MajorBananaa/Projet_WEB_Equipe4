document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("search");
    const checkboxes = document.querySelectorAll(".sidebar input[type='checkbox']");
    const rangeFilter = document.getElementById("rangeFilter");
    const salaireValue = document.getElementById("salaireValue");
    const dureeSelect = document.querySelector(".sidebar select[name='duree']");
    const tailleSelect = document.querySelector(".sidebar select[name='taille']");
    const items = document.querySelectorAll(".result-item");
    const noResultsMessage = document.getElementById("no-results");


    function filterResults() {

        let noOffers = true;
        
        // Récupération des données des filtres
        const searchTerm = searchInput.value.toLowerCase();
        const selectedFilters = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);
        const selectedSalaire = parseInt(rangeFilter.value, 10);
        const selectedDuree = dureeSelect.value;
        const selectedTaille = tailleSelect.value;

        // Filtrage des offres
        items.forEach(item => {
            const category = item.dataset.category || "";
            const salaire = parseInt(item.dataset.salaire || "0", 10);
            const remote = item.dataset.remote || "non";
            const itemText = item.innerText.toLowerCase();

            // Vérification offres / filtres
            const matchesSearch = itemText.includes(searchTerm);
            const matchesCategory = selectedFilters.length === 0 || selectedFilters.includes(category) || (selectedFilters.includes("remote") && remote === "oui");
            const matchesSalaire = salaire >= selectedSalaire;
            const matchesDuree = selectedDuree === "" || itemText.includes(`${selectedDuree} mois`);
            const matchesTaille = selectedTaille === "" || itemText.includes(selectedTaille);

            // Affichage ou non des offres
            if (matchesSearch && matchesCategory && matchesSalaire && matchesDuree && matchesTaille) {
                item.style.display = "flex";
                noOffers = false;
            } else {
                item.style.display = "none";
            }
        });

        // Affichage du message si aucun élément n'est visible
        if (noOffers) {
            noResultsMessage.style.display = "flex";
        } else {
            noResultsMessage.style.display = "none";
        }

    }

    // Écouteurs d'événements pour filtrer dynamiquement
    searchInput.addEventListener("input", filterResults);
    checkboxes.forEach(cb => cb.addEventListener("change", filterResults));
    rangeFilter.addEventListener("input", () => {
        salaireValue.textContent = `${rangeFilter.value} €`;
        filterResults();
    });
    dureeSelect.addEventListener("change", filterResults);
    tailleSelect.addEventListener("change", filterResults);
});
