<?php session_start();

  	require("../conexion.php");

  	if (isset($_SESSION['correo'])) {
   
  	}
  	else{
    	header('Location: ../login/login.php');
  	}

    $correo = $_SESSION['correo'];

  	$al_id = $_POST['al_id'];
    $motivo = $_POST['motivo'];
    $nombre = $_POST['nombre'];
    $fecha = date("Y-m-d H:i:s");

    $id_enc = base64_encode($al_id);

  	$agrega = $conexion->query("UPDATE SCE004 SET al_estatus = 'B' WHERE al_id = '$al_id'");


  	$realiza = $conexion->prepare('INSERT INTO pp_bajas (al_id, motivo, fecha_baja, usuario) VALUES (:al_id, :motivo, :fecha_baja, :usuario)');

	  $realiza->execute(array(":al_id"=>$al_id, ":motivo"=>$motivo, ":fecha_baja"=>$fecha, ":usuario"=>$correo));

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Datos
  </title>
  <!-- Favicon -->
  <link href="./assets/img/brand/favicon.ico" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="./assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="./assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="./assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link href="/assets/fontawesome.min.css" rel="stylesheet">

</head>

<body class="">
  
  <?php include("nav.php"); ?>

    <!-- Header -->
    <div class="header pb-9 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(./assets/img/theme/fondo.png); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-success opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--9">
      <div class="row">

        <div class="col-xl-12 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-xl-6 col-md-12">
                  <h3 class="mb-0">La baja del alumno <?php echo $nombre ?> se ha realizado correctamente.</h3>
                </div>
                <div class="col-xl-6 col-md-12 text-right">
                  <a href="panel.php" class="btn btn-success">Aceptar</a>
                  <a href="imprime_baja.php?id=<?php echo $id_enc ?>" class="btn btn-primary">Imprimir Reporte</a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  <!--   Core   -->
  <script src="./assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="./assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="./assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
</body>

</html>
<?php

  $agrega = null;
  $realiza = null;
  $conexion = null;

?>