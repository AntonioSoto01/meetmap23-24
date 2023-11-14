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
    <header class="bg-custom-color text-white">
        <div class="d-flex justify-content-between align-items-center py-3">
            <div class="logo ml-5">
                <a href="#"><img src="./public/src/meetmap.png" alt="Logo de la empresa" height="50"
                        style="margin-right: 50px;"></a>
            </div>
            <nav>
                <ul class="nav mr-5">
                    <li class="nav-item"><a href="#" class="nav-link text-white">Inicio</a></li>
                    <li class="nav-item"><a href="./planes.html" class="nav-link text-white">Planes Cerca</a></li>
                    <li class="nav-item"><a href="./categorias.html" class="nav-link text-white">Categorías</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-white">FAQs</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-white">Contacto</a></li>
                </ul>
            </nav>
            <div class="login mr-5">
                <i class="fa fa-user"></i>
                <a href="#" id="mostrarPopup" class="text-white" data-toggle="modal"
                    data-target="#loginRegistroModal">Iniciar sesión</a>
            </div>
        </div>
    </header>

    <!-- Modal -->
    <!-- Modal único para iniciar sesión y registro -->
    <div class="modal fade" id="loginRegistroModal" tabindex="-1" role="dialog"
        aria-labelledby="loginRegistroModalLabel" aria-hidden="true">
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
                        <form action="procesar_login_registro.php" method="post">
                            <!-- Aquí se especifica el archivo PHP de procesamiento -->
                            <!-- Campos para iniciar sesión -->
                            <div class="form-group">
                                <label for="usernameLogin">Nombre de usuario</label>
                                <input type="text" class="form-control" id="usernameLogin"
                                    placeholder="Ingrese su nombre de usuario">
                            </div>
                            <div class="form-group">
                                <label for="passwordLogin">Contraseña</label>
                                <input type="password" class="form-control" id="passwordLogin"
                                    placeholder="Ingrese su contraseña">
                            </div>
                            <p><a href="#" class="text-primary">¿Has olvidado tu contraseña?</a></p>
                            <div class="text-center">
                                <button type="submit" class="btn btn-custom-color btn-md text-white">Iniciar
                                    sesión</button>
                            </div>
                            <p class="mt-3 text-center">¿No tienes una cuenta? <a href="#" class="text-primary"
                                    onclick="mostrarRegistro()">Regístrate aquí</a></p>
                        </form>
                    </div>
                    <div id="registroContent" style="display: none;">
                        <!-- Contenido de registro (inicialmente oculto) -->
                        <form action="procesar_registro.php" method="post">
                            <div class="form-group">
                                <label for="emailRegistro">Correo electrónico</label>
                                <input type="email" class="form-control" id="emailRegistro" name="emailRegistro"
                                    placeholder="Ingrese su correo electrónico">
                            </div>
                            <div class="form-group">
                                <label for="usernameRegistro">Nombre de usuario</label>
                                <input type="text" class="form-control" id="usernameRegistro" name="usernameRegistro"
                                    placeholder="Ingrese su nombre de usuario">
                            </div>
                            <div class="form-group">
                                <label for="passwordRegistro">Contraseña</label>
                                <input type="password" class="form-control" id="passwordRegistro"
                                    name="passwordRegistro" placeholder="Ingrese su contraseña">
                            </div>
                            <div class="form-group">
                                <label for="confirmPasswordRegistro">Repetir contraseña</label>
                                <input type="password" class="form-control" id="confirmPasswordRegistro"
                                    name="confirmPasswordRegistro" placeholder="Repita su contraseña">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-custom-color text-white">Registrarse</button>
                            </div>
                            <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="#" class="text-primary"
                                    onclick="mostrarLogin()">Inicia sesión aquí</a></p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




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
</body>

</html>