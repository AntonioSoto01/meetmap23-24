<?php
require_once('common_functions.php');
require_once("php_mailer.php");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['emailRegistro'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors']['emailRegistro'] = 'El correo electrónico no tiene un formato válido.';
    }

    $userExists = checkExistingUserEmailForPasswordRecovery($email);

    if ($userExists) {
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        $expiration = date('Y-m-d H:i:s', strtotime('+10 minutes')); // Token expira en 10 minutos
        $tokenType = 'password_recovery'; // Tipo de token para recuperación de contraseña

        storeTokenInDatabase($email, $token, $expiration, $tokenType);

        $asunto = 'Recuperación de contraseña';
        $url = "http://localhost:3000/public/changePassword.php?token=" . $token;
        $cuerpo = 'Hola, has solicitado recuperar tu contraseña. Haz clic en el siguiente enlace para cambiar tu contraseña: <a href="' . $url . '">Restablecer contraseña</a>';

        $envioExitoso = enviarCorreo($email, $asunto, $cuerpo);

        if ($envioExitoso) {
            redirect(previous_page(), 'success', 'true');
            exit();
        } else {
            echo("Error al enviar el correo");
        }
    } else {
        $_SESSION['errors']['emailRecuperacion'] = 'El correo electrónico no está registrado.';
        redirect(previous_page(), '', '');
    }
}

function checkExistingUserEmailForPasswordRecovery($email) {
    $query = "SELECT * FROM Users WHERE email = :email";
    $params = [':email' => $email];
    $stmt = executeQuery($query, $params); 

    if ($stmt) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user !== false; 
    }
    return false;
}

function storeTokenInDatabase($email, $token, $expiration, $tokenType) {
    $query = "INSERT INTO Token (user_id, token_value, expiration_date, token_type) 
              SELECT id, :token, :expiration, :tokenType FROM Users WHERE email = :email";
    $params = [':token' => $token, ':expiration' => $expiration, ':tokenType' => $tokenType, ':email' => $email];
    executeQuery($query, $params);
}
?>
