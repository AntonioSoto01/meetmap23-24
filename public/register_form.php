<form action="procesar_registro.php" method="post">
    <input type="hidden" name="formType" value="register">

    <div class="form-group">
        <label for="emailRegistro">Correo electrónico</label>
        <input type="email" class="form-control" id="emailRegistro" name="emailRegistro"
            placeholder="Ingrese su correo electrónico">
        <?php if (isset($errors['emailRegistro'])) { ?>
            <span class="error">
                <?= $errors['emailRegistro'] ?>
            </span>
        <?php } ?>
    </div>

    <div class="form-group">
        <label for="usernameRegistro">Nombre de usuario</label>
        <input type="text" class="form-control" id="usernameRegistro" name="usernameRegistro"
            placeholder="Ingrese su nombre de usuario">
        <?php if (isset($errors['usernameRegistro'])) { ?>
            <span class="error">
                <?= $errors['usernameRegistro'] ?>
            </span>
        <?php } ?>
    </div>

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
        <button type="submit" class="btn btn-custom-color text-white">Registrarse</button>
        <?php if (isset($errors['errors'])) { ?>
            <span class="error">
                <?= $errors['errors'] ?>
            </span>
        <?php } ?>
    </div>

    <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="#" class="text-primary" onclick="mostrarLogin()">Inicia
            sesión aquí</a></p>

</form>