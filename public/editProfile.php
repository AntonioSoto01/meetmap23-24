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
<?php
require_once("header.php");
?>
<div class="container-fluid edicion">
            <!-- Título "Edición de Usuario" centrado -->
            <h1 class="text-center text-white mt-2">Edición de usuario</h1>
        
            <div class="row justify-content-center mt-4">
                <!-- Contenedor para centrar la imagen -->
                <div class="col-12 text-center">
                  <form>
                  <label for="fileUpload">
                    <img src="./images/user.png" alt="Imagen de perfil" class="profile-image mx-auto img-pointer ">
                </label>
                <input class="d-none" type="file" id="fileUpload">
                </div>
              </div>
        
            <div class="row mt-4 ml-5">
              <!-- Formulario -->
              <div class="col-md-2">
                  <div class="form-group">
                    <label class="lab-act" for="username">Nombre de usuario</label>
                    <input type="text" class="form-control" id="username">
                  </div>
                  <div class="form-group">
                    <label class="lab-act" for="firstName">Nombre</label>
                    <input type="text" class="form-control" id="firstName">
                  </div>
                  <div class="form-group">
                    <label class="lab-act" for="lastName">Apellido</label>
                    <input type="text" class="form-control" id="lastName">
                  </div>
                  <div class="form-group">
                    <label class="lab-act" for="phone">Teléfono</label>
                    <input type="tel" class="form-control" id="phone">
                  </div>
                  <div class="form-group">
                    <label class="lab-act" for="email">Email</label>
                    <input type="email" class="form-control" id="email">
                  </div>
                  <div class="form-group">
                    <label class="lab-act" for="description">Descripción</label>
                    <textarea class="form-control" id="description" maxlength="100"></textarea>
                  </div>
              </div>
              <button type="submit" class="btn btn-primary act-button">Guardar cambios</button>
                </form>
            </div>
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