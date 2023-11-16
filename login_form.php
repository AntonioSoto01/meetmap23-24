<?php
require_once('config.php');

function procesarLogin($postData) {
    $error = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLogin'])) {
        $campos = ['usernameLogin' => 'Nombre de usuario', 'passwordLogin' => 'Contraseña'];

        foreach ($campos as $campo => $label) {
            if (isset($_POST[$campo]) && $_POST[$campo] !== '') {
                ${$campo} = $_POST[$campo];
            } else {
                $error = "El campo $label es obligatorio.";
                return $error;
            }
        }

        try {
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM Users WHERE username = :username AND pw = :password";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password); // La contraseña aquí debería estar en texto plano

            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Validación directa en la consulta SQL
                header('Location: index_boostrap.php');
                exit();
            } else {
                $error = "El usuario o la contraseña son incorrectos.";
                return $error;
            }
        } catch (PDOException $e) {
            $error = "Error de conexión: " . $e->getMessage();
            return $error;
        }
    }

    return $error;
}

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
    <!-- Campos para iniciar sesión -->
    <div class="form-group">
        <label for="usernameLogin">Nombre de usuario</label>
        <input type="text" class="form-control" id="usernameLogin" name="usernameLogin" placeholder="Ingrese su nombre de usuario">
    </div>
    <div class="form-group">
        <label for="passwordLogin">Contraseña</label>
        <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" placeholder="Ingrese su contraseña">
    </div>
    <p><a href="#" class="text-primary">¿Has olvidado tu contraseña?</a></p>
    <div class="text-center">
        <button type="submit" class="btn btn-custom-color btn-md text-white">Iniciar sesión</button>
    </div>
    <p class="mt-3 text-center">¿No tienes una cuenta? <a href="#" class="text-primary" onclick="mostrarRegistro()">Regístrate aquí</a></p>
</form>
