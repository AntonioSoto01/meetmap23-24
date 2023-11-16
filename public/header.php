<header class="bg-custom-color text-white">
        <div class="d-flex justify-content-between align-items-center py-3">
            <div class="logo ml-5">
                <a href="index.php"><img src="./images/meetmap.png" alt="Logo de la empresa" height="50" style="margin-right: 50px;"></a>
            </div>
            <nav>
                <ul class="nav mr-5">
                    <li class="nav-item"><a href="index.php" class="nav-link text-white">Inicio</a></li>
                    <li class="nav-item"><a href="planes.php" class="nav-link text-white">Planes Cerca</a></li>
                    <li class="nav-item"><a href="planes.php" class="nav-link text-white">Categorías</a></li>
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