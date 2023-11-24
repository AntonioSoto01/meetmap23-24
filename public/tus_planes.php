<?php
require_once('config.php');
try{

  $db =new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
  $user_id = 1; // ID del usuario específico

  $consulta = $db->prepare("
      SELECT DISTINCT a.id, a.name, a.description, a.date, a.time, a.place_name
      FROM Activity a
      LEFT JOIN Likes l ON a.id = l.activity_id
      LEFT JOIN Subscribers s ON a.id = s.activity_id
      WHERE (l.user_id = :user_id OR s.user_id = :user_id)
  ");

  $consulta->bindParam(':user_id', $user_id);
  $consulta->execute();

  $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);



}catch(PDOException $e){
  echo "ERROR: ".$e->getMessage();
  die();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iframe</title>
  <link rel="stylesheet" type="text/css" href="./styles.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Título de la Web -->
  <div class="title">
    <h3>Tus Planes</h3>
  </div>

  <!-- Contenedor de Bootstrap -->
    <div class="row">
      <div class="col-md-6 offset-md-3">
      <?php $counter = 0; ?>
      <?php foreach($datos as $dato) { ?>
          <?php $bgClass = ($counter % 2 === 0) ? 'bg-plan-par' : 'bg-plan-impar'; ?>
          <div class="p-0 <?=$bgClass?> w-100">
              <div class="d-flex align-items-center">
                  <!-- Reducir tamaño de la imagen -->
                  <img class="img-iframe" src="./images/tree.jpg" alt="Plan">

                  <div class="ml-2 w-100" style="font-size: 0.8em;">
                      <h6 class="mb-1 text-start"><a class="text-decoration-none text-dark" href="detalle.php?id=<?=$dato['id']?>" onclick="openInParentWindow(event)"><?=$dato['name']?></a></h6>

                      <p class="mb-0 text-start text-muted small"><?=$dato['place_name']?></p>
                      <div class="d-flex justify-content-between">
                  <p class="mb-0 text-muted small"><?=date('Y-m-d', strtotime($dato['date']))?></p>
                  <p class="mb-0 text-muted small"><?=substr($dato['time'], 0, 5)?></p>
              </div>
                  </div>
              </div>
              <!-- Fecha y hora alineadas horizontalmente al final -->
              
          </div>
          <?php $counter++; ?>
      <?php }?>



      </div>
    </div>

  <script src="/script.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
</body>
</html>