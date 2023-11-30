<?php
session_start();
$urlCompleta = $_SERVER['REQUEST_URI'];
$errors = $_SESSION['errors'];
require_once("load_user.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Planes Cercanos</title>
    <meta charset="UTF-8" />
    <meta name="author" content="Daniel García Ayala" />
    <meta name="description" content="Mapa" />
    <meta name="editor" content="Manual" />
    <meta name="keywords" lang="es" content="" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <?php include_once("links.php"); ?>
</head>

<body>
    <?php require_once("header.php"); ?>
    <div class="container-fluid edicion">
        <h1 class="text-center text-white mt-2">Edición de usuario</h1>
        <div class="row justify-content-center mt-4">
            <div class="col-12 text-center">
                <form action="update_user.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="formType" value="updateProfile">
                    <label for="fileUpload">
                        <?php if (!empty($userData['profile_image'])) { ?>
                            <img src="<?= $userData['profile_image'] ?>" alt="Imagen de perfil"
                                class="profile-image mx-auto img-pointer" id="imagePreview">
                        <?php } else { ?>
                            <img src="./images/user.png" alt="Imagen de perfil" class="profile-image mx-auto img-pointer"
                                id="imagePreview">
                        <?php } ?>
                    </label>

                    <input class="d-none" type="file" id="fileUpload" name="profileImage"
                        onchange="previewImage(event)">


                    <div class="row mt-4 ml-5">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="lab-act" for="username">Nombre de usuario</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="<?= htmlspecialchars($userData['username'] ?? '') ?>">
                                <?php if (isset($errors['username'])) { ?>
                                    <span class="error-white">
                                        <?= $errors['username'] ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="lab-act" for="firstName">Nombre</label>
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    value="<?= htmlspecialchars($userData['name'] ?? '') ?>">
                                <?php if (isset($errors['firstName'])) { ?>
                                    <span class="error">
                                        <?= $errors['firstName'] ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="lab-act" for="lastName">Apellido</label>
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                    value="<?= htmlspecialchars($userData['last_name'] ?? '') ?>">
                                <?php if (isset($errors['lastName'])) { ?>
                                    <span class="error">
                                        <?= $errors['lastName'] ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="lab-act" for="phone">Teléfono</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="<?= htmlspecialchars($userData['phone_number'] ?? '') ?>">
                                <?php if (isset($errors['phone'])) { ?>
                                    <span class="error">
                                        <?= $errors['phone'] ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="lab-act" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= htmlspecialchars($userData['email'] ?? '') ?>">
                                <?php if (isset($errors['email'])) { ?>
                                    <span class="error">
                                        <?= $errors['email'] ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="lab-act" for="description">Descripción</label>
                                <textarea class="form-control" id="description" name="description"
                                    maxlength="100"><?= htmlspecialchars($userData['descr'] ?? '') ?></textarea>
                                <?php if (isset($errors['description'])) { ?>
                                    <span class="error">
                                        <?= $errors['description'] ?>
                                    </span>
                                <?php } ?>
                                <?php if (isset($errors['errors'])) { ?>
                                    <span class="error">
                                        <?= $errors['errors'] ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary act-button">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
    <?php require_once("footer.php"); ?>

</body>

</html>