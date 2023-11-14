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