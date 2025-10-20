<?php session_start();

  require("../conexion.php");

  if (isset($_SESSION['correo'])) {
   
  }
  else{
    header('Location: ../login/login.php');
  }

  $correo = $_SESSION['correo'];
  $al_id = base64_decode($_GET['al_id']); 

  $usuario = $conexion->query("SELECT * FROM pp_alumnos WHERE al_id = '$al_id'");

  foreach ($usuario as $key) {
    $curp = $key['al_curp'];
    $nombre = $key['al_nombre'];
    $appat = $key['al_appat'];
    $apmat = $key['al_apmat'];
  }

  $escuelad = $conexion->query("SELECT dbo.SCE002.clavecct, dbo.SCE002.nombrect, dbo.SCE002.eg_grado, dbo.SCE002.eg_grupo FROM dbo.SCE002 INNER JOIN dbo.SCE006 ON dbo.SCE002.eg_id = dbo.SCE006.eg_id WHERE (dbo.SCE006.al_id = '$al_id') AND (dbo.SCE002.ce_inicic = 2020)");

  foreach ($escuelad as $dato) {
    $cct = $dato['clavecct'];
    $nombrect = $dato['nombrect'];
    $grado = $dato['eg_grado'];
    $grupo = $dato['eg_grupo'];
  }

  //conteo de asistencias y validacion de grado para mostrar materias
  $month = date("m");
  $year = date("Y");

  $materias = $conexion->query("EXEC [dbo].[spr_GetMaestroGdoGpoMatID] @al_id='$al_id'");

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Mis Materias
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
  
  <?php include("nav.php"); ?>

    <!-- Header -->
    <div class="header bg-gradient-green pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          
          <!-- aqui iran las cartas -->
          <div class="row">

            <div class="col-xl-6 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <span class="h4 font-weight-bold mb-0">DATOS DEL ALUMNO</span>
                      <h5 class="card-title text-uppercase text-muted mb-0"><?php echo $nombre." ".$appat." ".$apmat; ?></h5>
                      <h5 class="card-title text-uppercase text-muted mb-0"><?php echo $curp; ?></h5>
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
                      <span class="h4 font-weight-bold mb-0">DATOS DE LA ESCUELA</span>
                      <h5 class="card-title text-uppercase text-muted mb-0"><?php echo $cct." - ".$nombrect; ?></h5>
                      <h5 class="card-title text-uppercase text-muted mb-0"><?php echo $grado."° ".$grupo; ?></h5>
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
            
          </div>

        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Mis Maestros</h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>

                    <th scope="col">Maestro</th>
                    <th scope="col">Materia</th>
                    <th scope="col">Correo electrónico</th>

                  </tr>
                </thead>
                <tbody>

                  <?php while ($res = $materias -> fetch()) { ?>
                  <tr>
                    <td>
                      <span class="badge badge-dot mr-4">
                        <?php echo $res['nombremaestro']; ?>
                      </span>
                    </td>
                    <td>
                      <?php echo $res['materia']; ?>
                    </td>
                    <td>
                        <a href="mailto:<?php echo $res['emailins']; ?>"><?php echo $res['emailins']; ?></a>
                    </td>
                  </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2019 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">USEBEQ</a>
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