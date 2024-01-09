<!DOCTYPE html>
<html>

<head>
    <title>Mapa</title>
    <meta charset="UTF-8"/>
    <meta name="author" content="Daniel García Ayala"/>
    <meta name="description" content="Mapa"/>
    <meta name="editor" content="Manual"/>
    <meta name="keywords" lang="es" content=""/>
    <?php include_once("links.php"); ?>
</head>

<body>
<?php require_once("header.php"); ?>
<form action="enviarEmail.php" method="post">

    <input type="hidden" name="formType" value="login">
    <div class="form-group">
        <label for="emailRemember">Correo electrónico</label>
        <input type="email" class="form-control" id="emailRemember" name="emailRemember"
               placeholder="Ingrese su correo electrónico">
        <?php if (isset($errors['emailRemember'])) { ?>
            <span class="error">
                <?= $errors['emailRemember'] ?>
            </span>
        <?php } ?>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-custom-color btn-md text-white">Iniciar sesión</button>
        <?php if (isset($errors['remember'])) { ?>
            <span class="error"><?= $errors['remember'] ?></span>
        <?php } ?>
    </div>
</form>
<?php
require_once("footer.php");
?>


</body>

</html>