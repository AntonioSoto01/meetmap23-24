<?php
session_start();
require_once('common_functions.php');

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['token'])) {
        $token = $_POST['token'];
    } else {
        // Si no se proporciona el token en la URL, redirigir con un mensaje de error
        $_SESSION['errors'] = "Token no proporcionado.";
        header("Location: changePassword.php");
        exit();
    }

    // Validación de campos y lógica de actualización de contraseña
    $requiredFields = [
        'passwordRegistro' => 'Contraseña',
        'confirmPasswordRegistro' => 'Repetir contraseña'
    ];

    $errors = validateFields($requiredFields);

    if (empty($errors)) {
        $password = $_POST['passwordRegistro'];
        $confirmPassword = $_POST['confirmPasswordRegistro'];

        if ($password !== $confirmPassword) {
            $errors['confirmPasswordRegistro'] = "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
        }
        if (strlen($password) < 5) {
            $errors['passwordRegistro'] = 'La contraseña debe tener al menos 5 caracteres.';
        }

        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query_update_password = "UPDATE Users SET pw = :pw WHERE token = :token";
            $params_update_password = [':pw' => $hashedPassword, ':token' => $token];
            $stmt_update_password = executeQuery($query_update_password, $params_update_password);

            if ($stmt_update_password) {
                $query_delete_token = "UPDATE Users SET token = NULL WHERE token = :token";
                $params_delete_token = [':token' => $token];
                $stmt_delete_token = executeQuery($query_delete_token, $params_delete_token);

                // Redirigir a una página de éxito o a donde corresponda
                header("Location: passwordUpdated.php");
                exit();
            } else {
                $errors['errors'] = "Error al actualizar la contraseña.";
            }
        }
    }
}

// Si hay errores, almacenarlos en sesión y redirigir de vuelta al formulario con el token
$_SESSION['errors'] = $errors;
header("Location: changePassword.php?token=$token");
exit();
?>
