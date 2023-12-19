<?php
session_start();
session_unset(); 
if (isset($_COOKIE['remember_user'])) {
    unset($_COOKIE['remember_user']);
    setcookie('remember_user', '', time() - 3600, '/'); // Establecer el tiempo de expiración en el pasado
}
session_destroy(); 

header("Location: index.php");
exit; 
?>
