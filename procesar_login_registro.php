<?php
require_once('config.php');

function procesarLogin($postData) {
    $errores = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
        if ($_POST['formType'] === 'login') {
            echo "<script>console.log('entra');</script>";
            $campos = ['usernameLogin' => 'Nombre de usuario', 'passwordLogin' => 'Contraseña'];

            foreach ($campos as $campo => $label) {
                if (isset($_POST[$campo]) && $_POST[$campo] !== '') {
                    ${$campo} = $_POST[$campo];
                } else {
                    $mensajeError = "El campo $label es obligatorio.";
                    array_push($errores, $mensajeError);
                    echo "<script>console.log('$mensajeError');</script>";
                }
            }

            if (empty($errores)) {
                try {
                    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $query = "SELECT * FROM Users WHERE username = :username AND pw = :password";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);

                    $stmt->execute();

                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        echo "<script>console.log('Todo bien');</script>";
                        header('Location: index_boostrap.php');
                        exit();
                    } else {
                        $mensajeError = "El usuario o la contraseña son incorrectos.";
                        array_push($errores, $mensajeError);
                        echo "<script>console.log('$mensajeError');</script>";
                    }
                } catch (PDOException $e) {
                    $mensajeError = "Error de conexión: " . $e->getMessage();
                    array_push($errores, $mensajeError);
                    echo "<script>console.log('$mensajeError');</script>";
                }
            }
        }
    }

    return $errores;
}


?>

