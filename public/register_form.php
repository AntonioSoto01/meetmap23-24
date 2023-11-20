


<form action="procesar_registro.php" method="post">
        <input type="hidden" name="formType" value="register">

        <div class="form-group">
            <label for="emailRegistro">Correo electrónico</label>
            <input type="email" class="form-control" id="emailRegistro" name="emailRegistro"
                placeholder="Ingrese su correo electrónico">
            <?php if(isset($errores['emailRegistro'])) { ?>
                <span class="error"><?=$errores['emailRegistro']?></span>
            <?php } ?>
        </div>

        <div class="form-group">
            <label for="usernameRegistro">Nombre de usuario</label>
            <input type="text" class="form-control" id="usernameRegistro" name="usernameRegistro"
                placeholder="Ingrese su nombre de usuario">
            <?php if(isset($errores['usernameRegistro'])) { ?>
                <span class="error"><?=$errores['usernameRegistro']?></span>
            <?php } ?>
        </div>

        <div class="form-group">
            <label for="passwordRegistro">Contraseña</label>
            <input type="password" class="form-control" id="passwordRegistro" name="passwordRegistro"
                placeholder="Ingrese su contraseña">
            <?php if(isset($errores['passwordRegistro'])) { ?>
                <span class="error"><?=$errores['passwordRegistro']?></span>
            <?php } ?>
        </div>

        <div class="form-group">
            <label for="confirmPasswordRegistro">Repetir contraseña</label>
            <input type="password" class="form-control" id="confirmPasswordRegistro" name="confirmPasswordRegistro"
                placeholder="Repita su contraseña">
            <?php if(isset($errores['confirmPasswordRegistro'])) { ?>
                <span class="error"><?=$errores['confirmPasswordRegistro']?></span>
            <?php } ?>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-custom-color text-white">Registrarse</button>
            <?php if(isset($errores['repetido'])) { ?>
                <span class="error"><?=$errores['repetido']?></span>
            <?php } ?>
        </div>

        <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="#" class="text-primary" onclick="mostrarLogin()">Inicia sesión aquí</a></p>

    </form>