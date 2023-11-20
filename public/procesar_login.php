<?php
session_start();
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['formType'] === 'login') {
    $username = $_POST['usernameLogin'] ?? '';
    $password = $_POST['passwordLogin'] ?? '';

    $errores = [];

    if (empty($username)) {
        $errores['usernameLogin'] = "El campo Nombre de usuario es obligatorio.";
    }

    if (empty($password)) {
        $errores['passwordLogin'] = "El campo Contraseña es obligatorio.";
    }

    if (empty($errores)) {
        try {
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM Users WHERE username = :username";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['pw'])) {
                $_SESSION['username'] = $user['username']; 
                $previousPage = $_SESSION['previous_page'] ?? 'index.php';
                header("Location: $previousPage?msg=success");
                exit();
            } else {
                $errores['login'] = "El usuario o la contraseña son incorrectos.";
            }
        } catch (PDOException $e) {
            $errores['login'] = "Error de conexión: " . $e->getMessage();
        }
    }

    $_SESSION['errores'] = $errores;
    $previousPage = $_SESSION['previous_page'] ?? 'index.php';
    header("Location: $previousPage?errorLogin=true");
    exit();
}
?>
