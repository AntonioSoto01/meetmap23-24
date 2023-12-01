<?php
require_once('common_functions.php');

try {


    $query = "
        SELECT DISTINCT a.id, a.name, a.description, a.date, a.time, a.place_name, a.category
        FROM Activity a
        LEFT JOIN Likes l ON a.id = l.activity_id
        LEFT JOIN Subscribers s ON a.id = s.activity_id
        WHERE (l.user_id = :user_id OR s.user_id = :user_id)
    ";

    $params = [':user_id' => $_SESSION['user_id']];
    $datos = executeQuery($query, $params)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iframe</title>
    <?php include_once("links.php"); ?>
</head>

<body>

    <div class="title">
        <h3>Tus Planes</h3>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?php $counter = 0; ?>
            <?php foreach ($datos as $dato) { ?>
                <?php $bgClass = ($counter % 2 === 0) ? 'bg-plan-par' : 'bg-plan-impar'; ?>
                <div class="p-0 <?= $bgClass ?> w-100">
                    <div class="d-flex align-items-center">
                        <?php
                        $ruta_imagen = './images/' . $dato['category'] . '.jpg';
                        $imagen_mostrar = (file_exists($ruta_imagen)) ? $ruta_imagen : './images/otros.jpg';
                        ?>
                        <img class="img-iframe" src="<?= $imagen_mostrar ?>" alt="Plan">


                        <div class="ml-2 w-100" style="font-size: 0.8em;">
                            <h6 class="mb-1 text-start"><a class="text-decoration-none text-dark"
                                    href="detalle.php?id=<?= $dato['id'] ?>" onclick="openInParentWindow(event)">
                                    <?= $dato['name'] ?>
                                </a></h6>

                            <p class="mb-0 text-start text-muted small">
                                <?= $dato['place_name'] ?>
                            </p>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0 text-muted small"><?= date('Y-m-d', strtotime($dato['date'])) ?></p>
                                <p class="mb-0 text-muted small">
                                    <?= substr($dato['time'], 0, 5) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
                <?php $counter++; ?>
            <?php } ?>



        </div>
    </div>
</body>

</html>