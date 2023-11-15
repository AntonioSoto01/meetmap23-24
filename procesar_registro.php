<?php
require_once('config.php');

// Inicializar el array de errores
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se enviaron los campos requeridos
    if (
        isset($_POST['emailRegistro']) && isset($_POST['usernameRegistro']) &&
        isset($_POST['passwordRegistro']) && isset($_POST['confirmPasswordRegistro'])
    ) {
        // Recuperar datos del formulario
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

            // Insertar usuario si no hay errores
            if (empty($errores)) {
                $query_insert_user = "INSERT INTO Users (email, username, pw) VALUES (:email, :username, :pw)";
                $stmt_insert_user = $db->prepare($query_insert_user);
                $stmt_insert_user->bindParam(':email', $email);
                $stmt_insert_user->bindParam(':username', $username);
                $stmt_insert_user->bindParam(':pw', $password);

                if ($stmt_insert_user->execute()) {
                    // Redirigir a una página de éxito o realizar alguna acción adicional
                    header('Location: index_boostrap.php');
                    exit();
                } else {
                    $errores[] = "Error al registrar el usuario.";
                }
            }
        } catch (PDOException $e) {
            $errores[] = "Error de conexión: " . $e->getMessage();
        }
    } else {
        $errores[] = "Todos los campos son obligatorios.";
    }
}
?>