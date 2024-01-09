<?php

$token = isset($_GET['token']) ? $_GET['token'] : '';


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
    <?php include_once("links.php"); ?>
</head>

<body>
<?php
require_once("header.php");
?>
    <form method="post" action="updatePassword.php">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <div class="form-group">
        <label for="passwordRegistro">Contraseña</label>
        <input type="password" class="form-control" id="passwordRegistro" name="passwordRegistro"
            placeholder="Ingrese su contraseña">
        <?php if (isset($errors['passwordRegistro'])) { ?>
            <span class="error">
                <?= $errors['passwordRegistro'] ?>
            </span>
        <?php } ?>
    </div>

    <div class="form-group">
        <label for="confirmPasswordRegistro">Repetir contraseña</label>
        <input type="password" class="form-control" id="confirmPasswordRegistro" name="confirmPasswordRegistro"
            placeholder="Repita su contraseña">
        <?php if (isset($errors['confirmPasswordRegistro'])) { ?>
            <span class="error">
                <?= $errors['confirmPasswordRegistro'] ?>
            </span>
        <?php } ?>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-custom-color text-white">Guardar Contraseña</button>
        <?php if (isset($errors['errors'])) { ?>
            <span class="error">
                <?= $errors['errors'] ?>
            </span>
        <?php } ?>
    </div>
    </form>
    <?php
    require_once("footer.php");
    ?>
</body>
</html>
