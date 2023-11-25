<?php
require_once('common_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['formType'] === 'register') {
    $requiredFields = [
        'emailRegistro' => 'Correo electrónico',
        'usernameRegistro' => 'Nombre de usuario',
        'passwordRegistro' => 'Contraseña',
        'confirmPasswordRegistro' => 'Repetir contraseña'
    ];

    $errors = validateFields($requiredFields);

    if (empty($errors)) {
        $email = $_POST['emailRegistro'];
        $username = $_POST['usernameRegistro'];
        $password = $_POST['passwordRegistro'];
        $confirmPassword = $_POST['confirmPasswordRegistro'];

        if ($password !== $confirmPassword) {
            $errors['confirmPasswordRegistro'] =  "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";;
        }

        $checkUser = checkExistingUserEmail($username, $email);

        if ($checkUser['exists']) {
            $errors['errors'] =  "El usuario o correo electrónico ya está en uso.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query_insert_user = "INSERT INTO Users (email, username, pw) VALUES (:email, :username, :pw)";
            $params_insert_user = [':email' => $email, ':username' => $username, ':pw' => $hashedPassword];
            $stmt_insert_user = executeQuery($query_insert_user, $params_insert_user);

            if ($stmt_insert_user) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                $previousPage = $_SESSION['previous_page'] ?? 'index.php';
                header("Location: $previousPage?msg=success");
                exit();
            } else {
                $errors['errors'] = "Error al registrar el usuario.";;
            }
        }
    }

    $_SESSION['errors'] = $errors;
    redirect(previous_page(),'errorRegistro', 'true');
}
?>
