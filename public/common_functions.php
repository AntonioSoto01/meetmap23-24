<?php
session_start();
require_once("../config/config.php");

function connectDB()
{
    try {
        $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        $_SESSION['errors']['conexion'] = "Error de conexión: " . $e->getMessage();
        return null;
    }
}

function redirect($page, $param, $value)
{
    $previousPage = $_SESSION['previous_page'] ?? 'index.php';
    header("Location: $previousPage?$param=$value");
    exit();
}
function previous_page()
{
    return $_SESSION['previous_page'] ?? 'index.php';
}
function validateFields($campos)
{
    $errors = [];

    foreach ($campos as $campo => $nombreCampo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            $errors[$campo] = "El campo $nombreCampo es obligatorio.";
        }
    }

    return $errors;
}
function executeQuery($query, $params = [])
{
    $db = connectDB();

    if ($db) {
        try {
            $stmt = $db->prepare($query);
            foreach ($params as $key => &$value) {
                $stmt->bindParam($key, $value);
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            $_SESSION['errors']['conexion'] = "Error de conexión: " . $e->getMessage();
            return false;
        }
    }

    return false;
}
function checkExistingUserEmail($username, $email)
{
    $query_check_user = "SELECT * FROM Users WHERE username = :username OR email = :email LIMIT 1";
    $params = [':username' => $username, ':email' => $email];
    $stmt = executeQuery($query_check_user, $params);

    if ($stmt && $stmt->rowCount() > 0) {
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        return ['exists' => true, 'data' => $existingUser];
    }

    return ['exists' => false, 'data' => null];
}
?>