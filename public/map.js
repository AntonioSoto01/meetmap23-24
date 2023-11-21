var map = L.map('map').setView([51.505, -0.09], 13);

L.control.locate().addTo(map);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var markerIcon = L.icon({
    iconUrl: './images/marker_custom.png',
    iconSize: [38, 76],
    iconAnchor: [10, 76],
    popupAnchor: [10, -60]
});

var markers = L.markerClusterGroup(); // Crea un grupo de marcadores

// Obtener datos de la base de datos
fetch('/api/evento.php')
    .then(response => response.json())
    .then(data => {
        // Iterar sobre los datos obtenidos y crear marcadores dinámicamente
        data.forEach(activity => {
            const latitude = activity.latitude;
            const longitude = activity.longitude;
            const id = activity.id; // ID de la actividad
            const name = activity.name;
            const description = activity.description.substring(0, 100);
            const date = activity.date;
            const time = activity.time.substring(0, 5);;

            // Crear marcador dinámico y añadirlo al grupo de marcadores
            var marker = L.marker([latitude, longitude], { icon: markerIcon });

            // Agregar contenido al popup
            marker.bindPopup(`<a class="text-decoration-none" href="detalle.php?id=${id}">
                <div class="titulo-marker">
                    <strong>${name}</strong>
                </div>
                <div class="desc-marker">
                    <p>${description}</p>
                    <div class="fecha-marker">
                        <div>${date}</div>
                        <div>${time}</div>
                    </div>
                </div></a>`
            );

            markers.addLayer(marker); // Agregar el marcador al grupo
        });

        // Agregar el grupo de marcadores al mapa después de crear todos los marcadores
        map.addLayer(markers);
    })
    .catch(error => {
        console.error('Error al obtener datos:', error);
    });
