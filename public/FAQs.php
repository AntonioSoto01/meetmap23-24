<?php

$arraypreguntas = ['1. ¿Cómo funciona la aplicación?', '2. ¿Cómo puedo encontrar actividades y eventos cerca de mi ubicación?', '3. ¿Cómo puedo reservar plaza en un evento o actividad?', '4. ¿Hay un límite de reservas por evento o actividad?', '5. ¿Cómo puedo ver los planes que me gustan?', '6. ¿Cómo puedo desapuntarme de un plan?', '7. ¿Cómo puedo hacer una sugerencia o reportar un problema?', '8. ¿Usar la aplicación tiene algún coste?', '9. ¿La aplicación está disponible en mi ciudad/país?', '10. ¿Puedo contactar con las personas que están apuntadas a la actividad?'];

$arrayrespuestas = [
    'La aplicación tiene una vista principal con un mapa y la ubicación donde te encuentras. Se muestran todos los planes de la ciudad de Madrd, puedes seleccionar cualquiera de ellos y obtendrás toda la información de la actividad: nombre, lugar, fecha, horario y un enlace a la web para poder más información. También podrás seleccionar el plan como favorito y suscribirte a la actividad.',
    'Debes tener la ubicación de tu dispositivo móvil activada y podrás ver unos marcadores en forma de mano que señalan los lugares del mapa donde se sitúan los planes.',
    'Cuando encuentras el plan que quieres puedes clicar en el mapa y te lleva a una ventana que te proporciona toda la información y un enlace a la web donde se puede reservar la plaza o inscribirse en el plan.',
    'De la gestión de las reservas se encarga la entidad que la realiza y a la que se puede acceder mediante el enlace de cada plan que se ofrece desde nuestra aplicación.',
    'Esta app tiene la posibilidad de guardar en favoritos (haz clic en el corazón de cada actividad) las actividades que más te gustan y puedes acceder a esa lista en el botón de favoritos en el menú inferior de la aplicación.',
    'Cada actividad está gestionada por una entidad diferente y es a esa entidad a quien hay que dirigirse para consultar las posibilidades de anular el plan o darse de baja de la actividad.',
    'En la aplicación, existe un menú desplegable en la parte superior izquierda de la pantalla, donde se muestra una opción de contactar con nosotros. Podrá escribirnos siempre que tenga un problema o una sugerencia; le atenderemos a la mayor brevedad posible, intentando dar solución a su problema o mejorar la aplicación con sus sugerencias.',
    'El uso de la aplicación no tiene ningún coste. Tampoco existe ninguna versión premium ni pagos adicionales para tener acceso a alguna funcionalidad extra de la aplicación. Es 100% gratuita para todos los usuarios.',
    'Actualmente la aplicación solo está disponible para la ciudad de Madrid, aunque en un futuro no muy lejano tenemos previsto estar presente en más ciudades y países. Si quieres que esté en tu región, ¡no dudes en contactar con nosotros para hacernos llegar tu petición!',
    '¡Por supuesto! En el menú principal, hay una sección para los chats donde se muestran todos los chats iniciados y un espacio donde puedes introducir el correo electrónico de una persona: si está dada de alta, puedes iniciar una conversación con ella. Si te has suscrito a un plan, también puedes consultar las personas apuntadas e iniciar el chat desde esa pantalla.'
];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Contacto</title>
    <meta charset="UTF-8" />
    <meta name="author" content="Daniel García Ayala" />
    <meta name="description" content="Mapa" />
    <meta name="editor" content="Manual" />
    <meta name="keywords" lang="es" content="" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=iniciarMap" async defer></script>
</head>

<body>
    <?php
    require_once("header.php");
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 bg-primary py-5 text-center background-image">
                <div class="container">
                    <h1 class="text-white">Preguntas Frecuentes</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            for ($i = 0; $i < count($arraypreguntas); $i++) {
                $class = $i % 2 === 0 ? 'bg-plan-par' : 'bg-plan-impar';
                ?>
                <div class="col-md-12 section section-faqs <?= $class ?>">
                    <h2 class="section-title ml-3">
                        <?= $arraypreguntas[$i] ?>
                    </h2>
                    <p class="section-description">
                        <?= $arrayrespuestas[$i] ?>
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    require_once("footer.php");
    ?>

    <script src="./script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>