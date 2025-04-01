function togglePopup(id) {
  const popup = document.getElementById("popup-overlay");
  popup.classList.toggle("open");

  document.getElementById("offer-id").value = id;
  console.log("Popup toggled, offer_id set to:", id);
}

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("application-form");

  if (form) {
      form.addEventListener("submit", function (e) {
          e.preventDefault();

          const offerId = document.getElementById("offer-id").value;
          if (!offerId) {
              alert("Erreur : l'ID de l'offre est manquant !");
              return;
          }

          console.log("CV:", form.cv.files[0]);
          console.log("Lettre de motivation:", form.motivation.value);
          console.log("Offer ID:", offerId);

          form.submit();
      });
  }
});
