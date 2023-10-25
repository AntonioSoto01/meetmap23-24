<?php
$servername = "localhost";
$username = "meetmap";
$password = "password";
$database = "meetmap";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$archivos_sql = ["db/create_db.sql", "db/test_data.sql"];

foreach ($archivos_sql as $archivo) {

    $sql = file_get_contents($archivo);
    

    if ($conn->multi_query($sql)) {
        echo "Archivo $archivo cargado exitosamente.";
        
 
        while ($conn->next_result()) {
            if (!$conn->more_results()) {
                break;
            }
        }
    } else {
        echo "Error al cargar el archivo $archivo: " . $conn->error;
    }
}


$conn->close();
?>
