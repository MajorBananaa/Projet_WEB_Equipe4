function togglePopup() {
    const popup = document.getElementById("popup-overlay");
    popup.classList.toggle("open");
    document.getElementById("offer-id").value = offerId;
    console.log("Popup toggled:" + offerId);
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