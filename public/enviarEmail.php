<?php
require_once('common_functions.php');
require_once("php_mailer.php");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['emailRemember'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors']['emailRemember'] = 'El correo electrónico no tiene un formato válido.';
        header("Location:introducirEmail.php");
        exit();
    }

    $userExists = checkExistingUserEmailForPasswordRecovery($email);

    if ($userExists) {
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        date_default_timezone_set('Europe/Madrid');
        $expiration = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $tokenType = 'password_recovery';

        storeTokenInDatabase($email, $token, $expiration, $tokenType);

        $asunto = 'Recuperación de contraseña';
        $url = BASE_URL . "changePassword.php?token=" . $token;
        $cuerpo = 'Hola, has solicitado recuperar tu contraseña. Haz clic en el siguiente enlace para cambiar tu contraseña: <a href="' . $url . '">Restablecer contraseña</a>';

        $envioExitoso = enviarCorreo($email, $asunto, $cuerpo);

        if ($envioExitoso) {
            redirect(previous_page(), 'success', 'true');
            exit();
        } else {
            echo("Error al enviar el correo");
        }
    } else {
        $_SESSION['errors']['emailRemember'] = 'El correo electrónico no está registrado.';
        header("Location:introducirEmail.php");
        exit();
    }
}

function checkExistingUserEmailForPasswordRecovery($email) {
    $query = "SELECT * FROM Users WHERE email = :email";
    $params = [':email' => $email];
    $stmt = executeQuery($query, $params);

    if ($stmt) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario se registró con un proveedor de OAuth específico
        if ($user && !empty($user['oauth_provider'])) {
            $oauthProvider = $user['oauth_provider'];
            $_SESSION['errors']['emailRemember'] = "Los usuarios registrados con $oauthProvider no pueden recuperar su contraseña.";
            header("Location: introducirEmail.php");
            exit();
        }

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
