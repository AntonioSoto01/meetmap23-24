
<!DOCTYPE html>
<html>
<head>
    <title>Mapa</title>
    <meta charset="UTF-8" />
    <meta name="author" content="Daniel García Ayala"/>
    <meta name="description" content="Mapa"/>
    <meta name="editor" content="Manual"/>
    <meta name="keywords" lang="es" content=""/>
    <?php include_once("links.php"); ?>
</head>

<body>
    <?php
    
    require_once("header.php");
    ?>
    <img src="images/flecha.png" alt="Mostrar Menú" id="toggleMenu" style="cursor: pointer;" />
    <!-- Menú desplegable a la izquierda -->
    <div id="menuCollapse">
    <!-- Contenido del menú -->
        <iframe src="tus_planes.php" class="iframe"frameborder="0"></iframe>
    </div>

    <!-- Contenido de tu página -->
    <div class="flex-grow-1" id="map"></div>

    <?php
    require_once("footer.php");
    ?>

     <script src="./map.js"></script>
</body>
</html>