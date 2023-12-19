<?php
session_start();
$urlCompleta = $_SERVER['REQUEST_URI'];
$parseUrl = parse_url($urlCompleta, PHP_URL_PATH);
$_SESSION['previous_page'] = $parseUrl;

$errors = $_SESSION['errors'];

$usuarioAutenticado = isset($_SESSION['user_id']);

if (!$usuarioAutenticado && isset($_COOKIE['remember'])) {

    $query = "SELECT user_id FROM Token WHERE token_value = :token_value";
    $params = [':token_value' => $_COOKIE['remember']];
    $result = executeQuery($query, $params);

    if ($result) {
        $tokenData = $result->fetch(PDO::FETCH_ASSOC);
        if ($tokenData) {
            $_SESSION['user_id'] = $tokenData['user_id'];
            $usuarioAutenticado = true;
        }
    }
}

unset($_SESSION['errors']);
?>

<header class="bg-custom-color text-white">
    <div class="d-flex justify-content-between align-items-center py-3">
        <div class="logo ml-5">
            <a href="index.php"><img src="./images/meetmap.png" alt="Logo de la empresa" height="50"
                    style="margin-right: 50px;"></a>
        </div>
        <nav>
            <ul class="nav mr-5">
                <li class="nav-item"><a href="index.php" class="nav-link text-white">Inicio</a></li>
                <li class="nav-item"><a href="planes.php" class="nav-link text-white">Planes Cerca</a></li>
                <li class="nav-item"><a href="planes.php" class="nav-link text-white">Categorías</a></li>
                <li class="nav-item"><a href="FAQs.php" class="nav-link text-white">FAQs</a></li>
                <li class="nav-item"><a href="contacto.php" class="nav-link text-white">Contacto</a></li>
            </ul>
        </nav>
        <div class="login mr-5">
            <i class="fa fa-user"></i>
            <?php if ($usuarioAutenticado): ?>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle text-white btn-custom-color" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Perfil
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="editProfile.php">Editar Perfil</a>
                        <a class="dropdown-item" href="logout.php">Cerrar Sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="#" id="mostrarPopup" class="text-white" data-toggle="modal"
                    data-target="#loginRegistroModal">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </div>
</header>


<div class="modal fade" id="loginRegistroModal" tabindex="-1" role="dialog" aria-labelledby="loginRegistroModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-custom-top text-white">
                <h5 class="modal-title text-center w-100" id="loginRegistroModalLabel">Iniciar Sesión</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #ECECEC;">
                <div id="loginContent">
                    <?php require_once('login_form.php'); ?>

                </div>
                <div id="registroContent" style="display: none;">
                    <?php require_once('register_form.php'); ?>

                </div>
            </div>
        </div>
    </div>
</div>