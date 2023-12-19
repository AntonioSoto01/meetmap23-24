<?php
session_start();
session_unset(); 
if (isset($_COOKIE['remember'])) {
    unset($_COOKIE['remember']);
    setcookie('remember', '', time() - 3600, '/'); // Establecer el tiempo de expiración en el pasado
}
session_destroy(); 

header("Location: index.php");
exit; 
?>
