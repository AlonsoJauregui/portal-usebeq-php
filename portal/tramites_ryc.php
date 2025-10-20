<?php 

  if (isset($_GET['al_id'])) {
  
  $al_id = $_GET['al_id'];
  $id = $_GET['id'];

}
else {

  $al_id = "NO";
  $id = "NO";

}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Trámites
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
                <img alt="Image placeholder" width="180" src="./assets/img/brand/USEBEQN.png">
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
                <img src="./assets/img/brand/USEBEQN.png">
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
        <a class="h1 mb-0 text-gray text-uppercase d-none d-lg-inline-block" href="panel.php">
          &nbsp;SISCER
        </a>
        <!-- Form -->
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="">
                  <img alt="Image placeholder" width="180" src="./assets/img/brand/USEBEQN.png">
                </span>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
  

    <!-- Header -->
    <div class="header pb-9 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(/*./assets/img/theme/fondo.png*/); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-lighter opacity-8"></span>
      
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--10">
      <div class="row justify-content-md-center">

        <div class="col-xl-10 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-12 text-center">
                  <h3 class="mb-0">Trámites en Línea</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">

                   <div class="row col-12 justify-content-center">

                      <!--<h4 align="justify" class=""><b class="text-danger">Por motivo del cierre anual del ejercicio 2020, se hace de su conocimiento que el pago de derechos para la obtención de duplicado de certificado en línea, será posible hasta nuevo aviso. Debido a lo anterior las solicitudes ingresadas por este medio a partir de enero 2021, así como las recibidas después del 14 de diciembre de 2020, en caso de generarse el documento correspondiente, serán liberadas en cuanto sea posible procesar el pago.</b></h4>-->

                      <!--<h4 align="justify" class=""><b class="text-danger">Por motivo del receso laboral de semana santa, se hace de su conocimiento que las solicitudes pendientes serán atendidas a partir del 12 de abril.</b></h4>
                      <br>-->

                      <!--<h4 align="justify" class=""><b class="text-danger">Por motivo del receso laboral de semana santa, se hace de su conocimiento que las solicitudes ingresadas por este medio entre el 11 y el 27 de abril de 2025 serán atendidas a partir del 28 de abril.</b></h4>
                      <br>-->

                      <!--<h4 align="justify" class=""><b class="text-danger">Por motivo del receso laboral decembrino, se hace de su conocimiento que las solicitudes ingresadas por este medio entre el 17 de diciembre de 2024 y el 7 de enero de 2025 serán atendidas a partir del 8 de enero de 2025.</b></h4>
                      <br>-->
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Trámite a realizar</label>
                        <select class="form-control form-control-alternative" name="entrada" id="entrada">
                          <option value="0" disabled selected>Seleccione una opción</option>
                          <option value="tramite">Estatus del trámite</option>
                          <option value="revalidacion">Revalidación de Estudios</option>
                          <!--<option value="legalizacion">Legalización de Firmas</option>-->
                          <option value="examen">Evaluación General de Conocimientos</option>
                          <!--<option value="Duplicado Boleta de Secundaria">Duplicado Boleta de Secundaria</option>
                          <option value="Revalidación y Equivalencias">Revalidación y Equivalencias</option>-->
                        </select>
                      </div>
                    </div>
                    <input type="hidden" name="al_id" id="al_id" value="<?php echo $al_id ?>">
                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                    
                  </div>

                  <div id="dato">
          
                  </div>

                  
                </div> 
            </div>
          </div>
        </div>
      </div>

      <!--Incluimos el footer-->
      <?php include("pie.php") ?>
    </div>
  </div>

  <!--   Core   -->
  <script src="./assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="./assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="./assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script src="./assets/js/formularios_ryc.js"></script>
</body>

</html>