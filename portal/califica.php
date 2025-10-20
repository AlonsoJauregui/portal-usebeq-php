<?php 

  require("conexion_calif.php");
  //require("conexion_bit.php");

  $al_curp = $_POST['curp']; 
  $accion = "";

  $si_existe = $conexion->query("SELECT COUNT(al_id) AS numero FROM SCE004 WHERE al_curp = '$al_curp'");

  foreach ($si_existe as $key1) {
    $valor_c = $key1['numero'];
  }

  if ($valor_c == 0) {
    $accion = 1;
  }
  if ($valor_c >= 1) {

    $accion = 2;

    $usuario = $conexion->query("SELECT al_id, al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_curp = '$al_curp'");

    foreach ($usuario as $key) {
      $al_id = $key['al_id'];
      $nombre = $key['al_nombre'];
      $appat = $key['al_appat'];
      $apmat = $key['al_apmat'];
    }

    //conteo de asistencias y validacion de grado para mostrar materias
    $month = date("m");
    $year = date("Y");

    if ($month == 01 OR $month == 02 OR $month == 03 OR $month == 04 OR $month == 05 OR $month == 06 OR $month == 07 OR $month == '08') {
      $year = $year-1;
    }

    $year2 = $year+1;

    $dato_al = $conexion->query("SELECT TOP(1) * FROM SCE005 WHERE al_id = '$al_id' AND ce_inicic = '$year'");

    foreach ($dato_al as $dato) {
      $nivel = rtrim($dato['pr_clave']);
      $grado = $dato['eg_grado'];
      $ca_asis1 = $dato['ca_asis1'];
      $ca_asis2 = $dato['ca_asis2'];
      $ca_asis3 = $dato['ca_asis3'];
    }

    $inasistencias = 200;
    $asistencias = 200;
    $asis = $asistencias-$inasistencias;
    $porcentaje = ($inasistencias*100)/$asistencias;
    $por = 100-$porcentaje;

    $fecha_bit = date("d-m-Y");
    $bitacora = $conexion->query("INSERT INTO bitacora_portal (al_id, al_curp, fecha_imp, lugar) VALUES ('$al_id', '$al_curp', '$fecha_bit', 'CALIFICACIONES')");

  }

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Calificaciones
  </title>
  <!-- Favicon -->
  <link href="./assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="./assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="./assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="./assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>

<body class="">

    <!-- Header -->
    <div class="header bg-gradient-green pb-5 pt-5 pt-md-5">
      <div class="container-fluid">
        <div class="header-body">
          
          <!-- aqui iran las cartas -->
          <div class="row">

          <?php if ($accion == 2) { ?>
            <div class="col-xl-6 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <span class="h4 font-weight-bold mb-0">DATOS DEL ESTUDIANTE</span>
                      <!--<h5 class="card-title text-uppercase text-muted mb-0"><?php echo $nombre." ".$appat." ".$apmat; ?></h5>-->
                      <h5 class="card-title text-uppercase text-muted mb-0"><?php echo $al_curp; ?></h5>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="ni ni-badge"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <b>Para obtener una impresión de la boleta de evaluación <a href="../login/login.php">inicia sesión</a> o <a href="../login/new_acount.php">regístrate</a> en el Portal de Padres de Familia.</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } if ($accion == 1) { ?>
            <div class="col-xl-6 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <b>No se ha encontrado registro con la CURP proporcionado, por favor <a href="../index.php">intenta nuevamente</a>.</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <b>Para obtener una impresión de la boleta de evaluación <a href="../login/login.php">inicia sesión</a> o <a href="../login/new_acount.php">regístrate</a> en el Portal de Padres de Familia.</b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
            
          </div>

          <br><br>

        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      
      <?php if ($accion == 2) {
        include("t_calif3_2025.php");
      } ?>

      <!-- Footer -->
      <br>
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2024 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">USEBEQ</a>
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
 
</body>

</html>
<?php

  $usuario = null;
  $dato_al = null;
  $conexion = null;

?>