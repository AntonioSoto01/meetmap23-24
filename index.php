

<!DOCTYPE html>
<html>

<head>
    <title>Mapa</title>
    <meta charset="UTF-8" />
    <meta name="author" content="Daniel García Ayala" />
    <meta name="description" content="Mapa" />
    <meta name="editor" content="Manual" />
    <meta name="keywords" lang="es" content="" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./styles_bt.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=iniciarMap" async defer></script>
</head>

<body>

<?php
require_once('header.php');
?>



    <!-- Contenido de tu página -->
    <div class="flex-grow-1" id="map"></div>

    <footer class="bg-custom-color text-white text-center">
        <div class="container py-3">
            <p>&copy; 2023 Meetmap</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="./script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>