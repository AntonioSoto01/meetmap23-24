function iniciarMap(){
    var coord = {lat:40.402123186022784 ,lng: -3.706012514825723};
    var map = new google.maps.Map(document.getElementById('map'),{
      zoom: 10,
      center: coord
    });
    
    var marker = new google.maps.Marker({
      position: coord,
      map: map,
      title:"Hello World!"
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