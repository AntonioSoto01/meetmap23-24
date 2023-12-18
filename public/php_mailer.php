<?php
require '../vendor/autoload.php';
require_once("../config/config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




function enviarCorreo($destinatario, $asunto, $cuerpo) {
           //Create an instance; passing `true` enables exceptions
           $mail = new PHPMailer(true);
           //Server settings
           //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
           $mail->isSMTP();                                            //Send using SMTP
           $mail->Host       = SMTP_HOST;                              //Set the SMTP server to send through
           $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
           $mail->Username   = SMTP_USERNAME;                          //SMTP username
           $mail->Password   = SMTP_PASSWORD;   
           $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
           $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // Configuraciones adicionales
        $mail->setFrom('antonio.soto@educa.madrid.org', 'Nombre Remitente'); // Cambiar por tu correo y nombre
        $mail->addAddress($destinatario); // Agregar el destinatario
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;

        $mail->send();

        return true;

}
?>


