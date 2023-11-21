<?php
session_start();
require_once('common_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requiredFields = [
        'username' => 'Username',
        'email' => 'Email',
    ];

    $errors = validateFields($requiredFields);

    if (empty($errors)) {
        $username = $_POST['username'];
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'];
        $descr = $_POST['description'] ?? '';
        $profileImageData = null;

        if (!empty($_FILES['profileImage']['tmp_name']) && is_uploaded_file($_FILES['profileImage']['tmp_name'])) {
            $profileImageData = file_get_contents($_FILES['profileImage']['tmp_name']);
        }

        $query = "UPDATE Users SET username = :username, name = :firstName, last_name = :lastName, phone_number = :phone, email = :email, descr = :descr, profile_image = :profileImage WHERE id = :user_id";
        $params = [
            ':username' => $username,
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':phone' => $phone,
            ':email' => $email,
            ':descr' => $descr,
            ':user_id' => $_SESSION['user_id'],
            ':profileImage' => $profileImageData
        ];

        $checkUser = checkExistingUserEmail($username, $email);

        if ($checkUser['exists']) {
            $errors['repetido'] =  "El usuario o correo electrónico ya está en uso.";
        } else {
            $stmt = executeQuery($query, $params);

            if ($stmt) {
                redirect('editProfile.php', 'msg=success');
                exit();
            } else {
                $_SESSION['errors'] = "Error actualizando perfil.";
                redirect('editProfile.php', 'msg=error');
                exit();
            }
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect('editProfile.php', 'msg=failure');
        exit();
    }
}
?>
