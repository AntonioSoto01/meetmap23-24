<?php
require_once('config.php');

// Inicializar el array de errores
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se enviaron los campos requeridos
    if (
        isset($_POST['emailRegistro']) && isset($_POST['usernameRegistro']) &&
        isset($_POST['passwordRegistro']) && isset($_POST['confirmPasswordRegistro'])
    ) {
        // Recuperar datos del formulario
        $email = $_POST['emailRegistro'];
        $username = $_POST['usernameRegistro'];
        $password = $_POST['passwordRegistro'];
        $confirmPassword = $_POST['confirmPasswordRegistro'];

        // Validar si las contraseñas coinciden
        if ($password !== $confirmPassword) {
            $errores[] = "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
        }

        try {
            // Establecer conexión a la base de datos utilizando las constantes definidas en config.php
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Comprobar si el usuario ya existe
            $query_check_user = "SELECT * FROM Users WHERE username = :username OR email = :email LIMIT 1";
            $stmt_check_user = $db->prepare($query_check_user);
            $stmt_check_user->bindParam(':username', $username);
            $stmt_check_user->bindParam(':email', $email);
            $stmt_check_user->execute();
            $existing_user = $stmt_check_user->fetch();

            if ($existing_user) {
                $errores[] = "El usuario o correo electrónico ya está en uso.";
            }

            // Insertar usuario si no hay errores
            if (!empty($errores)) {
                $query_insert_user = "INSERT INTO Users (email, username, pw) VALUES (:email, :username, :pw)";
                $stmt_insert_user = $db->prepare($query_insert_user);
                $stmt_insert_user->bindParam(':email', $email);
                $stmt_insert_user->bindParam(':username', $username);
                $stmt_insert_user->bindParam(':pw', $password);

                if ($stmt_insert_user->execute()) {
                    // Redirigir a una página de éxito o realizar alguna acción adicional

                    header("Location: index_boostrap.php?msg=success");
                    exit();
                } else {
                    $errores[] = "Error al registrar el usuario.";
                }
            }
        } catch (PDOException $e) {
            $errores[] = "Error de conexión: " . $e->getMessage();
        }
    } else {
        $errores[] = "Todos los campos son obligatorios.";
    }
}
?>
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
<?php
// Tu código PHP existente...

if (!empty($errores)) {
    $errorMessages = "<ul>";
    foreach ($errores as $error) {
        $errorMessages .= "<li>$error</li>";
    }
    $errorMessages .= "</ul>";

    // Generar un script para mostrar la alerta de SweetAlert con los errores
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Utilizando SweetAlert para mostrar los errores después de que la página se cargue
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '$errorMessages'
            });
        });
    </script>";
}
?>

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
                        <form action="" method="post">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>