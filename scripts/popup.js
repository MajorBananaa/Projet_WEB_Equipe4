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
