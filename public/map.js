var map = L.map('map').setView([51.505, -0.09], 13);

L.control.locate().addTo(map);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var markerIcon = L.icon({
    iconUrl: './images/marker_custom.png',
    iconSize:     [38, 76], // size of the icon
    iconAnchor:   [10, 76], // point of the icon which will correspond to marker's location
    popupAnchor:  [10, -60] // point from which the popup should open relative to the iconAnchor
});

// Obtener datos de la base de datos
fetch('./api/evento.php')
  .then(response => response.json())
  .then(data => {
    // Iterar sobre los datos obtenidos y crear marcadores dinámicamente
    data.forEach(activity => {
      const latitude = activity.latitude;
      const longitude = activity.longitude;
      const name = activity.name;

      // Crear marcador dinámico y añadirlo al mapa
      var marker = L.marker([latitude, longitude], { icon: markerIcon }).addTo(map);
      marker.bindPopup(`<b>${name}</b>`).openPopup();
    });
  })
  .catch(error => {
    console.error('Error al obtener datos:', error);
  });