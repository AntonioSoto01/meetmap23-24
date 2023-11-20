<?php
require_once('../config.php');
try {
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para obtener datos de la tabla Activity
    $sql = "SELECT * FROM Activity";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Obtener los resultados como un array asociativo
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Establecer las cabeceras para permitir solicitudes desde cualquier origen (CORS)
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Devolver los datos en formato JSON
    echo json_encode($activities);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$db = null;
?>

