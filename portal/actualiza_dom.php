<?php session_start();

  	require("../conexion.php");

  	if (isset($_SESSION['correo'])) {
   
  	}
  	else{
    	header('Location: ../login/login.php');
  	}

  	$username = $_POST['username'];
  	$correo = $_POST['email'];
  	$nombre = mb_strtoupper($_POST['nombre']);
  	$appat = mb_strtoupper($_POST['appat']);
  	$apmat = mb_strtoupper($_POST['apmat']);
  	$sexo = $_POST['sexo'];
  	$direccion = mb_strtoupper($_POST['direccion']);
  	$cp = $_POST['cp'];
  	$municipio = $_POST['municipio'];
  	$tel = $_POST['tel'];

  	$agrega = $conexion->query("UPDATE PP_usuarios SET usuario = '$username', u_tel = '$tel', u_nombre = '$nombre', u_appat = '$appat', u_apmat = '$apmat', domicilio = '$direccion', cp = '$cp', municipio = '$municipio', sexo = '$sexo' WHERE u_correo = '$correo'");


  	/*$agrega = $conexion->prepare('INSERT INTO PP_usuarios (u_tel, u_nombre, u_appat, u_apmat, domicilio, sexo) VALUES (:u_tel, :u_nombre, :u_appat, :u_apmat, :domicilio, :sexo)');

	$agrega->execute(array(":u_tel"=>$tel, ":u_nombre"=>$nombre, ":u_appat"=>$appat, ":u_apmat"=>$apmat, ":domicilio"=>$direccion, ":sexo"=>$sexo));*/

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
  
  <?php 
    include("nav.php");
  ?>

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
                <div class="col-6">
                  <h3 class="mb-0">Tus datos se han actualizado correctamente.</h3>
                </div>
                <div class="col-6 text-right">
                  <a href="panel.php" class="btn btn-success">Aceptar</a>
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
  $conexion = null;

?>