<?php

define('NUM_ELEM_POR_PAG',5);

if(isset($_GET['page'])&& is_numeric($_GET['page']))
{
    $page = $_GET['page'];
}else{
    $page = 1;
}

try{

    $db = new PDO('mysql:host=localhost;dbname=pruebas','dani','1234');

    $consulta = $db->prepare("SELECT name, description, date, time, category, place_name FROM Activity ORDER BY name LIMIT :limite OFFSET :offset");
    
    $consulta ->bindValue(':limite',NUM_ELEM_POR_PAG, PDO::PARAM_INT);
    $consulta ->bindValue(':offset',NUM_ELEM_POR_PAG*($page-1), PDO::PARAM_INT);
    $results = $consulta->execute();
    
    $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $consulta_count = $db->query("SELECT Count(name) AS N FROM Activity");
    $count = $consulta_count->fetch();
    $count = $count[0];
    $num_pages = ceil($count/NUM_ELEM_POR_PAG);

}catch(PDOException $e){
    echo "ERROR: ".$e->getMessage();
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=iniciarMap" async defer></script>
</head>
<body>
    <header class="bg-custom-color text-white">
        <div class="d-flex justify-content-between align-items-center py-3">
            <div class="logo ml-5">
                <a href="#"><img src="./public/src/meetmap.png" alt="Logo de la empresa" height="50" style="margin-right: 50px;"></a>
            </div>
            <nav>
                <ul class="nav mr-5">
                    <li class="nav-item"><a href="#" class="nav-link text-white">Inicio</a></li>
                    <li class="nav-item"><a href="planes.html" class="nav-link text-white">Planes Cerca</a></li>
                    <li class="nav-item"><a href="planes.html" class="nav-link text-white">Categorías</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-white">FAQs</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-white">Contacto</a></li>
                </ul>
            </nav>
            <div class="login mr-5">
                <i class="fa fa-user"></i>
                <a href="#" id="mostrarPopup" class="text-white" data-toggle="modal" data-target="#loginRegistroModal">Iniciar sesión</a>
            </div>
        </div>
    </header>
    
    <!-- Modal -->
   <!-- Modal único para iniciar sesión y registro -->
<div class="modal fade" id="loginRegistroModal" tabindex="-1" role="dialog" aria-labelledby="loginRegistroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-custom-top text-white">
                <h5 class="modal-title text-center w-100" id="loginRegistroModalLabel">Iniciar Sesión</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #ECECEC;">
                <div id="loginContent"> <!-- Contenido de inicio de sesión -->
                    <form>
                        <!-- Campos para iniciar sesión -->
                        <div class="form-group">
                            <label for="usernameLogin">Nombre de usuario</label>
                            <input type="text" class="form-control" id="usernameLogin" placeholder="Ingrese su nombre de usuario">
                        </div>
                        <div class="form-group">
                            <label for="passwordLogin">Contraseña</label>
                            <input type="password" class="form-control" id="passwordLogin" placeholder="Ingrese su contraseña">
                        </div>
                        <p><a href="#" class="text-primary">¿Has olvidado tu contraseña?</a></p>
                        <div class="text-center">
                            <button type="submit" class="btn btn-custom-color btn-md text-white">Iniciar sesión</button>
                        </div>
                        <p class="mt-3 text-center">¿No tienes una cuenta? <a href="#" class="text-primary" onclick="mostrarRegistro()">Regístrate aquí</a></p>
                    </form>
                </div>
                <div id="registroContent" style="display: none;"> <!-- Contenido de registro (inicialmente oculto) -->
                    <form>
                        <!-- Campos para registro -->
                        <div class="form-group">
                            <label for="emailRegistro">Correo electrónico</label>
                            <input type="email" class="form-control" id="emailRegistro" placeholder="Ingrese su correo electrónico">
                        </div>
                        <div class="form-group">
                            <label for="usernameRegistro">Nombre de usuario</label>
                            <input type="text" class="form-control" id="usernameRegistro" placeholder="Ingrese su nombre de usuario">
                        </div>
                        <div class="form-group">
                            <label for="passwordRegistro">Contraseña</label>
                            <input type="password" class="form-control" id="passwordRegistro" placeholder="Ingrese su contraseña">
                        </div>
                        <div class="form-group">
                            <label for="confirmPasswordRegistro">Repetir contraseña</label>
                            <input type="password" class="form-control" id="confirmPasswordRegistro" placeholder="Repita su contraseña">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-custom-color text-white">Registrarse</button>
                        </div>
                        <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="#" class="text-primary" onclick="mostrarLogin()">Inicia sesión aquí</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    
    

    <!-- Contenido de tu página -->
    <div class="container-fluid flex-grow-1 position-relative d-flex flex-column">
        <div class="row">
            <div class="col-md-12 bg-primary py-5 text-center background-image">
                <div class="container">
                    <h1 class="text-white">Planes Cercanos</h1>
                </div>
            </div>
        </div>
    
        <!-- Formulario superpuesto -->
        <div class="position-absolute-centered top-50 start-50 translate-middle-x">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5 bg-custom-form p-4 rounded-left">
                        <form class="formulario-grid mx-auto">
                            <div class="form-group">
                                <label class="text-white" for="evento">Estoy buscando</label>
                                <input type="text" class="form-control custom-width" id="evento" name="evento" placeholder="Evento o categoría">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3 bg-custom-form p-4 rounded-right">
                        <form class="formulario-grid mx-auto">
                            <div class="form-group">
                                <label class="text-white" for="fecha">Cuándo</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Cualquier fecha">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Slider de Categorías -->
                <div class="col-md-12 bg-secondary text-white py-5 text-center slider-categorias">
                <h2>Slider de Categorías</h2>
                <!-- Aquí va tu código para el slider de categorías -->
            </div>
        </div>
    
        <div class="container-fluid px-0">
    <div class="row px-0">
        <div class="col-12 text-dark px-0">
            <!-- Item Plan -->
            <?php $counter = 0; ?>
                <?php foreach($datos as $dato) {?>
                    <!-- Clase de fondo alternada -->
                    <?php $bgClass = ($counter % 2 === 0) ? 'bg-plan-par' : 'bg-plan-impar'; ?>
                        <div class="p-0 <?=$bgClass?>">
                            <div class="d-flex align-items-center">
                                <img class="img-plan" src="./public/src/tree.jpg" alt="Plan">
                                <div class="ml-3" style="padding-left: 0; padding-right: 0;">
                                    <h2 class="mb-2 text-start"><?=$dato['name']?></h2>
                                    <?php
                                        // Limitar la descripción a tres líneas
                                        $description = $dato['description'];
                                        $descriptionLines = explode("\n", wordwrap($description, 220, "\n"));
                                        $limitedDescription = implode("<br>", array_slice($descriptionLines, 0, 3));
                                    ?>
                                    <p class="mb-1 text-start"><?=$limitedDescription?></p>
                                    <p class="mb-1 text-start text-muted"><?=$dato['place_name']?></p>
                                    <p class="mb-0 text-start text-muted"><?=$dato['date']?><br><?=substr($dato['time'], 0, 5)?></p>
                                </div>
                            </div>
                        </div>
                    <?php $counter++; ?>
                <?php }?>
                <div class="paginacion d-flex justify-content-center">
                    <?php if ($page > 1 && $page >= $num_pages - 2) { ?>
                        <span><a href="?page=1"><<</a></span>
                        <?php for ($i = max(1, $num_pages - 2); $i <= $num_pages; $i++) { ?>
                            <span><a <?=($i == $page) ? "class='actual'" : "" ?> href="?page=<?=$i?>"><?=$i?></a></span>
                        <?php } ?>
                        <?php if ($page < $num_pages) { ?>
                            <span><a href="?page=<?=$num_pages?>">>></a></span>
                        <?php } ?>
                    <?php } else if ($page <= 2) { ?>
                        <?php for ($i = 1; $i <= min(3, $num_pages); $i++) { ?>
                            <span><a <?=($i == $page) ? "class='actual'" : "" ?> href="?page=<?=$i?>"><?=$i?></a></span>
                        <?php } ?>
                        <?php if ($page < $num_pages) { ?>
                            <span><a href="?page=<?=$num_pages?>">>></a></span>
                        <?php } ?>
                    <?php } else { ?>
                        <?php for ($i = max(1, $page - 1); $i <= min($page + 1, $num_pages); $i++) { ?>
                            <span><a <?=($i == $page) ? "class='actual'" : "" ?> href="?page=<?=$i?>"><?=$i?></a></span>
                        <?php } ?>
                        <?php if ($page < $num_pages) { ?>
                            <span><a href="?page=<?=$num_pages?>">>></a></span>
                        <?php } ?>
                    <?php } ?>
                </div>
        </div>
    </div>
</div>

        
</div>

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
</body>
</html>