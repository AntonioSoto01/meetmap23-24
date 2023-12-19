<?php
require_once('common_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Realiza la verificación del token en la base de datos
    $userEmail = getUserEmailByToken($token);

    if ($userEmail) {
        // Mostrar formulario para establecer una nueva contraseña
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Restablecer Contraseña</title>
        </head>
        <body>
        <h1>Restablecer Contraseña</h1>
        <form method="post" action="update_password.php">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <input type="password" name="new_password" placeholder="Nueva Contraseña" required><br>
            <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" required><br>
            <input type="submit" value="Guardar Contraseña">
        </form>
        </body>
        </html>
        <?php
    } else {
        // Token inválido o expirado
        echo "El token es inválido o ha expirado.";
    }
} else {
    echo "Acceso no autorizado.";
}

function getUserEmailByToken($token) {

    $query = "SELECT email FROM Users WHERE token = :token";
    $params = [':token' => $token];
    $stmt = executeQuery($query, $params);

    if ($stmt) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user !== false;
    }
    return false; // Cambia esto según tu implementación
}
?>
