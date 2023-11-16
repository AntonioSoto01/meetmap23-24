<?php
require_once('config.php');

function procesarRegistro($postData) {
    $errores = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enviar'])) {
        $campos = ['emailRegistro' => 'Email', 'usernameRegistro' => 'Nombre de usuario', 'passwordRegistro' => 'Contraseña', 'confirmPasswordRegistro' => 'Confirmar Contraseña'];

        foreach ($campos as $campo => $label) {
            if (isset($_POST[$campo]) && $_POST[$campo] !== '') {
                ${$campo} = $_POST[$campo];
            } else {
                $errores[$campo] = "El campo $label es obligatorio.";
            }
        }
        // Recuperar datos del formulario si no hay errores en los campos requeridos
        if (empty($errores)) {
            $email = $_POST['emailRegistro'];
            $username = $_POST['usernameRegistro'];
            $password = $_POST['passwordRegistro'];
            $confirmPassword = $_POST['confirmPasswordRegistro'];

            // Validar si las contraseñas coinciden
            if ($password !== $confirmPassword) {
                $errores[] = "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
            }

            try {
                // Establecer conexión a la base de datos utilizando las constantes definidas en config.php
                $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Comprobar si el usuario ya existe
                $query_check_user = "SELECT * FROM Users WHERE username = :username OR email = :email LIMIT 1";
                $stmt_check_user = $db->prepare($query_check_user);
                $stmt_check_user->bindParam(':username', $username);
                $stmt_check_user->bindParam(':email', $email);
                $stmt_check_user->execute();
                $existing_user = $stmt_check_user->fetch();

                if ($existing_user) {
                    $errores[] = "El usuario o correo electrónico ya está en uso.";
                }

                if (empty($errores)) {
                    $query_insert_user = "INSERT INTO Users (email, username, pw) VALUES (:email, :username, :pw)";
                    $stmt_insert_user = $db->prepare($query_insert_user);
                    $stmt_insert_user->bindParam(':email', $email);
                    $stmt_insert_user->bindParam(':username', $username);
                    $stmt_insert_user->bindParam(':pw', $password);

                    if ($stmt_insert_user->execute()) {

                        exit();
                    } else {
                        $errores[] = "Error al registrar el usuario.";
                    }
                }
            } catch (PDOException $e) {
                $errores[] = "Error de conexión: " . $e->getMessage();
            }
        }
    }

    return $errores;
}
?>
