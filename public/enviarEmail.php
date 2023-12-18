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


$asunto = 'Recuperación de contraseña';
$cuerpo = 'Hola, has solicitado recuperar tu contraseña. ¡Haz clic en el enlace para cambiar tu contraseña!';
$envioExitoso = enviarCorreo($email, $asunto, $cuerpo);
if ($envioExitoso) {
    redirect(previous_page(), 'success', 'true');
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

?>
