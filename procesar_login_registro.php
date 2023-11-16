<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['usernameLogin']) && isset($_POST['passwordLogin'])) {
        // Recuperar datos del formulario
        $username = $_POST['usernameLogin'];
        $password = $_POST['passwordLogin'];

        try {
            // Conexión a la base de datos (usando los datos de configuración)
            require_once('config.php');
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta para verificar el usuario en la base de datos
            $query = "SELECT * FROM Users WHERE username = :username";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['pw'])) {
                    header('Location: inicio_exitoso.php');
                    exit();
                } else {
                    echo "La contraseña es incorrecta.";
                }
            } else {
                echo "El usuario no existe.";
            }
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    } else {
        echo "Nombre de usuario y contraseña son obligatorios.";
    }
}
?>
