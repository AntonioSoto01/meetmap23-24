<?php
session_start();
require_once('common_functions.php');

if (!isset($_SESSION['user_id'])) {
    redirect('index.php', '','');
}

$user_id = $_SESSION['user_id'];
$userData = obtenerDatosUsuario($user_id);

if (!$userData) {

    redirect('index.php', '','');
}

function obtenerDatosUsuario($user_id) {
    $query = "SELECT username, name, last_name, phone_number, email, descr,profile_image FROM Users WHERE id = :user_id";
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
