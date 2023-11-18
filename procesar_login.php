<?php
require_once('config.php');

function procesarLogin($postData)
{
    $errores = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['formType'] === 'login') {
            $campos = ['usernameLogin' => 'Nombre de usuario', 'passwordLogin' => 'Contraseña'];

            foreach ($campos as $campo => $label) {
                if (isset($_POST[$campo]) && $_POST[$campo] !== '') {
                    ${$campo} = $_POST[$campo];
                } else {
                    $errores[$campo] = "El campo $label es obligatorio.";
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
                        header('Location: index_boostrap.php');
                        exit();
                    } else {
                        $errores['login'] = "El usuario o la contraseña son incorrectos.";
                    }
                } catch (PDOException $e) {
                    $errores['login'] = "Error de conexión: " . $e->getMessage();
                }
            } else {

                header('Location: index_boostrap.php?errorLogin=true');
                exit();
            }
        }
    }

    return $errores;
}


?>