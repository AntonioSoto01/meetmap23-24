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
                <div id="loginContent">
                    <?php require_once('login_form.php'); ?>
                </div>
                <div id="registroContent" style="display: none;">
                    <?php require_once('register_form.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

















