<?php
// procesar_login.php

// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('common_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['formType'] === 'login') {
    $username = $_POST['usernameLogin'] ?? '';
    $password = $_POST['passwordLogin'] ?? '';

    $errors = validateFields([
        'usernameLogin' => 'Nombre de usuario',
        'passwordLogin' => 'Contraseña'
    ]);

    if (empty($errors)) {
        $query = "SELECT * FROM Users WHERE username = :username";
        $params = [':username' => $username];
        $stmt = executeQuery($query, $params);

        if ($stmt) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['pw'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];

                if (isset($_POST['remember'])) {
                    $cookie_name = "remember_user";
                    $cookie_value = $user['id'];
                    $cookie_expire = time() + 60 * 60 * 24 * 7; 
                    setcookie($cookie_name, $cookie_value, $cookie_expire, "/");
                }

                $previousPage = $_SESSION['previous_page'] ?? 'index.php';
                header("Location: $previousPage?msg=success");
                exit();
            } else {
                $errors['login'] = "El usuario o la contraseña son incorrectos.";
            }
        }
    }

    $_SESSION['errors'] = $errors;
    redirect(previous_page(), 'errorLogin', 'true');
}
?>
