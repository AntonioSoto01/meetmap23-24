
<form action="procesar_login.php" method="post">
    <input type="hidden" name="formType" value="login">

    <div class="form-group">
        <label for="usernameLogin">Nombre de usuario</label>
        <input type="text" class="form-control" id="usernameLogin" name="usernameLogin" placeholder="Ingrese su nombre de usuario">
        <?php if(isset($errors['usernameLogin'])) { ?>
            <span class="error"><?=$errors['usernameLogin']?></span>
        <?php } ?>
    </div>

    <div class="form-group">
        <label for="passwordLogin">Contraseña</label>
        <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" placeholder="Ingrese su contraseña">
        <?php if(isset($errors['passwordLogin'])) { ?>
            <span class="error"><?=$errors['passwordLogin']?></span>
        <?php } ?>
    </div>

    <div class="form-group">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Recuérdame</label>
    </div>
    <div class="text-center">
        <a href="oauthGoogle.php" class="btn btn-danger btn-md text-white">Iniciar sesión con Google</a>
        <a href="oauthGithub.php" class="btn btn-danger btn-md text-white">Iniciar sesión con Github</a>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-custom-color btn-md text-white">Iniciar sesión</button>
        <?php if(isset($errors['login'])) { ?>
            <span class="error"><?=$errors['login']?></span>
        <?php } ?>

    </div>
    <p class="mt-3 text-center"><a href="introducirEmail.php" class="text-primary">He olvidado la contraseña</a></p>
    <p class="mt-3 text-center">¿No tienes una cuenta? <a href="#" class="text-primary" onclick="mostrarRegistro()">Regístrate aquí</a></p>
</form>
