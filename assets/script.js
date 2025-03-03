document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("search");
    const checkboxes = document.querySelectorAll(".sidebar input[type='checkbox']");
    const rangeFilter = document.getElementById("rangeFilter");
    const salaireValue = document.getElementById("salaireValue");
    const dureeSelect = document.querySelector(".sidebar select[name='duree']");
    const tailleSelect = document.querySelector(".sidebar select[name='taille']");
    const items = Array.from(document.querySelectorAll(".result-item"));
    const noResultsMessage = document.getElementById("no-results");

    const prevButton = document.getElementById("prevPage");
    const nextButton = document.getElementById("nextPage");
    const pageInfo = document.getElementById("pageInfo");

    let currentPage = 1;
    const itemsPerPage = 1;
    let filteredItems = [];

    function filterResults() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedFilters = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);
        const selectedSalaire = parseInt(rangeFilter.value, 10);
        const selectedDuree = dureeSelect.value;
        const selectedTaille = tailleSelect.value;

        filteredItems = items.filter(item => {
            const category = item.dataset.category || "";
            const salaire = parseInt(item.dataset.salaire || "0", 10);
            const remote = item.dataset.remote || "non";
            const itemText = item.innerText.toLowerCase();

            const matchesSearch = itemText.includes(searchTerm);
            const matchesCategory = selectedFilters.length === 0 || selectedFilters.includes(category) || (selectedFilters.includes("remote") && remote === "oui");
            const matchesSalaire = salaire >= selectedSalaire;
            const matchesDuree = selectedDuree === "" || itemText.includes(`${selectedDuree} mois`);
            const matchesTaille = selectedTaille === "" || itemText.includes(selectedTaille);

            return matchesSearch && matchesCategory && matchesSalaire && matchesDuree && matchesTaille;
        });

        noResultsMessage.style.display = filteredItems.length === 0 ? "flex" : "none";

        currentPage = 1;
        showPage();
    }

    function showPage() {
        const totalPages = Math.ceil(filteredItems.length / itemsPerPage) || 1;
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        items.forEach(item => (item.style.display = "none"));
        filteredItems.slice(start, end).forEach(item => (item.style.display = "flex"));

        pageInfo.textContent = `Page ${currentPage} / ${totalPages}`;
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage >= totalPages;
    }

    prevButton.addEventListener("click", () => {
        if (currentPage > 1) {
            currentPage--;
            showPage();
        }
    });

    nextButton.addEventListener("click", () => {
        const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            showPage();
        }
    });

    searchInput.addEventListener("input", filterResults);
    checkboxes.forEach(cb => cb.addEventListener("change", filterResults));
    rangeFilter.addEventListener("input", () => {
        salaireValue.textContent = `${rangeFilter.value} €`;
        filterResults();
    });
    dureeSelect.addEventListener("change", filterResults);
    tailleSelect.addEventListener("change", filterResults);

    filterResults();
});
