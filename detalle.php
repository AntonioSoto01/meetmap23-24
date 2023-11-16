<?php
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
}else{
    //LOG
    header('Location: 404.html');
    die();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=pruebas','dani','1234');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $consulta = $db->prepare("SELECT * FROM Activity WHERE id = :id");
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    $consulta->execute();
    $plan = $consulta->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
    die();
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Planes Cercanos</title>
    <meta charset="UTF-8" />
    <meta name="author" content="Daniel García Ayala"/>
    <meta name="description" content="Mapa"/>
    <meta name="editor" content="Manual"/>
    <meta name="keywords" lang="es" content=""/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./styles_bt.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=iniciarMap" async defer></script>
</head>
<body>
<?php
require_once("header.php");
?>
    <!--Contenido-->
<div class="container-fluid flex-grow-1 position-relative d-flex flex-column">
    <div class="row">
        <div class="col-md-12 bg-primary py-5 text-center background-image">
            <div class="container">
                 <h1 class="text-white"><?=$plan['name']?></h1>
            </div>
        </div>
    </div>
    
    <!--boton de corazon-->
    <img class="like-button" src="images/heart.png" alt="Corazon">
     <!-- Sección de Descripción -->
     <div class="row mt-4">
        <div class="col-md-12">
            <h2>Descripción</h2>
            <?php if($plan['description']==NULL){?>
                <p>No existe descripción para este plan.</p>
            <?php
            }else{?>
            <p><?=$plan['description']?></p>
            <?php
            }?>
        </div>
    </div>

    <!-- Sección de iconos y textos -->
    <div class="row spacer">
        <div class="col-md-12">
            <img src="images/marker.png" alt="Icono 1" class="icono">
            <span><?=$plan['place_name']?></span>
        </div>
    </div>


    <div class="row spacer">
        <div class="col-md-12">
        <img src="images/calendar.png" alt="Icono 2" class="icono">
        <span><?=$plan['date']?></span>
        </div>
    </div>

    <div class="row spacer">
        <div class="col-md-12">
        <img src="images/reloj.png" alt="Icono 3" class="icono">
        <span><?=substr($plan['time'], 0, 5)?></span>
        </div>
    </div>

    <!-- Sección de icono y texto adicionales -->
    <div class="row">
        <div class="col-md-12">
        <img src="images/world.png" alt="Icono 4" class="icono world">
        <span><a class="custom-color-text text-decoration-none" href="<?php $plan['link']?>">Más información acerca del evento</a></span>
        </div>
    </div>

    <button class="unirse-button">Unirse</button>
</div>

<?php
require_once("footer.php");
?>

    <!-- Scripts -->
    <script src="./script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>