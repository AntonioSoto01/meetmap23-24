<?php

require_once('common_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... Código para validar los campos y otras validaciones ...

    $errors = validateFields([
        'username' => 'Username',
        'email' => 'Email',
    ]);

    if (empty($errors)) {
        $username = $_POST['username'];
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'];
        $descr = $_POST['description'] ?? '';

        $profileImageData = null;

        if (!empty($_FILES['profileImage']['tmp_name']) && is_uploaded_file($_FILES['profileImage']['tmp_name'])) {
            $uploadDirectory = 'uploads/images'; // Ruta de la carpeta de imágenes
            $fileName = uniqid() . '_' . $_FILES['profileImage']['name']; // Nombre único para evitar conflictos
            $destination = $uploadDirectory . $fileName;

            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $destination)) {
                // Guarda la ruta de la imagen en la base de datos
                $query = "UPDATE Users SET username = :username, name = :firstName, last_name = :lastName, phone_number = :phone, email = :email, descr = :descr, profile_image = :profileImage WHERE id = :user_id";
                $params = [
                    ':username' => $username,
                    ':firstName' => $firstName,
                    ':lastName' => $lastName,
                    ':phone' => $phone,
                    ':email' => $email,
                    ':descr' => $descr,
                    ':user_id' => $_SESSION['user_id'],
                    ':profileImage' => $destination
                ];

                $stmt = executeQuery($query, $params);

                if ($stmt) {

                    redirect('editProfile.php', 'msg','success');
                    exit();
                } else {
                    $_SESSION['errors']['errors'] = "Error actualizando perfil.";
                    redirect('editProfile.php', 'msg','error');
                    exit();
                }
            } else {
                $_SESSION['errors']['errors']  = "Error al subir la imagen al servidor.";


            }
        } else {
            $_SESSION['errors']['errors']  = "No se proporcionó ninguna imagen.";
            redirect('editProfile.php', 'msg','error');
            exit();
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect('editProfile.php', 'msg','failure');
        exit();
    }
}


?>
