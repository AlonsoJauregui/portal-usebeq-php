<?php

	require("../conexion.php");

	$folio =trim($_POST['folio']);
  $mensaje = 0;
  //echo $folio;
  $folio_ant = substr($folio,0,4);
  //echo $folio_ant;
  if ($folio_ant == 'RE23'){
    $mensaje = 6;
  }else {
    $query_estatus = $conexion->query("SELECT al_curp, al_nombreComp, estatus, comentarios FROM tramite_revocaciong WHERE folio = '$folio'");
	  $cant_registros = $query_estatus->rowCount();
 // echo $curp;
  	if ($cant_registros == 0) {

  		$mensaje = 1;

  	}
  	else {

  		foreach ($query_estatus as $key) {
        $curp = $key['al_curp'];
  		  $nombre = $key['al_nombreComp'];
        $estatus = $key['estatus'];
        $comentarios = $key['comentarios'];
  		}
// AGREGAR APROBADA / CANCELADA 
  		if ($estatus == "SOLICITADO") {

  			$mensaje = 2;
  			
  		}
  		if ($estatus == "RECHAZADA") {
  				
  			$mensaje = 3;

  		}
  		if ($estatus == "APROBADA") {

  			$mensaje = 4;
  			
  		}
      if ($estatus == "CANCELADA") {

  			$mensaje = 5;
  			
  		}
      

  	}
    
  }
	

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Revocación en línea
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
                  <h3 class="mb-0">Solicitud de revocación en línea.</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">
                    
                  </div>

                  <div class="row">
          <!-- MENSAJES 
          1. CURP INVALIDA
          2. EN PROCESO / SOLICITADO
          3. RECHAZADA POR INCONSISTENCIAS / RECHAZADA
          4. REALIZADA CON EXITO / REALIZADA -->


					<?php if ($mensaje == 1) { ?>

            <div class="row col-12 justify-content-center">
              <h2 align="center">Folio no encontrado, favor de verificar los datos e intentar nuevamente.</h2>
              <br>
            </div>

						<div class="col-lg-12 form-group text-center">
							<form action="solicitud_revocacion.php" method="post">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>
						</div>

					<?php }
					if ($mensaje == 2) { ?>

						<div class="row col-12 justify-content-center">
							<label align="center">La solicitud de revocación a nombre de <b><?php echo $nombre ?> </b>se encuentra en <b>proceso de validación</b>, favor de revisar el estatus más tarde.</label>
						</div>

            <div class="col-lg-12 form-group text-center">
              <form action="solicitud_revocacion.php" method="post">
                <button type="submit" class="btn btn-info">Aceptar</button>
              </form>
            </div>

          <?php }
          if ($mensaje == 3) { ?>

            <div class="row col-12 justify-content-center">
              <label align="center">La solicitud de revocación a nombre de <b><?php echo $nombre ?></b> fue <b>rechazada</b> por insconsistencias en la información.</label>
            </div>

            <div class="row col-12 justify-content-center">
              <label align="center">Observaciones: <?php echo $comentarios ?></label>
            </div>

            <div class="col-lg-12 form-group text-center">
              <form action="solicitud_revocacion.php" method="post">
                <button type="submit" class="btn btn-info">Aceptar</button>
              </form>
            </div>

          <?php }
          if ($mensaje == 4) { ?>

            <div class="row col-12 justify-content-center">
              <label align="center">La solicitud de revocación a nombre de <b><?php echo $nombre ?></b> fue <b>aprobada</b> y como comprobante se entrega el formato de "Baja".</label>
            </div>
           
            <div class="col-lg-12 form-group text-center">
            <form action="imprime_comprobante_revo.php" method="post">
            <input type="hidden" id= "folio" name="folio" value="<?php echo $folio ?>">
                <button type="submit" class="btn btn-info">Imprimir Baja</button>
            </form>
            </div>

            <div class="col-lg-12 form-group text-center">
              <div class="col-12 centrado">
                <!-- <form action="" target="_blank" method="POST">
                  <button type="submit" class="btn btn-info">Imprimir formato baja</button>
                  <input type="hidden" name="curp" value="<?php echo $curp ?>">
                </form> -->

                

                <form action="https://www.usebeq.edu.mx/PaginaWEB/encuestas/evaluacionServicioSGC" target="_blank" method="POST">
                  <button type="submit" class="btn btn-success">Evaluación del servicio</button>
                </form>
              </div>
            </div>

        	<?php } if ($mensaje == 5) { ?>

          <div class="row col-12 justify-content-center">
            <label align="center">La solicitud de revocación a nombre de <b><?php echo $nombre ?></b> fue <b>CANCELADA</b>.</label>
          </div>
          <div class="row col-12 justify-content-center">
              <label align="center">Observaciones: <?php echo $comentarios ?></label>
          </div>
          <div class="col-lg-12 form-group text-center">
              <form action="solicitud_revocacion.php" method="post">
                <button type="submit" class="btn btn-info">Aceptar</button>
              </form>
          </div>       

          <?php } if ($mensaje == 6) { ?>

          <div class="row col-12 justify-content-center">
            <label align="center">La solicitud con folio <b><?php echo $folio ?></b> no corresponde al proceso del Ciclo Escolar 2023-2024.</label>
          </div>
          
          <div class="col-lg-12 form-group text-center">
              <form action="solicitud_revocacion.php" method="post">
                <button type="submit" class="btn btn-info">Aceptar</button>
              </form>
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