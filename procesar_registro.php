
<?php
session_start();
require_once('config.php');

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['formType'] === 'register') {
        $camposRequeridos = [
            'emailRegistro' => 'Correo electrónico',
            'usernameRegistro' => 'Nombre de usuario',
            'passwordRegistro' => 'Contraseña',
            'confirmPasswordRegistro' => 'Repetir contraseña'
        ];

        foreach ($camposRequeridos as $campo => $nombreCampo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                $errores[$campo] = "El campo $nombreCampo es obligatorio";
            }
        }

        if (empty($errores)) {
            $email = $_POST['emailRegistro'];
            $username = $_POST['usernameRegistro'];
            $password = $_POST['passwordRegistro'];
            $confirmPassword = $_POST['confirmPasswordRegistro'];

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
                        $errores['repetido'] = "El usuario o correo electrónico ya está en uso.";
                    } else {
                        // Hash de la contraseña antes de almacenarla en la base de datos
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        // Insertar usuario con la contraseña cifrada
                        $query_insert_user = "INSERT INTO Users (email, username, pw) VALUES (:email, :username, :pw)";
                        $stmt_insert_user = $db->prepare($query_insert_user);
                        $stmt_insert_user->bindParam(':email', $email);
                        $stmt_insert_user->bindParam(':username', $username);
                        $stmt_insert_user->bindParam(':pw', $hashedPassword); // Utiliza la contraseña cifrada

                        if ($stmt_insert_user->execute()) {
                            // Redirigir a una página de éxito o realizar alguna acción adicional
                            header("Location: index_boostrap.php?msg=success");
                            exit();
                        } else {
                            $errores['repetido'] = "Error al registrar el usuario.";
                        }
                    }
                } catch (PDOException $e) {
                    $errores['repetido'] = "Error de conexión: " . $e->getMessage();
                }
            }
        }

        if (!empty($errores)) {

            $_SESSION['errores'] = $errores; // Almacenamos los errores en una clave diferente
            $previousPage = $_SESSION['previous_page'] ?? 'index_boostrap.php';
            header("Location: $previousPage?errorRegistro=true");
            exit();
        }
    }
}
?>