
function mostrarRegistro() {
  document.getElementById('loginForm').style.display = 'none';
  document.getElementById('registroForm').style.display = 'block';
  localStorage.setItem('formularioActual', 'registro'); // Guardar el estado actual en localStorage
}

function mostrarLogin() {
  document.getElementById('registroForm').style.display = 'none';
  document.getElementById('loginForm').style.display = 'block';
  localStorage.setItem('formularioActual', 'login'); // Guardar el estado actual en localStorage
}

// Verificar si hay un formulario abierto previamente al cargar la página
window.onload = function() {
  var formularioActual = localStorage.getItem('formularioActual');
  if (formularioActual === 'registro') {
      mostrarRegistro(); // Mostrar el formulario de registro si estaba abierto
  } else {
      mostrarLogin(); // Mostrar el formulario de inicio de sesión por defecto
  }
};