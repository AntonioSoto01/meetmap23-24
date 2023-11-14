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

            // Preparamos la consulta para insertar los datos en la tabla Users
            $query = "INSERT INTO Users (email, username) VALUES (:email, :username)";
            $stmt = $db->prepare($query);

            // Hasheamos la contraseña antes de almacenarla (debes elegir tu propio método de hashing)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Bind de parámetros y ejecución
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);

            if ($stmt->execute()) {
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
