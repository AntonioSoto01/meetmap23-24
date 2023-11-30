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

    <section class="container-fluid p-5 section-contacto">
        <div class="row">
            <div class="col-lg-6 order-lg-1">
                <img src="./images/daniel.jpeg" alt="Imagen Circular de Daniel"
                    class="img-fluid rounded-circle img-contacto">
            </div>
            <div class="col-lg-6 order-lg-2">
                <h2>Daniel García Ayala</h2>
                <p>Profesional proactivo con mentalidad emprendedora, enérgico y comprometido con el logro de metas.
                    Experiencia sólida en identificar oportunidades de negocio, impulsando proyectos desde su concepción
                    hasta la implementación exitosa. Habilidad demostrada para liderar equipos, inspirar motivación y
                    alcanzar resultados.
                    Apasionado por la innovación, se destaca por su adaptabilidad y capacidad para resolver desafíos de
                    manera creativa.
                    Posee una ética laboral excepcional, con un enfoque meticuloso en la gestión del tiempo y recursos.
                    En constante búsqueda de mejora, aprendizaje continuo y crecimiento personal y profesional.
                    Comprometido con la excelencia y el éxito sostenible.</p>
                <p><strong>Correo:</strong> dgayala002@gmail.com</p>
                <p><strong>GitHub:</strong> <a href="https://github.com/fregonaespanola">FregonaEspanola</a></p>
            </div>
        </div>
    </section>

    <section class="bg-light text-dark p-5 section-contacto">
        <div class="row">
            <div class="col-lg-6">
                <h2>Antonio Soto Cid</h2>
                <p>Dedicada profesional con una pasión inquebrantable por la creatividad y un compromiso innato hacia el
                    trabajo.
                    Poseo una ética laboral sólida y una mentalidad centrada en la productividad y la excelencia. Mi
                    enfoque se fundamenta
                    en la búsqueda constante de soluciones innovadoras para desafíos laborales, combinando habilidades
                    creativas con una
                    determinación incansable. Valoro la colaboración y el aprendizaje continuo, aprovechando cada
                    oportunidad para crecer
                    y mejorar. Mi trayectoria refleja una dedicación constante hacia el perfeccionamiento profesional,
                    con resultados
                    tangibles y un enfoque estratégico para alcanzar objetivos con eficiencia y calidad.</p>
                <p><strong>Correo:</strong> contactodeantonio@correo.com</p>
                <p><strong>GitHub:</strong> <a href="https://github.com/AntonioSoto01">AntonioSoto01</a></p>
            </div>
            <div class="col-lg-6">
                <img src="./images/gear.png" alt="Imagen Circular de Antonio"
                    class="img-contacto rounded-circle float-right mr-5">
            </div>
        </div>
        </div>
    </section>
    <?php
    require_once("footer.php");
    ?>

    <script src="./script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>