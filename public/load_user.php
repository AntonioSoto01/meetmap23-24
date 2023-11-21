<?php
session_start();
require_once('common_functions.php');

// Verificar la sesión o autenticación del usuario
if (!isset($_SESSION['user_id'])) {
    redirect('index.php', '');
}

$user_id = $_SESSION['user_id'];
$userData = obtenerDatosUsuario($user_id);

if (!$userData) {
    // Si ocurre un error al obtener los datos del usuario, redirigir a alguna página de error o a la página de inicio
    redirect('index.php', '');
}

// Función para obtener los datos del usuario
function obtenerDatosUsuario($user_id) {
    $query = "SELECT username, name, last_name, phone_number, email, descr FROM Users WHERE id = :user_id";
    $params = [':user_id' => $user_id];
    $stmt = executeQuery($query, $params);

    if ($stmt) {
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userData;
    } else {
        return false;
    }
}
?>
