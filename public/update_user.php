<?php
session_start();
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requiredFields = [
        'username' => 'Nombre de usuario',
        'firstName' => 'Nombre',
        'lastName' => 'Apellido',
        'phone' => 'Teléfono',
        'email' => 'Correo electrónico',
        'description' => 'Descripción'
        // Agrega otros campos que son obligatorios aquí
    ];

    $errors = [];

    foreach ($requiredFields as $field => $fieldName) {
        if (empty($_POST[$field])) {
            $errors[$field] = "El campo $fieldName es obligatorio.";
        }
    }

    if (empty($errors)) {
        $username = $_POST['username'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $descr = $_POST['description'] ?? '';
        
        try {
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "UPDATE Users SET username = :username, name = :firstName, last_name = :lastName, phone_number = :phone, email = :email, descr = :descr WHERE id = :user_id";

            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':descr', $descr);
            $user_id = $_SESSION['user_id'];
            $stmt->bindParam(':user_id', $user_id);

            $stmt->execute();

            header("Location: editProfile.php?msg=success");
            exit();
        } catch (PDOException $e) {
            $errors['update'] = "Error de conexión: " . $e->getMessage();
            $_SESSION['errors'] = $errors; // Almacena los errores en la sesión
            session_destroy();
            header("Location: editProfile.php");
            exit();
        }
    } else {
        $_SESSION['errores'] = $errors; // Almacena los errores en la sesión
        session_destroy();
        header("Location: editProfile.php");
        exit();
    }
}
?>

