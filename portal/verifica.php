<?php

	require("../conexion.php");

	$folio = $_POST['folio'];

	$traer = $conexion->query("SELECT * FROM tramites1 WHERE folio = '$folio'");
	$cuenta = $traer->rowCount();

  	if ($cuenta == 0) {

  		$mensaje = "Folio no encontrado, favor de verificar los datos e intertar nuevamente.";
  		$status = "";

  	}
  	else {

  		foreach ($traer as $key) {
  			$id = $key['id'];
  			$nombre_alumno = $key['nombre_alumno'];
  			$a_paterno = $key['a_paterno'];
  			$a_materno = $key['a_materno'];
  			$curp = $key['curp'];
  			$tipo_tramite = $key['tipo_tramite'];
  			$status = $key['status'];
  			$entregado = $key['entregado'];
  			$email = $key['email'];
        $observaciones = $key['observaciones'];
        $motivo = $key['motivo'];
  		}

  		if ($status == "SOLICITADO" OR $status == "SOLICITADO SIN RESPONSABLE" OR $status == "ENVIADO") {

  			$mensaje = "El tramite se encuentra en proceso de ser elaborado, favor de seguir al pendiente de una actualizacion en el estatus.";
  			$estado = "EN PROCESO";
  			
  		}
  		if ($status == "FIRMADO" OR $status == "REIMPRESION") {

  			if (is_null($entregado)) {
  				
  				$mensaje = "El documento se ha elaborado, por favor realiza el pago del tramite.";
  				$estado = "PENDIENTE DE PAGO";

  			}
  			if ($entregado == "PAGADO") {
  				
  				//$mensaje = "Nos encontramos en mantenimiento, favor de intentar más tarde";
          $mensaje = "Documento elaborado y pagado, puede proceder a su descarga.";
  				$estado = "PAGADO";

  			}
  			if ($entregado == "ENTREGADO") {
  				
  				$mensaje = "El documento ya ha sido descargado anteriormente.";
  				$estado = "ENTREGADO";

  			}
        if ($entregado == "VALIDA PAGO") {
          
          $mensaje = "Documento en proceso y validación de pago.";
          $estado = "VALIDANDO PAGO";

        }
  			
  		}
  		if ($status == "ERROR AL FIRMAR" OR $status == "SOLICITADO CON ERROR") {

  			$mensaje = "La solicitud cuenta con algun error que no permite rastrear de forma correcta el certificado, por favor acerquese al departamento de Registro y Certificación dentro de las oficinas de USEBEQ para solucionar cualquier error en la solicitud.";
        $estado = $motivo;
  			
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
        <img src="assets/img/brand/USEBEQN.png" class="navbar-brand-img" alt="...">
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
        <a class="h2 mb-0 text-gray text-uppercase d-none d-lg-inline-block" href="panel.php">
          <!--<img src="assets/img/brand/USEBEQ2.png" width="50" class="navbar-brand-img" alt="...">-->
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
                  <h3 class="mb-0">Duplicado de Certificados en Linea</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">
                    
                  </div>

                  <div class="row">

                  	<?php if ($cuenta == 0) { ?>

	                  	<div class="row col-12 justify-content-center">
							<label><?php echo $mensaje ?></label>
						</div>

						<div class="col-lg-12 form-group text-center">
							<form action="duplicados.php" method="post">
								<button type="submit" class="btn btn-info">Regresar</button>
							</form>
						</div>

					<?php }
					if ($status == "SOLICITADO" OR $status == "SOLICITADO SIN RESPONSABLE" OR $status == "ENVIADO") { ?>

            <div class="row col-12 justify-content-center">
              <!--<h2 align="center" class="text-danger">Debido a la contingencia, la atención a las solicitudes de duplicados de certificados de alumnos egresados en el 2013 y ciclos anteriores, serán atendidas una vez que se reanuden las actividades.</h2>-->
              <br>
            </div>

						<div class="row col-12 justify-content-center">
							<label><?php echo $mensaje ?></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>folio: <?php echo $folio ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Nombre de solicitante: <?php echo $nombre_alumno." ".$a_paterno." ".$a_materno ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Tramite realizado: <?php echo $tipo_tramite ?></b></label>
							<br><br>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Estado del tramite: <?php echo $estado ?></b></label>
							<br><br>
						</div>

						<div class="col-lg-12 form-group text-center">
							<form action="duplicados.php" method="post">
								<button type="submit" class="btn btn-info">Regresar</button>
							</form>
						</div>

					<?php }
					if ($status == "FIRMADO" OR $status == "REIMPRESION") { ?>

						<div class="row col-12 justify-content-center">
							<label><?php echo $mensaje ?></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>folio: <?php echo $folio ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Nombre de solicitante: <?php echo $nombre_alumno." ".$a_paterno." ".$a_materno ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Tramite realizado: <?php echo $tipo_tramite ?></b></label>
							<br><br>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Estado del tramite: <?php echo $estado ?></b></label>
							<br><br>
						</div>

						<?php if (is_null($entregado)) { ?>

							<div class="col-lg-12 form-group text-center">

                <!--<h4 align="justify" class=""><b class="text-danger">Por cierre presupuestal, del 24 de septiembre de 2021 Y hasta nuevo aviso se suspenden todos los trámites en línea.</b></h4>-->

                <!--<h4 align="justify" class=""><b class="text-danger">Por motivo del cierre anual del ejercicio fiscal 2024, se hace de su conocimiento que el pago de derechos para la obtención de duplicado de certificado en línea, será posible hasta nuevo aviso. Debido a lo anterior las solicitudes ingresadas por este medio a partir de enero 2025, así como las recibidas después del 17 de diciembre de 2024, en caso de generarse el documento correspondiente, serán entregados realizando el pago requerido directamente en las oficinas centrales o regionales de la USEBEQ.</b></h4>
                <br>-->

                <!--<h4 align="justify" class=""><b class="text-danger">Por motivo de cierre mensual, se hace de su conocimiento que el pago de derechos para la obtención de duplicado de certificado en línea, podrá realizarse a partir del jueves 5 de octubre. En caso de requerir el documento con urgencia, podrá ser entregado realizando el pago requerido directamente en las oficinas centrales o regionales de la USEBEQ.</b></h4>-->

                <!--<form action="ver.php" method="post">-->
								<form action="https://reger.usebeq.edu.mx/PortalServicios/externalGuest.jsp" method="post">
									<button type="submit" class="btn btn-info">Pago en Linea</button>
				          <input type="hidden" name="system" value="SISCER">
									<input type="hidden" name="systemToken" value="6DFC9F2EE4829768">
									<input type="hidden" name="externalProcessID" value="<?php echo $folio ?>">
									<input type="hidden" name="tid" value="63">
									<input type="hidden" name="nombre" value="<?php echo $nombre_alumno ?>">
									<input type="hidden" name="primerApellido" value="<?php echo $a_paterno ?>">
									<input type="hidden" name="segundoApellido" value="<?php echo $a_materno ?>">
									<input type="hidden" name="correo" value="<?php echo $email ?>">
									<input type="hidden" name="comentarios" value="PASE DE CAJA DESDE PORTAL DE PADRES">
									<input type="hidden" name="successPage" value="https://portal.usebeq.edu.mx/portal/portal/duplicados.php">
									<input type="hidden" name="errorPage" value="https://portal.usebeq.edu.mx/portal/portal/duplicados.php">
									<input type="hidden" name="ventanilla" value="N">
									<input type="hidden" name="usuarioREGER" value="portal">
								</form>

                <br>
                <div class="col-lg-12 form-group text-center">
                  <form action="duplicados.php" method="post">
                    <button type="submit" class="btn btn-info">Aceptar</button>
                  </form>
                </div>

							</div>
              

            <?php }
            if ($entregado == "VALIDA PAGO") { ?>

              <div class="col-lg-12 form-group text-center">

                <!--<h4 align="justify" class=""><b class="text-danger">Por cierre presupuestal, del 24 de septiembre de 2021 Y hasta nuevo aviso se suspenden todos los trámites en línea.</b></h4>-->

                <!--<form action="ver.php" method="post">-->
                <form action="https://reger.usebeq.edu.mx/PortalServicios/externalGuest.jsp" method="post">
                  <button type="submit" class="btn btn-info">Reimpresión Pase de Cobro</button>
                  <input type="hidden" name="system" value="SISCER">
                  <input type="hidden" name="systemToken" value="6DFC9F2EE4829768">
                  <input type="hidden" name="externalProcessID" value="<?php echo $folio ?>">
                  <input type="hidden" name="tid" value="63">
                  <input type="hidden" name="nombre" value="<?php echo $nombre_alumno ?>">
                  <input type="hidden" name="primerApellido" value="<?php echo $a_paterno ?>">
                  <input type="hidden" name="segundoApellido" value="<?php echo $a_materno ?>">
                  <input type="hidden" name="correo" value="<?php echo $email ?>">
                  <input type="hidden" name="comentarios" value="PASE DE CAJA DESDE SISCER">
                  <input type="hidden" name="successPage" value="https://portal.usebeq.edu.mx/portal/portal/duplicados.php">
                  <input type="hidden" name="errorPage" value="https://portal.usebeq.edu.mx/portal/portal/duplicados.php">
                  <input type="hidden" name="ventanilla" value="N">
                  <input type="hidden" name="usuarioREGER" value="portal">
                </form>

              </div>

              <div class="col-lg-12 form-group text-center">
                <form action="duplicados.php" method="post">
                  <button type="submit" class="btn btn-info">Aceptar</button>
                </form>
              </div>

						<?php }
						if ($entregado == "PAGADO") { ?>

							<div class="row col-lg-12 form-group text-center">

							<!--<h4 align="justify" class=""><b class="text-danger">Estamos realizando un mantenimiento, favor de intentar generar la descarga más tarde.</b></h4>-->
                			<div class="col-12 centrado">
  								<form action="imprime_pdf.php" target="_blank" method="POST">
  									<button type="submit" class="btn btn-info">Imprimir Certificado</button>
  				          <input type="hidden" name="id" value="<?php echo $id ?>">
  								</form>

                  <form action="https://www.usebeq.edu.mx/PaginaWEB/encuestas/evaluacionServicioSGC" target="_blank" method="POST">
                    <button type="submit" class="btn btn-success">Evaluación del servicio</button>
                  </form>
                </div>
							</div>

						<?php }
						if ($entregado == "ENTREGADO") { ?>

							<div class="col-lg-12 form-group text-center">
								<form action="duplicados.php" method="post">
									<button type="submit" class="btn btn-info">Regresar</button>
								</form>
							</div>

						<?php } ?>

					<?php }
					if ($status == "ERROR AL FIRMAR" OR $status == "SOLICITADO CON ERROR") { ?>

						<div class="row col-12 justify-content-center">
							<label><?php echo $mensaje ?></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Folio: <?php echo $folio ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Nombre de solicitante: <?php echo $nombre_alumno." ".$a_paterno." ".$a_materno ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Trámite realizado: <?php echo $tipo_tramite ?></b></label>
							<br><br>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Estado del trámite: <?php echo $estado ?></b></label>
							<br><br>
						</div>

						<div class="col-lg-12 form-group text-center">
							<form action="duplicados.php" method="post">
								<button type="submit" class="btn btn-info">Regresar</button>
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