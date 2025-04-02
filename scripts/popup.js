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
};
