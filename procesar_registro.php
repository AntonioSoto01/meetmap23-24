<?php
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificamos si los campos requeridos tienen datos
    if (
        isset($_POST['emailRegistro']) && isset($_POST['usernameRegistro']) &&
        isset($_POST['passwordRegistro']) && isset($_POST['confirmPasswordRegistro'])
    ) {
        // Recuperamos los datos del formulario
        $email = $_POST['emailRegistro'];
        $username = $_POST['usernameRegistro'];
        $password = $_POST['passwordRegistro'];
        $confirmPassword = $_POST['confirmPasswordRegistro'];

        // Validamos si las contraseñas coinciden
        if ($password !== $confirmPassword) {
            echo "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
            exit();
        }

        try {
            // Conexión a la base de datos usando las constantes definidas en config.php
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Comprobamos si el usuario ya existe
            $query_check_user = "SELECT * FROM Users WHERE username = :username OR email = :email LIMIT 1";
            $stmt_check_user = $db->prepare($query_check_user);
            $stmt_check_user->bindParam(':username', $username);
            $stmt_check_user->bindParam(':email', $email);
            $stmt_check_user->execute();
            $existing_user = $stmt_check_user->fetch();

            if ($existing_user) {
                echo "El usuario o correo electrónico ya está en uso.";
                exit();
            }

            // Preparamos la consulta para insertar los datos en la tabla Users
            $query_insert_user = "INSERT INTO Users (email, username, pw) VALUES (:email, :username, :pw)";
            $stmt_insert_user = $db->prepare($query_insert_user);

            // Hasheamos la contraseña antes de almacenarla (debes elegir tu propio método de hashing)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Bind de parámetros y ejecución
            $stmt_insert_user->bindParam(':email', $email);
            $stmt_insert_user->bindParam(':username', $username);
            $stmt_insert_user->bindParam(':pw', $hashedPassword); // Usamos la contraseña hasheada

            if ($stmt_insert_user->execute()) {
                // Redireccionamos a una página de éxito o realizamos alguna acción adicional
                header('Location: index_boostrap.php');
                exit();
            } else {
                echo "Error al registrar el usuario";
            }
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>
