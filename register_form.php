
<?php
require_once('procesar_registro.php');

// $errores = procesarRegistro();
if (isset($_GET['errorRegistro']) && $_GET['errorRegistro'] === 'true' && isset($_GET['errores'])) {
    $errores = json_decode($_GET['errores'], true);

    // Verificar si hubo un error al decodificar el JSON
    if ($errores === null && json_last_error() !== JSON_ERROR_NONE) {
        // Manejar el error de decodificación JSON
        // Por ejemplo, mostrar un mensaje de error o realizar una acción adecuada.
        echo "Error al decodificar el JSON de errores.";
    } else {
        // El JSON se decodificó correctamente, se puede utilizar la variable $errores.
        // Ejemplo: var_dump($errores);
    }
}
// Tu código HTML existente...

// if (!empty($errores)) {
//     $errorMessages = "<ul>";
//     foreach ($errores as $error) {
//         $errorMessages .= "<li>$error</li>";
//     }
//     $errorMessages .= "</ul>";

//     // Generar un script para mostrar la alerta de SweetAlert con los errores
//     echo "<script>
//         document.addEventListener('DOMContentLoaded', function() {
//             // Utilizando SweetAlert para mostrar los errores después de que la página se cargue
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Oops...',
//                 html: '$errorMessages'
//             });
//         });
//     </script>";
// }
?>

<form action="" method="post">
        <input type="hidden" name="formType" value="register">

        <div class="form-group">
            <label for="emailRegistro">Correo electrónico</label>
            <input type="email" class="form-control" id="emailRegistro" name="emailRegistro"
                placeholder="Ingrese su correo electrónico">
            <?php if(isset($errores['emailRegistro'])) { ?>
                <span class="error"><?=$errores['emailRegistro']?></span>
            <?php } ?>
        </div>

        <div class="form-group">
            <label for="usernameRegistro">Nombre de usuario</label>
            <input type="text" class="form-control" id="usernameRegistro" name="usernameRegistro"
                placeholder="Ingrese su nombre de usuario">
            <?php if(isset($errores['usernameRegistro'])) { ?>
                <span class="error"><?=$errores['usernameRegistro']?></span>
            <?php } ?>
        </div>

        <div class="form-group">
            <label for="passwordRegistro">Contraseña</label>
            <input type="password" class="form-control" id="passwordRegistro" name="passwordRegistro"
                placeholder="Ingrese su contraseña">
            <?php if(isset($errores['passwordRegistro'])) { ?>
                <span class="error"><?=$errores['passwordRegistro']?></span>
            <?php } ?>
        </div>

        <div class="form-group">
            <label for="confirmPasswordRegistro">Repetir contraseña</label>
            <input type="password" class="form-control" id="confirmPasswordRegistro" name="confirmPasswordRegistro"
                placeholder="Repita su contraseña">
            <?php if(isset($errores['confirmPasswordRegistro'])) { ?>
                <span class="error"><?=$errores['confirmPasswordRegistro']?></span>
            <?php } ?>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-custom-color text-white">Registrarse</button>
        </div>

        <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="#" class="text-primary" onclick="mostrarLogin()">Inicia sesión aquí</a></p>
    </form>