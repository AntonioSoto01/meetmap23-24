<?php
require_once('procesar_login.php');

$errores = procesarLogin($_POST);

if (!empty($errores)) {
    $errorMessages = "<ul>";
    foreach ($errores as $error) {
        $errorMessages .= "<li>$error</li>";
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
        <input type="hidden" name="formType" value="login">

        <div class="form-group">
            <label for="usernameLogin">Nombre de usuario</label>
            <input type="text" class="form-control" id="usernameLogin" name="usernameLogin" placeholder="Ingrese su nombre de usuario">
            <?php if(isset($errores['usernameLogin'])) { ?>
                <span class="error"><?=$errores['usernameLogin']?></span>
            <?php } ?>
        </div>

        <div class="form-group">
            <label for="passwordLogin">Contraseña</label>
            <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" placeholder="Ingrese su contraseña">
            <?php if(isset($errores['passwordLogin'])) { ?>
                <span class="error"><?=$errores['passwordLogin']?></span>
            <?php } ?>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-custom-color btn-md text-white">Iniciar sesión</button>
        </div>

        <p class="mt-3 text-center">¿No tienes una cuenta? <a href="#" class="text-primary" onclick="mostrarRegistro()">Regístrate aquí</a></p>
    </form>
