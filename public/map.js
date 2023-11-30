
var map = L.map("map", {
    zoomControl: false
}).setView([40.402332380619, -3.706442933837893], 13);;

L.control.zoom({ position: 'topright' }).addTo(map);

L.control.locate({ position: 'bottomright' }).addTo(map);

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

var markers = L.markerClusterGroup();

fetch('api/evento.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(activity => {
            const latitude = activity.latitude;
            const longitude = activity.longitude;
            const id = activity.id;
            const name = activity.name;
            const description = activity.description.substring(0, 100);
            const date = activity.date;
            const time = activity.time.substring(0, 5);

            var marker = L.marker([latitude, longitude], { icon: markerIcon });

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

            markers.addLayer(marker);
        });

        map.addLayer(markers);
    })
    .catch(error => {
        console.error('Error al obtener datos:', error);
    });
