<?php
require_once('common_functions.php');
require_once("php_mailer.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['emailRegistro'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors']['emailRegistro'] = 'El correo electrónico no tiene un formato válido.';
        redirect('formulario_recuperar_contraseña.php', 'errorRecuperacion', 'true');
    }

    $userExists = checkExistingUserEmailForPasswordRecovery($email);

    if ($userExists) {

        $token = bin2hex(random_bytes(16));


        storeTokenInDatabase($email, $token);

   
        $asunto = 'Recuperación de contraseña';
        $cuerpo = 'Hola, has solicitado recuperar tu contraseña. Haz clic en el siguiente enlace para cambiar tu contraseña: <a href="link_para_resetear_contraseña.php?token=' . $token . '">Restablecer contraseña</a>';
        
        $envioExitoso = enviarCorreo($email, $asunto, $cuerpo);
if ($envioExitoso) {
    header("Location: confirmacion_recuperacion_contraseña.php");
    exit();
}else{echo("edfea");

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
function storeTokenInDatabase($email, $token) {
    // Establece la conexión a tu base de datos
    // ...

    // Prepara y ejecuta la consulta para actualizar el token del usuario
    $query = "UPDATE Users SET token = :token WHERE email = :email";
    $params = [':token' => $token, ':email' => $email];
    executeQuery($query, $params);

    // Cierra la conexión a la base de datos
    // ...
}
?>
