<?php
session_start();
require_once("common_functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['activity_id'])) {
    $id = $_POST['activity_id'];

    try {
        $db = connectDB();

        $consultaLike = "SELECT COUNT(*) as count FROM Likes WHERE user_id = :user_id AND activity_id = :activity_id";
        $params = [':user_id' => $_SESSION['user_id'], ':activity_id' => $id];
        $stmt = executeQuery($consultaLike, $params);

        if ($stmt && $stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $isLiked = ($result['count'] > 0);
        } else {
            $_SESSION['errors']['conexion'] = "Error al verificar el like.";
            redirect('error.php', '', '');
        }
    } catch (PDOException $e) {
        $_SESSION['errors']['conexion'] = "Error de conexión: " . $e->getMessage();
        redirect('error.php', '', '');
    }

    try {
        if ($isLiked) {
            $deleteQuery = "DELETE FROM Likes WHERE user_id = :user_id AND activity_id = :activity_id";
            $stmt = executeQuery($deleteQuery, $params);

            if ($stmt) {
                echo "Has quitado tu like correctamente.";
                redirect(previous_page(), 'id', $id);
            } else {
                $_SESSION['errors']['conexion'] = "Error al quitar el like.";
                redirect('error.php', '', '');
            }
        } else {
            $insertQuery = "INSERT INTO Likes (user_id, activity_id) VALUES (:user_id, :activity_id)";
            $stmt = executeQuery($insertQuery, $params);

            if ($stmt) {
                echo "Has dado like correctamente.";
                redirect(previous_page(), 'id', $id);
            } else {
                $_SESSION['errors']['conexion'] = "Error al dar like.";
                redirect('error.php', '', '');
            }
        }
    } catch (PDOException $e) {
        $_SESSION['errors']['conexion'] = "Error de conexión: " . $e->getMessage();
        redirect('error.php', '', '');
    }
} else {
    $_SESSION['errors']['conexion'] = "Error en la solicitud.";
    redirect('error.php', '', '');
}
?>