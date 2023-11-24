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
document.querySelector('.like-label').addEventListener('click', function() {
    document.getElementById('likeSubmit').click();
});

