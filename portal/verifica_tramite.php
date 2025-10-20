<?php

	require("../conexion.php");

	$folio = $_POST['folio'];

  //EXTRAEMOS LOS PRIMEROS CARACTERES DEL FOLIO PARA SABER QUE TRAMITE ES
  $tt = substr($folio, 0, 2);
  /*$status = 'FIRMADO';
  $cuenta = 1;
  $mensaje = "El documento se ha elaborado, por favor realiza el pago del tramite.";
  $estado = "PENDIENTE DE PAGO";

  $nombre_alumno = "Eduardo Francisco";
  $a_paterno = "Pena";
  $a_materno = "Omana";
  $email = "laloz18294@gmail.com";*/

	$traer = $conexion->query("SELECT * FROM tramites_portal WHERE folio = '$folio'");
	$cuenta = $traer->rowCount();

  	if ($cuenta == 0) {

  		$mensaje = "Folio no encontrado, favor de verificar los datos e intertar nuevamente.";
  		$status = "";

  	}
  	else {

  		foreach ($traer as $key) {
  			$id = $key['id'];
  			$nombre_alumno = $key['nombre'];
  			$a_paterno = $key['a_paterno'];
  			$a_materno = $key['a_materno'];
  			$curp = $key['curp'];
  			$tipo_tramite = $key['tipo_tramite'];
  			$status = $key['estatus'];
  			$entregado = $key['entregado'];
  			$email = $key['correo'];
        $observaciones = $key['observaciones'];
        $fecha = $key['fecha_entrega'];
        $folio = $key['folio'];
        $eva = $key['folio_leg'];
  		}

      //convertimos el dia de expedicion a letra
      $d = new DateTime($fecha);
      $e = $d->format('Y-m-d');
      $d_expedicion = date("d", strtotime($e));  

      //convertimos el mes de expedicion a letra
      $m_expedicion = date("m", strtotime($e));
      if ($m_expedicion == 01) {
        $mes_exp = "enero";
       }
       if ($m_expedicion == 02) {
        $mes_exp = "febrero";
       }
       if ($m_expedicion == 03) {
        $mes_exp = "marzo";
       }
       if ($m_expedicion == 04) {
        $mes_exp = "abril";
       }
       if ($m_expedicion == 05) {
        $mes_exp = "mayo";
       }
       if ($m_expedicion == 06) {
        $mes_exp = "junio";
       }
       if ($m_expedicion == 07) {
        $mes_exp = "julio";
       }
       if ($m_expedicion == "08") {
        $mes_exp = "agosto";
       }
       if ($m_expedicion == "09") {
        $mes_exp = "septiembre";
       }
       if ($m_expedicion == 10) {
        $mes_exp = "octubre";
       }
       if ($m_expedicion == 11) {
        $mes_exp = "noviembre";
       }
       if ($m_expedicion == 12) {
        $mes_exp = "diciembre";
       }

      //convertimos el año de expedicion a letra
      $year_expedicion = date("Y", strtotime($e));

  		if ($status == "SOLICITADO" OR $status == "SOLICITADO SIN RESPONSABLE" OR $status == "ENVIADO") {

  			$mensaje = "El trámite se encuentra en proceso de ser elaborado, favor de seguir al pendiente de una actualización en el estatus.";
  			$estado = "EN PROCESO";
  			
  		}
  		elseif ($status == "FIRMADO" OR $status == "REIMPRESION") {

  			if (is_null($entregado)) {
  				
  				$mensaje = "El documento se ha elaborado, por favor realiza el pago del trámite.";
  				$estado = "PENDIENTE DE PAGO";

  			}
  			if ($entregado == "PAGADO") {
  				
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
  		elseif ($status == "ERROR AL FIRMAR" OR $status == "SOLICITADO CON ERROR") {

  			$mensaje = "La solicitud cuenta con algún error que no permite rastrear de forma correcta el certificado, por favor acérquese al departamento de Registro y Certificación dentro de las oficinas de USEBEQ para solucionar cualquier error en la solicitud.";
        $estado = $observaciones;
  			
  		}
      elseif ($status == "ACEPTADA") {

        if ($eva == "EVALUACIONES CAPTURADAS (PROMOVIDO)") {
          $mensaje = "Tu Evaluación General de Conocimientos con folio ".$folio." ya fue revisada. Te informamos que el estudiante APROBÓ la Evaluación presentada.<br>";
          $estado = "<br>Te recomendamos estar al pendiente del correo electrónico registrado al momento de realizar tu solicitud ya que por ese medio estarás recibiendo el documento de acreditación en los próximos días, en caso de tener algún problema con la recepción de correos electrónicos te recomendamos contactar al Departamento de Registro y Certificación ext. 1330.";
        }
        elseif ($eva == "EVALUACIONES CAPTURADAS (NO PROMOVIDO)") {
          $mensaje = "Tu Evaluación General de Conocimientos con folio ".$folio." ya fue revisada. Te informamos que el estudiante REPROBÓ la Evaluación presentada.";
          $estado = "<br>No te preocupes, tendrás una siguiente oportunidad, favor de estar pendientes del correo con la confirmación de la fecha, hora y lugar, en caso de tener algún problema con la recepción de correos electrónicos te recomendamos contactar al Departamento de Registro y Certificación ext. 1330.";
        }
        else {
          $mensaje = "Tu solicitud de Evaluación General de Conocimientos con folio ".$folio." fue aceptada. Deberás presentarte el día ".$d_expedicion." de ".$mes_exp." de ".$year_expedicion." en la Sala grande de Atención Ciudadana de la USEBEQ a las 9:00 a.m.";
          $estado = "";
        }
        
      }
      elseif ($status == "RECHAZADA") {

        $mensaje = "Tu solicitud de Evaluación General de Conocimientos con folio ".$folio." fue rechazada. Se identificaron las siguientes inconsistencias en tu solicitud: ".$observaciones.", por lo que tu solicitud no pudo proceder de manera correcta.";
        $estado = "<p>Para cualquier aclaración relacionada a tu solicitud, favor de enviar un correo electrónico a cleal@usebeq.edu.mx incluyendo el folio de tu solicitud.</p>";
        
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
                  <h3 class="mb-0">Trámites en Linea</h3>
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
							<label><b>Trámite realizado: <?php echo $tipo_tramite ?></b></label>
							<br><br>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Estado del trámite: <?php echo $estado ?></b></label>
							<br><br>
						</div>

						<div class="col-lg-12 form-group text-center">
							<form action="tramites_ryc.php" method="post">
								<button type="submit" class="btn btn-info">Regresar</button>
							</form>
						</div>

					<?php }?>

            <?php if ($tt == "RE") { ?>

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
							<label><b>Trámite realizado: Revalidación de Estudios <?php //echo $tipo_tramite ?></b></label>
							<br><br>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Estado del trámite: <?php echo $estado ?></b></label>
							<br><br>
						</div>

							<div class="col-lg-12 form-group text-center">

                <!--<h4 align="justify" class=""><b class="text-danger">Por motivo del cierre anual del ejercicio 2020, se hace de su conocimiento que el pago de derechos para la obtención de duplicado de certificado en línea, será posible hasta nuevo aviso. Debido a lo anterior las solicitudes ingresadas por este medio a partir de enero 2021, así como las recibidas después del 14 de diciembre de 2020, en caso de generarse el documento correspondiente, serán liberadas en cuanto sea posible procesar el pago.</b></h4>-->

                <!--<form action="ver.php" method="post">-->
								<form action="https://reger.usebeq.edu.mx/PortalServicios/externalGuest.jsp" method="post">
									<button type="submit" class="btn btn-info">Pago en Linea</button>
				          <input type="hidden" name="system" value="SISCER">
									<input type="hidden" name="systemToken" value="6DFC9F2EE4829768">
									<input type="hidden" name="externalProcessID" value="<?php echo $folio ?>">
									<input type="hidden" name="tid" value="32">
									<input type="hidden" name="nombre" value="<?php echo $nombre_alumno ?>">
									<input type="hidden" name="primerApellido" value="<?php echo $a_paterno ?>">
									<input type="hidden" name="segundoApellido" value="<?php echo $a_materno ?>">
									<input type="hidden" name="correo" value="<?php echo $email ?>">
									<input type="hidden" name="comentarios" value="PASE DE CAJA DESDE SISCER">
									<input type="hidden" name="successPage" value="http://portal.usebeq.edu.mx:8080/portal/portal/tramites_ryc.php">
									<input type="hidden" name="errorPage" value="http://portal.usebeq.edu.mx:8080/portal/portal/tramites_ryc.php">
									<input type="hidden" name="ventanilla" value="N">
									<input type="hidden" name="usuarioREGER" value="portal">
								</form>
							</div>

            <?php } ?>
            <?php if ($tt == "LE") { ?>

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
              <label><b>Trámite realizado: Legalización de Firmas <?php //echo $tipo_tramite ?></b></label>
              <br><br>
            </div>

            <div class="row col-12 justify-content-center">
              <label><b>Estado del trámite: <?php echo $estado ?></b></label>
              <br><br>
            </div>

              <div class="col-lg-12 form-group text-center">

                <!--<h4 align="justify" class=""><b class="text-danger">Por motivo del cierre anual del ejercicio 2020, se hace de su conocimiento que el pago de derechos para la obtención de duplicado de certificado en línea, será posible hasta nuevo aviso. Debido a lo anterior las solicitudes ingresadas por este medio a partir de enero 2021, así como las recibidas después del 14 de diciembre de 2020, en caso de generarse el documento correspondiente, serán liberadas en cuanto sea posible procesar el pago.</b></h4>-->

                <!--<form action="ver.php" method="post">-->
                <form action="https://reger.usebeq.edu.mx/PortalServicios/externalGuest.jsp" method="post">
                  <button type="submit" class="btn btn-info">Pago en Linea</button>
                  <input type="hidden" name="system" value="SISCER">
                  <input type="hidden" name="systemToken" value="6DFC9F2EE4829768">
                  <input type="hidden" name="externalProcessID" value="<?php echo $folio ?>">
                  <input type="hidden" name="tid" value="31">
                  <input type="hidden" name="nombre" value="<?php echo $nombre_alumno ?>">
                  <input type="hidden" name="primerApellido" value="<?php echo $a_paterno ?>">
                  <input type="hidden" name="segundoApellido" value="<?php echo $a_materno ?>">
                  <input type="hidden" name="correo" value="<?php echo $email ?>">
                  <input type="hidden" name="comentarios" value="PASE DE CAJA DESDE SISCER">
                  <input type="hidden" name="successPage" value="http://portal.usebeq.edu.mx:8080/portal/portal/tramites_ryc.php">
                  <input type="hidden" name="errorPage" value="http://portal.usebeq.edu.mx:8080/portal/portal/tramites_ryc.php">
                  <input type="hidden" name="ventanilla" value="N">
                  <input type="hidden" name="usuarioREGER" value="portal">
                </form>
              </div>

            <?php } ?>
            <?php if ($tt == "EG") { 

            if ($status == "ACEPTADA") {?>

              <div class="row col-12 justify-content-center">
                <label><b>folio: <?php echo $folio ?></b></label>
              </div>

              <div class="row col-12 justify-content-center">
                <label><b>Nombre de solicitante: <?php echo $nombre_alumno." ".$a_paterno." ".$a_materno ?></b></label>
              </div>

              <div class="row col-12 justify-content-center">
                <label><b>Trámite realizado: Evaluación General de Conocimientos <?php //echo $tipo_tramite ?></b></label>
                <br><br>
              </div>

              <div class="row col-12 justify-content-center">
                <?php echo $mensaje ?>
              </div>

              <div class="row col-12 justify-content-center">
                <?php echo $estado ?>
              </div>

            <?php }elseif ($status == "RECHAZADA") {?>

              <div class="row col-12 justify-content-center">
                <label><b>folio: <?php echo $folio ?></b></label>
              </div>

              <div class="row col-12 justify-content-center">
                <label><b>Nombre de solicitante: <?php echo $nombre_alumno." ".$a_paterno." ".$a_materno ?></b></label>
              </div>

              <div class="row col-12 justify-content-center">
                <label><b>Trámite realizado: Evaluación General de Conocimientos <?php //echo $tipo_tramite ?></b></label>
                <br><br>
              </div>

              <div class="row col-12 justify-content-center">
                <label><?php echo $mensaje ?></label>
              </div>

              <div class="row col-12 justify-content-center">
                <label><?php echo $estado ?></label>
              </div>
              
            <?php }
            } ?>

					<?php
					if ($status == "ERROR AL FIRMAR" OR $status == "SOLICITADO CON ERROR") { ?>

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
							<label><b>Trámite realizado: <?php echo $tipo_tramite ?></b></label>
							<br><br>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Estado del trámite: <?php echo $estado ?></b></label>
							<br><br>
						</div>

						<div class="col-lg-12 form-group text-center">
							<form action="tramites_ryc.php" method="post">
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