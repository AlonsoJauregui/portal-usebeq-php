<?php

	require("../conexion.php");

	$curp = $_POST['curp'];
  $mensaje = 0;

	$traer = $conexion->query("SELECT * FROM tramite_baja WHERE curp = '$curp'");
	$cuenta = $traer->rowCount();

  	if ($cuenta == 0) {

  		$mensaje = 1;

  	}
  	else {

  		foreach ($traer as $key) {
  			$id = $key['id'];
        $nombre = $key['nombre'];
        $estatus = $key['estatus'];
        $observaciones = $key['observaciones'];
  		}

  		if ($estatus == "SOLICITADO" OR $estatus == "PREVIA") {

  			$mensaje = 2;
  			
  		}
  		if ($estatus == "RECHAZADA") {
  				
  			$mensaje = 3;

  		}
  		if ($estatus == "REALIZADA") {

  			$mensaje = 4;
  			
  		}

  	}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Duplicados en linea
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
    div.centrado {
      justify-content: center;
      align-items: center;
      display: flex;
    }
  </style>

</head>

<body class="">

  <!--inicia barra de navegacion -->

  <nav class="navbar navbar-vertical navbar-expand-md navbar-light bg-white d-md-none" id="sidenav-main">
    <div class="container-fluid">
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="panel.php">
        <img src="assets/img/brand/USEBEQ2.png" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
                <img alt="Image placeholder" width="100" src="./assets/img/brand/USEBEQ.png">
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
                <img src="./assets/img/brand/USEBEQ2.png">
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
        <a class="h2 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="panel.php">
          <img src="assets/img/brand/USEBEQ2.png" width="50" class="navbar-brand-img" alt="...">
          &nbsp;SISCER
        </a>
        <!-- Form -->
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="">
                  <img alt="Image placeholder" width="140" src="./assets/img/brand/USEBEQB.png">
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
                  <h3 class="mb-0">Solicitud de baja en linea.</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">
                    
                  </div>

                  <div class="row">

					<?php if ($mensaje == 1) { ?>

            <div class="row col-12 justify-content-center">
              <h2 align="center">CURP no encontrada, favor de verificar los datos e intentar nuevamente.</h2>
              <br>
            </div>

						<div class="col-lg-12 form-group text-center">
							<form action="sol_bajas.php" method="post">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>
						</div>

					<?php }
					if ($mensaje == 2) { ?>

						<div class="row col-12 justify-content-center">
							<label align="center">La solicitud de baja a nombre de <?php echo $nombre ?> se encuentra en proceso de validación, favor de seguir al pendiente de una actualizacion en el estatus.</label>
						</div>

            <div class="col-lg-12 form-group text-center">
              <form action="sol_bajas.php" method="post">
                <button type="submit" class="btn btn-info">Aceptar</button>
              </form>
            </div>

          <?php }
          if ($mensaje == 3) { ?>

            <div class="row col-12 justify-content-center">
              <label align="center">La solicitud de baja a nombre de <?php echo $nombre ?> fue rechazada por insconsistencias en la información.</label>
            </div>

            <div class="row col-12 justify-content-center">
              <label align="center">Observaciones: <?php echo $observaciones ?></label>
            </div>

            <div class="col-lg-12 form-group text-center">
              <form action="sol_bajas.php" method="post">
                <button type="submit" class="btn btn-info">Aceptar</button>
              </form>
            </div>

          <?php }
          if ($mensaje == 4) { ?>

            <div class="row col-12 justify-content-center">
              <label align="center">La solicitud de baja a nombre de <?php echo $nombre ?> fue realizada con éxito, por favor imprima su comprobante de baja.</label>
            </div>

            <div class="col-lg-12 form-group text-center">
              <form action="sol_bajas.php" method="post">
                <button type="submit" class="btn btn-info">Aceptar</button>
              </form>
            </div>

            <div class="col-lg-12 form-group text-center">
              <div class="col-12 centrado">
                <form action="boleta2024.php" target="_blank" method="POST">
                  <button type="submit" class="btn btn-info">Imprimir formato baja</button>
                  <input type="hidden" name="curp" value="<?php echo $curp ?>">
                </form>

                <form action="https://www.usebeq.edu.mx/PaginaWEB/encuestas/evaluacionServicioSGC" target="_blank" method="POST">
                  <button type="submit" class="btn btn-success">Evaluación del servicio</button>
                </form>
              </div>
            </div>

        	<?php } ?>

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
</body>

</html>
<?php

  $traer = null;
  $conexion = null;

?>