<?php
session_start();
require_once("common_functions.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan_id'])) {
    $id = $_POST['plan_id'];

    // Verificar si el usuario ya está suscrito al plan
    try {
        $db = connectDB();

        $consultaSub = "SELECT COUNT(*) as count FROM Subscribers WHERE user_id = :user_id AND activity_id = :activity_id";
        $params = [  ':user_id' => $_SESSION['user_id'], ':activity_id' => $id]; // Reemplaza $user_id con el ID de usuario correspondiente
        $stmt = executeQuery($consultaSub, $params);

        if ($stmt && $stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $isSubscribed = ($result['count'] > 0);
        } else {
            $_SESSION['errors']['conexion'] = "Error al verificar suscripción.";
            redirect('error.php', '', '');
        }
    } catch (PDOException $e) {
        $_SESSION['errors']['conexion'] = "Error de conexión: " . $e->getMessage();
        redirect('error.php', '', '');
    }

    try {
        if ($isSubscribed) {
            $deleteQuery = "DELETE FROM Subscribers WHERE user_id = :user_id AND activity_id = :activity_id";
            $params = [  ':user_id' => $_SESSION['user_id'], ':activity_id' => $id]; // Reemplaza $user_id con el ID de usuario correspondiente
            $stmt = executeQuery($deleteQuery, $params);

            if ($stmt) {
                echo "Has sido desuscrito correctamente.";
                redirect(previous_page(), ' id', $id); // Redirige a la página anterior
            } else {
                $_SESSION['errors']['conexion'] = "Error al desuscribir.";
                redirect('error.php', '', '');
            }
        } else {
            $insertQuery = "INSERT INTO Subscribers (user_id, activity_id) VALUES (:user_id, :activity_id)";
            $params = [':user_id' =>  $_SESSION['user_id'], ':activity_id' => $id]; // Reemplaza $user_id con el ID de usuario correspondiente
            $stmt = executeQuery($insertQuery, $params);

            if ($stmt) {
                echo "Te has suscrito correctamente.";
                redirect(previous_page(), ' id', $id); // Redirige a la página anterior
            } else {
                $_SESSION['errors']['conexion'] = "Error al suscribir.";
                redirect('error.php', '', '');
            }
        }
    } catch (PDOException $e) {
        $_SESSION['errors']['conexion'] = "Error de conexión: " . $e->getMessage();
        redirect('error.php', '', '');
    }
} else {
    // Si el método de solicitud no es POST o falta el ID del plan, redireccionar o mostrar un mensaje de error
    $_SESSION['errors']['conexion'] = "Error en la solicitud.";
    redirect('error.php', '', '');
}
?>
