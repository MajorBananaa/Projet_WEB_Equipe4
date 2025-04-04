function togglePopup(id) {
  const popup = document.getElementById("popup-overlay");
  popup.classList.toggle("open");

  document.getElementById("offer-id").value = id;
}

function togglePopupModif(id) {
  const popup = document.getElementById("popup-overlay-modif");
  popup.classList.toggle("open");

  document.getElementById("offer-id-upd").value = id;
}

function togglePopupAdd() {
  const popup = document.getElementById("popup-overlay-add");
  popup.classList.toggle("open");
}

function togglePopupSupr(id) {
  const popup = document.getElementById("popup-overlay-supr");
  popup.classList.toggle("open");

  document.getElementById("id-supr").value = id;
}

function togglePopupAddWish(id) {
  const popup = document.getElementById("popup-overlay-add-wish");
  popup.classList.toggle("open");

  document.getElementById("offer-id-addWish").value = id;
}
function togglePopupSuprWish(id) {
  const popup = document.getElementById("popup-overlay-supr-wish");
  popup.classList.toggle("open");

  document.getElementById("offer-id-suprWish").value = id;
}
function togglePopupAddEval(id) {
  const popup = document.getElementById("popup-overlay-add-eval");
  popup.classList.toggle("open");

  document.getElementById("offer-id-addEval").value = id;
}
function togglePopupSuprEval(id) {
  const popup = document.getElementById("popup-overlay-supr-eval");
  popup.classList.toggle("open");

  document.getElementById("offer-id-suprEval").value = id;
}

document.addEventListener("DOMContentLoaded", function () {
  const salaireRange = document.querySelector(".salaire-range");
  const salaireValeur = document.querySelector(".salaire-valeur");

  if (salaireRange && salaireValeur) {
    salaireRange.min = 0;
    salaireRange.max = 3000;
    salaireValeur.textContent = salaireRange.value + " €";

    let lastValue = parseInt(salaireRange.value);
    let lastTimestamp = Date.now();

    salaireRange.addEventListener("input", function (event) {
      let currentValue = parseInt(event.target.value);
      let currentTime = Date.now();
      let deltaTime = (currentTime - lastTimestamp) / 1000; // Temps écoulé en secondes
      let deltaValue = Math.abs(currentValue - lastValue);

      let speed = deltaValue / deltaTime; // Vitesse de déplacement du curseur
      let increment = Math.max(1, Math.floor(speed / 5));

      let newValue;
      if (currentValue > lastValue) {
        // On augmente vers 3000
        newValue = Math.min(3000, currentValue + increment);
      } else {
        // On diminue vers 0
        newValue = Math.max(0, currentValue - increment);
      }

      salaireValeur.textContent = newValue + " €";
      lastValue = currentValue;
      lastTimestamp = currentTime;
    });
  } else {
    console.error("Élément non trouvé !");
  }
});