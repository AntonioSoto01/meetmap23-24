<?php
require_once('common_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Realiza la verificación del token en la base de datos
    $userEmail = getUserEmailByToken($token);

    if ($userEmail) {
        header("Location: changePasswordForm.php?token=$token");
        exit();
    } else {
        // Token inválido o expirado
        echo "El token es inválido o ha expirado.";
    }
} else {
    echo "Acceso no autorizado.";
}

function getUserEmailByToken($token) {
    $query = "SELECT Users.email 
              FROM Token 
              INNER JOIN Users ON Token.user_id = Users.id 
              WHERE Token.token_value = :token 
              AND Token.token_type = 'password_recovery' 
              AND Token.expiration_date > NOW()"; 
    $params = [':token' => $token];
    $stmt = executeQuery($query, $params);

    if ($stmt) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user['email'] ?? false;
    }
    return false; 
}
?>
