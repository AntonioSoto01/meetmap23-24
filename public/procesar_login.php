<?php
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