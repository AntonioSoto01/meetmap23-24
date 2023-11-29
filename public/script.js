function mostrarRegistro() {
    document.getElementById('loginContent').style.display = 'none';
    document.getElementById('registroContent').style.display = 'block';
    document.getElementById('loginRegistroModalLabel').innerText = 'Registrarse';
}

function mostrarLogin() {
    document.getElementById('registroContent').style.display = 'none';


    document.getElementById('loginContent').style.display = 'block';
    document.getElementById('loginRegistroModalLabel').innerText = 'Iniciar sesión';
}
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const errorLogin = params.get('errorLogin');
    const errorRegistro = params.get('errorRegistro');
    const successMsg = params.get('msg');

    if (successMsg === 'success') {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'El registro se realizó correctamente.',
            });
    }
    if (errorLogin === 'true') {
        mostrarLogin(); // Mostrar el formulario de inicio de sesión si hay un error de inicio de sesión
        $('#loginRegistroModal').modal('show'); 
    } else if (errorRegistro === 'true') {
        mostrarRegistro(); // Mostrar el formulario de registro si hay un error de registro
        $('#loginRegistroModal').modal('show'); 

    }


});


$(document).ready(function() {
    $('#toggleMenu').click(function() {
        $('#menuCollapse').toggleClass('collapsed');
        if ($('#menuCollapse').hasClass('collapsed')) {
            $('#menuCollapse').css('width', '15%');
            $('#menuCollapse').css('left', '0');
            $('#toggleMenu').css('left', '15%');
            $('#toggleMenu').attr('src', 'images/flecha-inversa.png'); // Cambiar la imagen al abrir el menú
        } else {
            $('#menuCollapse').css('width', '0');
            $('#menuCollapse').css('left', '-40px');
            $('#toggleMenu').css('left', '0');
            $('#toggleMenu').attr('src', 'images/flecha.png'); // Cambiar la imagen al cerrar el menú
        }
    });
});

function openInParentWindow(event) {
    event.preventDefault();
    
    if (window.self !== window.top) {
      window.top.location.href = event.target.href;
    } else {
      window.open(event.target.href, '_blank');
    }
  }

function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = null;
    }
}


