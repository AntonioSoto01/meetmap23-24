<?php
require_once('config.php');

function procesarRegistro() {
    $errores = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se enviaron los campos requeridos
        $camposRequeridos = ['emailRegistro', 'usernameRegistro', 'passwordRegistro', 'confirmPasswordRegistro'];
        
        foreach ($camposRequeridos as $campo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                $errores[$campo] = "El campo $campo es obligatorio";
            }
        }

        if (empty($errores)) {
            $email = $_POST['emailRegistro'];
            $username = $_POST['usernameRegistro'];
            $password = $_POST['passwordRegistro'];
            $confirmPassword = $_POST['confirmPasswordRegistro'];

            // Validar si las contraseñas coinciden
            if ($password !== $confirmPassword) {
                $errores['confirmPasswordRegistro'] = "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
            }

            // Si no hay errores de validación, proceder con la inserción en la base de datos
            if (empty($errores)) {
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
                    } else {
                        // Insertar usuario si no hay errores y el usuario no existe
                        $query_insert_user = "INSERT INTO Users (email, username, pw) VALUES (:email, :username, :pw)";
                        $stmt_insert_user = $db->prepare($query_insert_user);
                        $stmt_insert_user->bindParam(':email', $email);
                        $stmt_insert_user->bindParam(':username', $username);
                        $stmt_insert_user->bindParam(':pw', $password);

                        if ($stmt_insert_user->execute()) {
                            // Redirigir a una página de éxito o realizar alguna acción adicional
                            header("Location: index_boostrap.php?msg=success");
                            exit();
                        } else {
                            $errores[] = "Error al registrar el usuario.";
                        }
                    }
                } catch (PDOException $e) {
                    $errores[] = "Error de conexión: " . $e->getMessage();
                }
            }
        } else {
            $errores[] = "Todos los campos son obligatorios.";
        }
    }
    
    return $errores;
}

?>