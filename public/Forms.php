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
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=iniciarMap" async defer></script>
</head>
<body>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="loginForm">
                    <div class="card">
                        <div class="card-header bg-custom-top text-white">
                            <h5 class="card-title text-center">Iniciar Sesión</h5>
                        </div>
                        <div class="card-body" style="background-color: #ECECEC;">
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
                                <p class="mt-3 text-center">¿No tienes una cuenta? <a href="javascript:void(0);" class="text-primary" onclick="mostrarRegistro()">Regístrate aquí</a></p>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="registroForm" style="display: none;">
                    <div class="card mt-3">
                        <div class="card-header bg-custom-top text-white">
                            <h5 class="card-title text-center">Regístrate</h5>
                        </div>
                        <div class="card-body" style="background-color: #ECECEC;">
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
                                <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="javascript:void(0);" class="text-primary" onclick="mostrarLogin()">Inicia sesión aquí</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./forms.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>