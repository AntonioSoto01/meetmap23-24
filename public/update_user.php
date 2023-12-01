<?php
require_once('common_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errors']['email'] = 'El correo electrónico no tiene un formato válido.';
            redirect('editProfile.php', 'msg', 'error');
            exit();
        }

        $profileImageData = null;
        if (!empty($_FILES['profileImage']['tmp_name']) && is_uploaded_file($_FILES['profileImage']['tmp_name'])) {
            $uploadDirectory = 'uploads/images';
            $fileName = uniqid() . '_' . $_FILES['profileImage']['name'];
            $destination = $uploadDirectory . $fileName;

            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $destination)) {
                $profileImageData = $destination;
            } else {
                $_SESSION['errors']['errors'] = "Error al subir la imagen al servidor.";
            }
        }

        $existingUser = checkExistingUserEmail($username, $email);
        if ($existingUser['exists'] && $existingUser['data']['id'] !== $_SESSION['user_id']) {
            $_SESSION['errors']['errors'] = "El nombre de usuario o email ya están en uso.";
            redirect('editProfile.php', 'msg', 'error');
            exit();
        }

        $query = "UPDATE Users SET username = :username, name = :firstName, last_name = :lastName, phone_number = :phone, email = :email, descr = :descr";
        $params = [
            ':username' => $username,
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':phone' => $phone,
            ':email' => $email,
            ':descr' => $descr,
        ];

        if ($profileImageData !== null) {
            $query .= ", profile_image = :profileImage";
            $params[':profileImage'] = $profileImageData;
        }

        $query .= " WHERE id = :user_id";
        $params[':user_id'] = $_SESSION['user_id'];

        $stmt = executeQuery($query, $params);

        if ($stmt) {
            redirect('editProfile.php', 'msg', 'success');
            exit();
        } else {
            $_SESSION['errors']['errors'] = "Error actualizando perfil.";
            redirect('editProfile.php', 'msg', 'error');
            exit();
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect('editProfile.php', 'msg', 'failure');
        exit();
    }
}

?>