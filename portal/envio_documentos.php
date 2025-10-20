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
    Envio de doc
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
        document.getElementById("btsubmit").value = "Enviando Información...";
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
              <a href="../index.php">
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
        <a class="h1 mb-0 text-gray text-uppercase d-none d-lg-inline-block" href="../index.php">
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
                  <h3 class="mb-0">Buzón Portal de Padres.</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">

                   <div class="row col-12 justify-content-center">

                      <h4 align="center" class="">Este es el buzón a través del cual recibimos los documentos que permitan aclarar situaciones vinculadas al proceso de preinscripciones y sus etapas. <b class="text-danger">El correo electrónico o teléfono que proporcione, será el medio de respuesta.</b></h4>
                      <br>

                    </div>
                    
                  </div>

                  <div id="dato">

                    <form action='../login/envio_registro.php' method='POST' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
                    <hr class='my-4' />
                    <div class='row'>
                      <div class='row col-12 justify-content-center espacios'>
                      </div>
                      <div class='col-lg-4 form-group'>
                        <label class='form-control-label'>Folio ficha Preinscripción:</label>
                        <input class='form-control form-control-alternative' type='text' name='folio' id='folio' placeholder='Folio' maxlength='7' required>
                      </div>
                      <div class='col-lg-4 form-group'>
                        <label class='form-control-label'>Correo Electrónico:</label>
                        <input class='form-control form-control-alternative' type='email' name='email' id='email' placeholder='nombre@example.com' required>
                      </div>
                      <div class='col-lg-4 form-group'>
                        <label class='form-control-label'>Teléfono de contacto (10 dígitos):</label>
                        <input class='form-control form-control-alternative' type='text' name='tel' id='tel' placeholder='442XXXXXXX' maxlength='10' required>
                      </div>
                      <div class='col-lg-12 form-group'>
                        <label class='form-control-label'>Describe brevemente la situación meritoria de atención:</label>
                        <textarea class='col-lg-12 form-group' name="msg" id="msg" rows="6"></textarea> 
                      </div>                     

                      <div class='row col-12 justify-content-center'>
                        <h4 align='center' class=''><b class='text-danger'>Los formatos permitidos para la carga de documentos son PNG, JPEG, JPG Y PDF, con un peso máximo de 1 MB.</b></h4>
                      </div>
                      <div class='col-lg-4 form-group'>
                        <label class='form-control-label'>Archivo 1: (1 MB)*</label>
                        <input class='' type='file' name='a1' id='a1' accept='image/*' required>
                      </div>
                      <div class='col-lg-4 form-group'>
                        <label class='form-control-label'>Archivo 2: (1 MB)*</label>
                        <input class='' type='file' name='a2' id='a2' accept='image/*'>
                      </div>
                      <div class='col-lg-4 form-group'>
                        <label class='form-control-label'>Archivo 3: (1 MB)*</label>
                        <input class='' type='file' name='a3' id='a3' accept='image/*'>
                      </div>
                      <div class='col-lg-12 form-group text-center'>
                        <input type='submit' id='btsubmit' class='btn btn-info' value='Enviar Información' />
                      </div>
                    </div>
                  </form>
          
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
  <script src="./assets/js/formularios.js"></script>
</body>

</html>