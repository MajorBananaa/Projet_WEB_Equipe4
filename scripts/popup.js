function togglePopup() {
    const popup = document.getElementById("popup-overlay");
    popup.classList.toggle("open");
  }
  
  document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("application-form");
  
    if (form) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        alert("Candidature envoyée !");
        togglePopup();
      });
    }
  });