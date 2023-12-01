<?php
require_once('common_functions.php');
define('NUM_ELEM_POR_PAG', 5);

if (isset($_GET['evento'])) {
    $evento = $_GET['evento'];
}

if (isset($_GET['fecha']) && strlen($_GET['fecha']) === 10 && preg_match('/^[\d-]{10}$/', $_GET['fecha'])) {
    $fecha = $_GET['fecha'];
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$currentParams = $_GET;
unset($currentParams['page']);

$queryString = http_build_query($currentParams);

try {

    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

    if ($evento != NULL && $fecha != NULL) {
        $consulta = $db->prepare("
        SELECT id, name, description, date, time, place_name, category 
        FROM Activity 
        WHERE (name LIKE :evento OR category LIKE :evento) 
        AND date(date) = :fecha
        ORDER BY name 
        LIMIT :limite 
        OFFSET :offset
        ");

        $consulta->bindValue(':evento', "%$evento%", PDO::PARAM_STR);
        $consulta->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    } else if ($evento != NULL && $fecha == NULL) {
        $consulta = $db->prepare("
        SELECT id, name, description, date, time, place_name, category 
        FROM Activity 
        WHERE name LIKE :evento OR category LIKE :evento
        ORDER BY name 
        LIMIT :limite 
        OFFSET :offset
        ");

        $consulta->bindValue(':evento', "%$evento%", PDO::PARAM_STR);
    } else if ($evento == NULL && $fecha != NULL) {
        $consulta = $db->prepare("
        SELECT id, name, description, date, time, place_name, category 
        FROM Activity 
        WHERE date = :fecha
        ORDER BY name 
        LIMIT :limite 
        OFFSET :offset
        ");

        $consulta->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    } else {
        $consulta = $db->prepare("
        SELECT id, name, description, date, time, place_name, category 
        FROM Activity 
        ORDER BY name 
        LIMIT :limite 
        OFFSET :offset
        ");
    }

    $consulta->bindValue(':limite', NUM_ELEM_POR_PAG, PDO::PARAM_INT);
    $consulta->bindValue(':offset', NUM_ELEM_POR_PAG * ($page - 1), PDO::PARAM_INT);

    $consulta->execute();
    $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $count_query = "SELECT COUNT(*) AS N FROM Activity ";

    $bind_values = [];

    $where_clause = '';
    if ($evento != NULL && $fecha != NULL) {
        $where_clause = "WHERE (name LIKE :evento OR category LIKE :evento) AND date(date) = :fecha";
        $bind_values[':evento'] = "%$evento%";
        $bind_values[':fecha'] = $fecha;
    } else if ($evento != NULL && $fecha == NULL) {
        $where_clause = "WHERE name LIKE :evento OR category LIKE :evento";
        $bind_values[':evento'] = "%$evento%";
    } else if ($evento == NULL && $fecha != NULL) {
        $where_clause = "WHERE date = :fecha";
        $bind_values[':fecha'] = $fecha;
    }

    if (!empty($where_clause)) {
        $count_query .= $where_clause;
    }

    $consulta_count = $db->prepare($count_query);

    foreach ($bind_values as $key => $value) {
        $consulta_count->bindValue($key, $value, PDO::PARAM_STR);
    }

    $consulta_count->execute();

    $count_result = $consulta_count->fetch();
    $count = $count_result['N'];

    $num_pages = ceil($count / NUM_ELEM_POR_PAG);

    $consultacat = $db->prepare("SELECT DISTINCT(category) FROM Activity");
    $resultscat = $consultacat->execute();

    $categorias = $consultacat->fetchAll(PDO::FETCH_ASSOC);

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
            <div class="col-md-12 bg-primary py-5 text-center background-image"
                style="background-image: url('./images/tree.jpg')">
                <div class="container">
                    <h1 class="text-white">Planes Cercanos</h1>
                </div>
            </div>
        </div>

        <div class="position-absolute-centered top-50 start-50 translate-middle-x">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5 bg-custom-form p-4 rounded-left">
                        <form class="formulario-grid mx-auto" method="get">
                            <div class="form-group">
                                <label class="text-white" for="evento">Estoy buscando</label>
                                <input type="text" class="form-control custom-width" id="evento" name="evento"
                                    placeholder="Evento o categoría" value="<?= $evento ?>">
                            </div>
                    </div>
                    <div class="col-md-3 bg-custom-form p-4 rounded-right">
                        <div class="form-group">
                            <label class="text-white" for="fecha">Cuándo</label>
                            <input type="date" class="form-control" id="fecha" name="fecha"
                                placeholder="Cualquier fecha">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="carouselExampleIndicators"
                class="carousel slide col-md-12 text-white py-5 text-center slider-categorias" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php foreach ($categorias as $key => $categoria) { ?>
                        <li data-target="#carouselExampleIndicators" data-slide-to="<?= $key ?>" <?php echo ($key == 0) ? 'class="active"' : ''; ?>></li>
                    <?php } ?>
                </ol>
                <div class="carousel-inner">
                    <?php foreach ($categorias as $key => $categoria) { ?>
                        <div class="carousel-item <?php echo ($key === 0) ? 'active' : ''; ?>">
                            <?php
                            $imagen = 'images/' . $categoria['category'] . '.jpg';
                            if (file_exists($imagen)) {
                                $imagen_mostrar = $imagen;
                            } else {
                                $imagen_mostrar = 'images/otros.jpg';
                            }
                            ?>
                            <div class="position-relative">
                                <img class="d-block w-100" src="<?= $imagen_mostrar ?>" alt="<?= $categoria['category'] ?>">
                                <div class="position-absolute custom-top start-50 translate-middle text-white text-center slider-item"
                                    style="z-index: 1;">
                                    <h5>
                                        <?= $categoria['category'] ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div class="container-fluid px-0">
            <div class="row px-0">
                <div class="col-12 text-dark px-0">
                    <?php $counter = 0; ?>
                    <?php foreach ($datos as $dato) { ?>
                        <?php $bgClass = ($counter % 2 === 0) ? 'bg-plan-par' : 'bg-plan-impar'; ?>
                        <div class="p-0 <?= $bgClass ?>">
                            <div class="d-flex align-items-center">
                                <?php
                                $ruta_imagen = 'images/' . $dato['category'] . '.jpg';
                                $imagen_mostrar = (file_exists($ruta_imagen)) ? $ruta_imagen : 'images/otros.jpg';
                                ?>
                                <img class="img-plan" src="<?= $imagen_mostrar ?>" alt="Plan">
                                <div class="ml-3" style="padding-left: 0; padding-right: 0;">
                                    <h2 class="mb-2 text-start"><a class="text-decoration-none text-dark"
                                            href="detalle.php?id=<?= $dato['id'] ?>">
                                            <?= $dato['name'] ?>
                                        </a></h2>
                                    <?php
                                    $description = $dato['description'];
                                    $descriptionLines = explode("\n", wordwrap($description, 220, "\n"));
                                    $limitedDescription = implode("<br>", array_slice($descriptionLines, 0, 1));
                                    if (count($descriptionLines) > 1) {
                                        $limitedDescription .= '...';
                                    }
                                    ?>
                                    <p class="mb-1 text-start">
                                        <?= $limitedDescription ?>
                                    </p>
                                    <p class="mb-1 text-start text-muted">
                                        <?= $dato['place_name'] ?>
                                    </p>
                                    <p class="mb-0 text-start text-muted">
                                        <?= $dato['date'] ?><br>
                                        <?= substr($dato['time'], 0, 5) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                    <?php } ?>
                    <div class="paginacion d-flex justify-content-center">
                        <?php if ($page > 1 && $page >= $num_pages - 2) { ?>
                            <span><a href="?<?= $queryString ?>&page=1">&lt;&lt;</a></span>
                            <?php for ($i = max(1, $num_pages - 2); $i <= $num_pages; $i++) { ?>
                                <span><a <?= ($i == $page) ? "class='actual'" : "" ?> href="?<?= $queryString ?>&page=<?= $i ?>">
                                        <?= $i ?>
                                    </a></span>
                            <?php } ?>
                            <?php if ($page < $num_pages) { ?>
                                <span><a href="?<?= $queryString ?>&page=<?= $num_pages ?>">&gt;&gt;</a></span>
                            <?php } ?>
                        <?php } else if ($page <= 2) { ?>
                            <?php for ($i = 1; $i <= min(3, $num_pages); $i++) { ?>
                                    <span><a <?= ($i == $page) ? "class='actual'" : "" ?> href="?<?= $queryString ?>&page=<?= $i ?>">
                                        <?= $i ?>
                                        </a></span>
                            <?php } ?>
                            <?php if ($page < $num_pages) { ?>
                                    <span><a href="?<?= $queryString ?>&page=<?= $num_pages ?>">&gt;&gt;</a></span>
                            <?php } ?>
                        <?php } else { ?>
                            <?php for ($i = max(1, $page - 1); $i <= min($page + 1, $num_pages); $i++) { ?>
                                    <span><a <?= ($i == $page) ? "class='actual'" : "" ?> href="?<?= $queryString ?>&page=<?= $i ?>">
                                        <?= $i ?>
                                        </a></span>
                            <?php } ?>
                            <?php if ($page < $num_pages) { ?>
                                    <span><a href="?<?= $queryString ?>&page=<?= $num_pages ?>">&gt;&gt;</a></span>
                            <?php } ?>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
    require_once("footer.php");
    ?>
    <?php include_once("links.php"); ?>
</body>

</html>