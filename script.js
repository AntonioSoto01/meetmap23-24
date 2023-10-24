function iniciarMap() {
  var coord = { lat: 40.402123186022784, lng: -3.706012514825723 };
  var coord2 = { lat: 40.404872, lng: -3.702548 };
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: coord
  });

  var marker1 = new google.maps.Marker({
    position: coord,
    map: map,
    title: "Ejemplo"
  });

  var marker2 = new google.maps.Marker({
    position: coord2,
    map: map,
    title: "Ejemplo2"
  });

  var infoWindow1 = new google.maps.InfoWindow({
    content: `
      <h3>Título del Marcador 1</h3>
      <p>Descripción del Marcador 1.</p>
      <p>Fecha: 2023-10-10</p>
      <p>Hora: 15:30</p>
    `
  });

  var infoWindow2 = new google.maps.InfoWindow({
    content: `
      <h3>Título del Marcador 2</h3>
      <p>Descripción del Marcador 2.</p>
      <p>Fecha: 2023-10-11</p>
      <p>Hora: 16:45</p>
    `
  });

  marker1.addListener("mouseover", function () {
    infoWindow1.open(map, marker1);
  });

  marker1.addListener("mouseout", function () {
    infoWindow1.close();
  });

  marker2.addListener("mouseover", function () {
    infoWindow2.open(map, marker2);
  });

  marker2.addListener("mouseout", function () {
    infoWindow2.close();
  });
}



var mostrarPopupBtn = document.getElementById("mostrarPopup");
var cerrarPopupBtn = document.getElementById("cerrarPopup");
var popup = document.getElementById("popup");

// Mostrar el cuadro emergente al hacer clic en "Iniciar sesión"
mostrarPopupBtn.addEventListener("click", function () {
  popup.style.display = "block";
});

// Ocultar el cuadro emergente al hacer clic en el icono de cierre
cerrarPopupBtn.addEventListener("click", function () {
  popup.style.display = "none";
});

// Ocultar el cuadro emergente si se hace clic fuera de él
window.addEventListener("click", function (event) {
  if (event.target === popup) {
      popup.style.display = "none";
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const menu = document.getElementById("menu");

  // Agrega una clase para mostrar el menú lateral por defecto
  menu.classList.add("menu-lateral-abierto");
});

// Crear objetos InfoWindow para cada marcador
var infoWindow1 = new google.maps.InfoWindow({
  content: `
    <h3>Título del Marcador 1</h3>
    <p>Descripción del Marcador 1.</p>
    <p>Fecha: 2023-10-10</p>
    <p>Hora: 15:30</p>
  `
});

var infoWindow2 = new google.maps.InfoWindow({
  content: `
    <h3>Título del Marcador 2</h3>
    <p>Descripción del Marcador 2.</p>
    <p>Fecha: 2023-10-11</p>
    <p>Hora: 16:45</p>
  `
});
