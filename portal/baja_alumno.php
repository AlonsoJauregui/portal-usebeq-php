<?php session_start();

  require("../conexion.php");

  if (isset($_SESSION['correo'])) {
   
  }
  else{
    header('Location: ../login/login.php');
  }

  $correo = $_SESSION['correo'];

  $consulta = $conexion->query("SELECT u_nombre FROM PP_usuarios WHERE u_correo = '$correo'");

  foreach($consulta as $fila){
    $nombre = $fila['u_nombre'];
  }

  $al_id = $_GET['al_id'];

  $consulta = $conexion->query("SELECT al_curp, al_nombre, al_appat, al_apmat FROM pp_alumnos WHERE al_id = '$al_id'");

  foreach ($consulta as $dat) {
    $al_curp = $dat['al_curp'];
    $al_nombre = $dat['al_nombre'];
    $al_appat = $dat['al_appat'];
    $al_apmat = $dat['al_apmat'];
  }

  $muestra = $al_nombre." ".$al_appat." ".$al_apmat;

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Baja - Portal Padres
  </title>
  <!-- Favicon -->
  <link href="./assets/img/brand/favicon.ico" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="./assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="./assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link href="/assets/fontawesome.min.css" rel="stylesheet">

  <style type="text/css" media="screen">
    a { -webkit-tap-highlight-color: rgba(0,0,0,0); }
  </style>

  <script>
    $('#dato').on('Onclick', function(){
    var categoria = $('#categoria').val();
  //  alert(categoria)
    $.ajax({
      url:'respesta.php',
      type: 'POST',
      data: {'dato': dato}
    })
  });
  </script>

</head>

<body class="">
  
  <?php include("nav.php"); ?>

    <!-- Header -->
    <div class="header pb-9 d-flex align-items-center" style="min-height: 600px; background-image: url(assets/img/theme/educacion.jpeg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <h1 class="display-2 text-white">Baja del alumno: <?php echo $muestra ?></h1>
            <p class="text-white mt-0 mb-5">Por favor ingresa el motivo por el cual estás realizando la baja del alumno.</p>
          </div>
        </div>
      </div>
    </div>
            
            <form action="realiza_baja.php" method="post">
    <!-- Page content -->
    <div class="container-fluid mt--9">
      <div class="row">
              
        <div class="col-xl-12 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-7">
                  
                </div>
                <div class="col-5 text-right">
                  <input type="submit" class="btn btn-sm btn-primary" value="Ralizar baja">
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-4">
                  <div class="row">
              
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="">Motivo de baja</label>
                        <select name="motivo" id="motivo" class="form-control form-control-alternative">
                          <option value="Cambio de domicilio">Cambio de domicilio.</option>
                          <option value="Cambio de estado">Cambio de estado.</option>
                          <option value="Deseo que ingrese a otra escuela">Deseo que ingrese a otra escuela.</option>
                        </select>
                      </div>
                    </div>

                    <input type="hidden" name="al_id" id="al_id" value="<?php echo $al_id ?>">
                    <input type="hidden" name="nombre" id="nombre" value="<?php echo $muestra ?>">

                  </div>
                </div>
              </form>
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
  <script src="./assets/js/plugins/chart.js/dist/Chart.min.js"></script>
  <script src="./assets/js/plugins/chart.js/dist/Chart.extension.js"></script>
  <!--   Argon JS   -->
  <script src="./assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>
</body>

</html>

<?php

  $consulta = null;
  $conexion = null;

?>