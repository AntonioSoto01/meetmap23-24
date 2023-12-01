<?php
require_once("common_functions.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    redirect('404.html', '', '');
}

$db = connectDB();

if ($db) {
    try {
        $plan = executeQuery("SELECT * FROM Activity WHERE id = :id", [':id' => $id])->fetch(PDO::FETCH_ASSOC);

        $isSubscribed = false;
        $consultaSub = "SELECT COUNT(*) as count FROM Subscribers WHERE user_id = :user_id AND activity_id = :activity_id";
        $paramsSub = [':user_id' => $_SESSION['user_id'], ':activity_id' => $id];

        $stmtSub = executeQuery($consultaSub, $paramsSub);

        if ($stmtSub && $stmtSub->fetchColumn() > 0) {
            $isSubscribed = true;
        }

        $isLiked = false;
        $consultaLike = "SELECT COUNT(*) as count FROM Likes WHERE user_id = :user_id AND activity_id = :activity_id";
        $paramsLike = [':user_id' => $_SESSION['user_id'], ':activity_id' => $id];

        $stmtLike = executeQuery($consultaLike, $paramsLike);

        if ($stmtLike && $stmtLike->fetchColumn() > 0) {
            $isLiked = true;
        }

        $isSubscribedText = $isSubscribed ? 'Está suscrito' : 'No está suscrito';
        $buttonText = $isSubscribed ? 'Cancelar' : 'Unirse';

        $isLikedText = $isLiked ? 'Le gusta' : 'No le gusta';
        $likeButtonText = $isLiked ? 'Quitar Like' : 'Dar Like';

    } catch (PDOException $e) {
        $_SESSION['errors']['conexion'] = "Error de conexión: " . $e->getMessage();
        redirect('error_page.php', '', '');
    }
} else {
    $errorMessage = $_SESSION['errors']['conexion'] ?? 'Error de conexión.';
    echo $errorMessage;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Planes Cercanos</title>
    <meta charset="UTF-8" />
    <meta name="author" content="Daniel García Ayala" />
    <meta name="description" content="Mapa" />
    <meta name="editor" content="Manual" />
    <meta name="keywords" lang="es" content="" />
    <?php include_once("links.php"); ?>
</head>

<body>
    <?php
    require_once("header.php");
    ?>
    <div class="container-fluid flex-grow-1 position-relative d-flex flex-column">
    <div class="row">
    <?php
        $imagen_fondo = './images/' . $plan['category'] . '.jpg';
        $imagen_mostrar = obtenerImagen($imagen_fondo);
    ?>
        <div class="col-md-12 bg-primary py-5 text-center background-image" style="background-image: url('<?= $imagen_mostrar ?>')">
            <div class="container">
                <h1 class="text-white">
                    <?= $plan['name'] ?>
                </h1>
            </div>
        </div>

    <?php
    function obtenerImagen($ruta_imagen) {
        return file_exists($ruta_imagen) ? $ruta_imagen : './images/otros.jpg';
    }
    ?>
</div>

        <form id="likeForm" method="post" action="like.php">
            <input type="hidden" name="activity_id" value="<?= $id ?>">
            <button type="submit" id="likeSubmit" class="btn btn-link">
                <?php if ($isLiked): ?>
                    <img src="images/heart.png" alt="Corazón lleno" class="like-button">
                <?php else: ?>
                    <img src="images/heart-no-fill.png" alt="Corazón vacío" class="like-button">
                <?php endif; ?>
            </button>
        </form>

        <div class="row mt-4">
            <div class="col-md-12">
                <h2>Descripción</h2>
                <?php if ($plan['description'] == NULL) { ?>
                    <p>No existe descripción para este plan.</p>
                    <?php
                } else { ?>
                    <p>
                        <?= $plan['description'] ?>
                    </p>
                    <?php
                } ?>
            </div>
        </div>

        <div class="row spacer">
            <div class="col-md-12">
                <img src="images/marker.png" alt="Icono 1" class="icono">
                <span>
                    <?= $plan['place_name'] ?>
                </span>
            </div>
        </div>


        <div class="row spacer">
            <div class="col-md-12">
                <img src="images/calendar.png" alt="Icono 2" class="icono">
                <span>
                    <?= $plan['date'] ?>
                </span>
            </div>
        </div>

        <div class="row spacer">
            <div class="col-md-12">
                <img src="images/reloj.png" alt="Icono 3" class="icono">
                <span>
                    <?= substr($plan['time'], 0, 5) ?>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <img src="images/world.png" alt="Icono 4" class="icono world">
                <span><a class="custom-color-text text-decoration-none" href="<?= $plan['link']; ?>">Más información
                        acerca del evento</a></span>
            </div>
        </div>

        <form id="subscriptionForm" method="post" action="subscribe.php">
            <input type="hidden" name="plan_id" value="<?= $id ?>">
            <button type="submit" class="unirse-button">
                <?= $buttonText ?>
            </button>
        </form>
    </div>

    <?php
    require_once("footer.php");
    ?>


</body>
</html>