<?php 

  require("../conexion.php");

  if (isset($_GET['id'])) {
  
    $al_id = base64_decode($_GET['id']);

    $datos = $conexion->query("SELECT al_appat, al_apmat, al_nombre, al_curp, al_estatus FROM SCE004 WHERE al_id = '$al_id'");

    foreach($datos as $fila){
      $nombre = $fila['al_nombre'];
      $appat = $fila['al_appat'];
      $apmat = $fila['al_apmat'];
      $al_curp = $fila['al_curp'];
      $estatus = rtrim($fila['al_estatus']);
    }

    if ($estatus == 'I') {
      $es = 'Inscrito';
    }
    if ($estatus == 'B') {
      $es = 'Dado de Baja';
    }
    if ($estatus == 'A') {
      $es = 'Inscrito con adeudo de materias';
    }
    if ($estatus == 'E') {
      $es = 'Egresado';
    }

    // VERIFICAMOS SI CONTAMOS CON EL NUMERO DE FOLIO
    if (isset($_GET['folio'])) {
      
      $folio = base64_decode($_GET['folio']);

    }
    else {

      $numero = strlen($al_id);

      if ($numero = 5) {
        $folio = "BE222200".$al_id;
      }
      elseif ($numero = 6) {
        $folio = "BE22220".$al_id;
      }
      elseif ($numero = 7) {
        $folio = "BE2222".$al_id;
      }

    }

    $con = "SI";

  }
  else {

    $con = "NO";

  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $folio = $_POST['folio'];

    //obtenemos el id del folio y verificamos si este existe

    $cad = substr($folio, -7, 7);
    $cad2 = substr($cad, -6, 6);
    $cad_ex = substr($cad, 0, 1);

    if ($cad_ex == 0) {
      $id = $cad2;
    }
    else {
      $id = $cad;
    }

    $verifica = $conexion->query("SELECT al_appat, al_apmat, al_nombre, al_curp, al_estatus FROM SCE004 WHERE al_id = '$id'");
    $cuenta = $verifica->rowCount();

    if ($cuenta == 0) {
      
      $con = "NO EXISTE";

    }
    else {

      foreach($verifica as $fila){
        $nombre = $fila['al_nombre'];
        $appat = $fila['al_appat'];
        $apmat = $fila['al_apmat'];
        $al_curp = $fila['al_curp'];
        $estatus = rtrim($fila['al_estatus']);
      }

      if ($estatus == 'I') {
        $es = 'Inscrito';
      }
      if ($estatus == 'B') {
        $es = 'Dado de Baja';
      }
      if ($estatus == 'A') {
        $es = 'Inscrito con adeudo de materias';
      }
      if ($estatus == 'E') {
        $es = 'Egresado';
      }

      $con = "SI";

    }

  }

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

  <style>
    .col-line {
      margin-right: 10px;
      margin-left: 10px;
    }
  </style>

</head>

<body class="">

  <script>
    function checkSubmit() {
        document.getElementById("btsubmit").value = "Enviando Solicitud...";
        document.getElementById("btsubmit").disabled = true;
        return true;
    }
  </script>

  <!--inicia barra de navegacion -->

  <nav class="navbar navbar-vertical navbar-expand-md navbar-light bg-white d-md-none" id="sidenav-main">
    <div class="container-fluid">
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="panel.php">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
                <img alt="Image placeholder" width="150" src="./assets/img/brand/USEBEQN.png">
            </div>
          </a>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="panel.php">
                <img src="./assets/img/brand/USEBEQB.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        
      </div>
    </div>
  </nav>

  <div class="main-content">
  <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h1 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="panel.php">
          &nbsp;SISCER
        </a>
        <!-- Form -->
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="">
                  <img alt="Image placeholder" width="160" src="./assets/img/brand/USEBEQB.png">
                </span>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
  

    <!-- Header -->
    <div class="header pb-9 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(./assets/img/theme/fondo.png); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-info opacity-8"></span>
      
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--10">
      <div class="row justify-content-md-center">

        <div class="col-xl-10 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-12 text-center">
                  <h2 class="mb-0">Verificación de autenticidad</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">

                    <?php if ($con == 'NO') { ?>

                      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='POST'>

                        <div class="row col-12">
                          <h4 align="center" class="">Ingrese el Folio de la boleta para poder consultar el estatus actual del alumno.</h4>
                          <br>
                        </div>

                        <div class="col-12 form-group">
                          <label class="form-control-label">Folio de Boleta</label>
                          <input type="text" class="form-control form-control-alternative" name="folio" id="folio">
                        </div>

                        <div class="row col-12 justify-content-center">
                          <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Consultar Información">
                          </div>
                        </div>

                      </form>

                    <?php } if ($con == 'NO EXISTE') { ?>

                      <form action="boeva.php">

                        <div class="row col-line justify-content-center">
                          <h4 align="center" class="">No se ha encotrado información con el folio ingresado, por favor revise la información proporcionada e intente nuevamente.</h4>
                          <br>
                        </div>

                        <div class="row col-line justify-content-center">
                          <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Aceptar">
                          </div>
                        </div>

                      </form>

                    <?php } if ($con == 'SI') { ?>

                      <form action="../index.php">

                        <div class="row col-line justify-content-center">
                          <h4 align="center" class="">La lectura del código QR vincula al educando <b><?php echo $nombre." ".$appat." ".$apmat ?></b> con CURP <b><?php echo $al_curp ?></b>, como alumno (a) acreedor (a) del documento con folio: <b><?php echo $folio ?></b>.</h4>
                          <br>
                        </div>

                        <div class="row col-line justify-content-center">
                          <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Aceptar">
                          </div>
                        </div>

                      </form>
                    
                    <?php } ?>

                  </div>
                  
                </div> 
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2019 <a href="https://www.usebeq.edu.mx/PaginaWEB/" class="font-weight-bold ml-1" target="_blank">USEBEQ</a>
            </div>
          </div>
          <div class="col-xl-6">
            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
              <li class="nav-item">
                <a href="https://www.usebeq.edu.mx/PaginaWEB/" class="nav-link" target="_blank">USEBEQ</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!--   Core   -->
  <script src="./assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="./assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="./assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script src="./assets/js/formularios.js"></script>
</body>

</html>
<?php

  $datos = null;
  $verifica = null;
  $conexion = null;

?>