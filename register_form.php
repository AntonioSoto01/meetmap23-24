<?php
require_once('procesar_registro.php');

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postData = [
        'emailRegistro' => $_POST['emailRegistro'],
        'usernameRegistro' => $_POST['usernameRegistro'],
        'passwordRegistro' => $_POST['passwordRegistro'],
        'confirmPasswordRegistro' => $_POST['confirmPasswordRegistro']
    ];

    $errores = procesarRegistro($postData);

    if (empty($errores)) {
        header('Location: index_boostrap.php');
        exit();
    }
}

if (!empty($errores)) {
    $errorMessages = "<ul>";
    foreach ($errores as $errores) {
        $errorMessages .= "<li>$errores</li>";
    }
    $errorMessages .= "</ul>";

    // Generar un script para mostrar la alerta de SweetAlert con los errores
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Utilizando SweetAlert para mostrar los errores después de que la página se cargue
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '$errorMessages'
            });
        });
    </script>";
}
?>
<form action="" method="post">
    <div class="form-group">
        <label for="emailRegistro">Correo electrónico</label>
        <input type="email" class="form-control" id="emailRegistro" name="emailRegistro"
            placeholder="Ingrese su correo electrónico">
    </div>
    <div class="form-group">
        <label for="usernameRegistro">Nombre de usuario</label>
        <input type="text" class="form-control" id="usernameRegistro" name="usernameRegistro"
            placeholder="Ingrese su nombre de usuario">
    </div>
    <div class="form-group">
        <label for="passwordRegistro">Contraseña</label>
        <input type="password" class="form-control" id="passwordRegistro" name="passwordRegistro"
            placeholder="Ingrese su contraseña">
    </div>
    <div class="form-group">
        <label for="confirmPasswordRegistro">Repetir contraseña</label>
        <input type="password" class="form-control" id="confirmPasswordRegistro" name="confirmPasswordRegistro"
            placeholder="Repita su contraseña">
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-custom-color text-white">Registrarse</button>
    </div>
    <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="#" class="text-primary" onclick="mostrarLogin()">Inicia
            sesión aquí</a></p>
</form>