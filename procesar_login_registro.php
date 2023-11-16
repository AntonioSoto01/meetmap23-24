<?php
require_once('config.php');
function procesarLogin($postData) {
    $error = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLogin'])) {
        $campos = ['usernameLogin' => 'Nombre de usuario', 'passwordLogin' => 'Contraseña'];

        foreach ($campos as $campo => $label) {
            if (isset($_POST[$campo]) && $_POST[$campo] !== '') {
                ${$campo} = $_POST[$campo];
            } else {
                $error = "El campo $label es obligatorio.";
                return $error;
            }
        }

        try {
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM Users WHERE username = :username AND pw = :password";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password); // La contraseña aquí debería estar en texto plano

            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Validación directa en la consulta SQL
                header('Location: index_boostrap.php');
                exit();
            } else {
                $error = "El usuario o la contraseña son incorrectos.";
                return $error;
            }
        } catch (PDOException $e) {
            $error = "Error de conexión: " . $e->getMessage();
            return $error;
        }
    }

    return $error;
}

?>
