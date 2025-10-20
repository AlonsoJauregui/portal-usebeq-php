<?php 
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require("../conexion.php");

	$tipo = $_POST['tipo'];

	if ($tipo == "REVALIDACION DE ESTUDIOS") {

		//Obtenemoss los datos del formulario
		$nombre = mb_strtoupper($_POST['nombre']);
		$apaterno = mb_strtoupper($_POST['apat']);
		$amaterno = mb_strtoupper($_POST['amat']);
		$domicilio = mb_strtoupper($_POST['domicilio']);
		$nacionalidad = mb_strtoupper($_POST['nacionalidad']);
		$pais = mb_strtoupper($_POST['pais']);
		$sexo = mb_strtoupper($_POST['sexo']);
		$cct = mb_strtoupper($_POST['cct']);
		$nivel = mb_strtoupper($_POST['nivel']);
		$email = mb_strtolower($_POST['email']);
		$tel = $_POST['tel'];
		$realiza = mb_strtoupper($_POST['realiza']);

		$iniciales = substr($nombre, 0, 1).substr($apaterno, 0, 1).substr($amaterno, 0, 1);

		//Extraemos el tipo de extension del documento cargado
		$archivo = $_FILES["identificacion"]["type"];

		//Verificammos si se cargo un archivo PDF
		if ($archivo == "application/pdf") {
			//echo "si es un pdf";

			//Se verifica si hay algun error en el documento cargado
			if ($_FILES["identificacion"]["error"] == 0) {

				$fecha = date("d-m-Y");
				$year = date("Y");
				$year1 = date("y");
				$estatus = "SOLICITADO";
				$folio_ant = "";

				//Buscamos el folio anterior para asignar nuevo folio
				$con_folio = $conexion->query("SELECT TOP(1) folio FROM tramites_portal WHERE tipo_tramite = 'REVALIDACION DE ESTUDIOS' AND YEAR(fecha) = '$year' ORDER BY folio DESC");

				foreach ($con_folio as $llave1) {
					$folio_ant = $llave1['folio'];
				}

				if ($folio_ant == "") {

					//echo "No hay ningun trámite previo";
					$folio = "RE".$year1."-0001";

				}
				else {

					$folio = $folio_ant;
					$folio++;

				}

				$ruta = "tramites_portal/";
				$archivo_iden = $ruta.$folio.$iniciales.".pdf";
				$ruta_guarda = "D:/certificados_pdf/tramites_portal/".$folio.$iniciales.".pdf";

				//guardamos el archivo y registramos el tramite
				$carga1 = @move_uploaded_file($_FILES["identificacion"]["tmp_name"] , $ruta_guarda);

				$inserta_rev = $conexion->query("INSERT INTO tramites_portal (folio, nombre, a_paterno, a_materno, domicilio, nacionalidad, pais_estado, sexo, clave_deseo, revalida_nivel, correo, tel, solicitante, tipo_tramite, responsable, estatus, fecha, ruta_doc, core) VALUES ('$folio', '$nombre', '$apaterno', '$amaterno', '$domicilio', '$nacionalidad', '$pais', '$sexo', '$cct', '$nivel', '$email', '$tel', '$realiza', 'REVALIDACION DE ESTUDIOS', 'ALICIA HURTADO GUZMAN', '$estatus', '$fecha', '$archivo_iden', 'EN LINEA')");

				//echo "el folio es: ".$folio_ant;
				$mensaje = 0;


			}
			else {
				//echo "Hay algun error con el archivo cargado";
				$mensaje = 1;
			}

		}
		else {
			//echo "no es un pdf";
			$mensaje = 2;
		}

	}
	if ($tipo == "LEGALIZACION DE FIRMA") {

		//Obtenemoss los datos del formulario
		$nombre = mb_strtoupper($_POST['nombre']);
		$apaterno = mb_strtoupper($_POST['apat']);
		$amaterno = mb_strtoupper($_POST['amat']);
		$domicilio = mb_strtoupper($_POST['domicilio']);
		$doc_lega = $_POST['doc'];
		$cct = mb_strtoupper($_POST['cct']);
		$email = mb_strtolower($_POST['email']);
		$tel = $_POST['tel'];

		$iniciales = substr($nombre, 0, 1).substr($apaterno, 0, 1).substr($amaterno, 0, 1);

		//Extraemos el tipo de extension del documento cargado
		$archivo = $_FILES["identificacion"]["type"];

		//Verificammos si se cargo un archivo PDF
		if ($archivo == "application/pdf") {
			//echo "si es un pdf";

			//Se verifica si hay algun error en el documento cargado
			if ($_FILES["identificacion"]["error"] == 0) {

				$fecha = date("d-m-Y");
				$year = date("Y");
				$year1 = date("y");
				$estatus = "SOLICITADO";
				$folio_ant = "";

				//Buscamos el folio anterior para asignar nuevo folio
				$con_folio = $conexion->query("SELECT TOP(1) folio FROM tramites_portal WHERE tipo_tramite = 'LEGALIZACION DE FIRMA' AND YEAR(fecha) = '$year' ORDER BY folio DESC");

				foreach ($con_folio as $llave1) {
					$folio_ant = $llave1['folio'];
				}

				if ($folio_ant == "") {

					//echo "No hay ningun trámite previo";
					$folio = "LE".$year1."-0001";

				}
				else {

					$folio = $folio_ant;
					$folio++;

				}

				//validamos que la clave sea del estado y valida
				$cct_estado = substr($cct, 0, 2);
				if ($cct_estado == 22) {
					
					//buscamos el responsable de la escuela
					$responsable = $conexion->query("SELECT TOP(1) RESPONSABLE FROM RESPONSABLES WHERE CLAVE = '$cct'");

					foreach($responsable as $fila){
						$usuario = rtrim($fila['RESPONSABLE']);
					}

					if ($usuario == "") {
						
						//echo "la clave de la escuela no es correcta";
						$mensaje = 4;

					}
					else {

						$ruta = "tramites_portal/";
						$archivo_iden = $ruta.$folio.$iniciales.".pdf";

						//guardamos el archivo y registramos el tramite
						$carga1 = @move_uploaded_file($_FILES["identificacion"]["tmp_name"] , $archivo_iden);

						$inserta_rev = $conexion->query("INSERT INTO tramites_portal (folio, nombre, a_paterno, a_materno, domicilio, clave_deseo, correo, tel, doc_legaliza, tipo_tramite, responsable, estatus, fecha, ruta_doc, core) VALUES ('$folio', '$nombre', '$apaterno', '$amaterno', '$domicilio', '$cct', '$email', '$tel', '$doc_lega', 'LEGALIZACION DE FIRMA', '$usuario', '$estatus', '$fecha', '$archivo_iden', 'EN LINEA')");

						$mensaje = 0;

					}

				}
				else {

					//echo "la clave de la escuela pertenece a otro estado";
					$mensaje = 3;

				}

			}
			else {
				//echo "Hay algun error con el archivo cargado";
				$mensaje = 1;
			}

		}
		else {
			//echo "no es un pdf";
			$mensaje = 2;
		}

	}
	if ($tipo == "EXAMEN GENERAL") {

		//Obtenemoss los datos del formulario
		$nombre = mb_strtoupper($_POST['nombre']);
		$apaterno = mb_strtoupper($_POST['apat']);
		$amaterno = mb_strtoupper($_POST['amat']);
		$curp = mb_strtoupper($_POST['curp']);
		$grado = $_POST['gra'];
		$email = mb_strtolower($_POST['email']);
		$tel = $_POST['tel'];
		$realiza = mb_strtoupper($_POST['realiza']);

		$iniciales = substr($nombre, 0, 1).substr($apaterno, 0, 1).substr($amaterno, 0, 1);

		// Validamos si ya existe un tramite anterior
		$existe_otra = $conexion->query("SELECT folio, COUNT(1) AS Total FROM tramites_portal WHERE tipo_tramite = 'EVALUACION GENERAL' AND curp = '$curp' AND nombre = '$nombre' AND estatus IN ('SOLICITADO', 'CON ERROR', 'PENDIENTE') GROUP BY folio");

		if ($existe_otra->rowCount() == 0) {
			
			//Extraemos el tipo de extension del documento cargado
			$archivo = $_FILES["identificacion"]["type"];

			//Verificammos si se cargo un archivo PDF
			if ($archivo == "application/pdf") {
				//echo "si es un pdf";

				//Se verifica si hay algun error en el documento cargado
				if ($_FILES["identificacion"]["error"] == 0) {

					$fecha = date("d-m-Y");
					$year = date("Y");
					$year1 = date("y");
					$estatus = "SOLICITADO";
					$folio_ant = "";

					//Buscamos el folio anterior para asignar nuevo folio
					$con_folio = $conexion->query("SELECT TOP(1) folio FROM tramites_portal WHERE tipo_tramite = 'EVALUACION GENERAL' AND YEAR(fecha) = '$year' ORDER BY folio DESC");

					foreach ($con_folio as $llave1) {
						$folio_ant = $llave1['folio'];
					}

					if ($folio_ant == "") {

						//echo "No hay ningun trámite previo";
						$folio = "EG".$year1."-0001";

					}
					else {

						$folio = $folio_ant;
						$folio++;

					}

					$ruta = "tramites_portal/";
					$archivo_iden = $ruta.$folio.$iniciales.".pdf";
					$ruta_guarda = "D:/certificados_pdf/tramites_portal/".$folio.$iniciales.".pdf";

					//guardamos el archivo y registramos el tramite
					$carga1 = @move_uploaded_file($_FILES["identificacion"]["tmp_name"] , $ruta_guarda);

					$inserta_rev = $conexion->query("INSERT INTO tramites_portal (folio, curp, nombre, a_paterno, a_materno, correo, tel, solicitante, grado_cursado, tipo_tramite, responsable, estatus, fecha, ruta_doc, core) VALUES ('$folio', '$curp', '$nombre', '$apaterno', '$amaterno', '$email', '$tel', '$realiza', '$grado', 'EVALUACION GENERAL', 'SISCER', '$estatus', '$fecha', '$archivo_iden', 'EN LINEA')");

					//echo "el folio es: ".$folio_ant;
					$mensaje = 0;

					// Envio de correo electronico
					$correo = $email;
					$cuenta_act   = 'solicitar correo';

					require 'PHPMailer/src/Exception.php';
					require 'PHPMailer/src/PHPMailer.php';
					require 'PHPMailer/src/SMTP.php';

					$mail = new PHPMailer(true);

					//INICIO - Código agregado por Neored para hacer compatible la libreria con la ultima versión de PHP
					$mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					)
					);
					// FIN - Código agregado por Neored

					try {

						//Server settings
						$mail->SMTPDebug = 0;                                       // Enable verbose debug output
						$mail->isSMTP();                                            // Set mailer to use SMTP
						$mail->Host       = 'ssmtp.neosmtp.com';                    //'smtp.gmail.com';  						// Specify main and backup SMTP servers
						$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
						$mail->Username   = 'solicitar usuario';           //$cuenta_act;        // SMTP username
						$mail->Password   = 'solicitar pass'; //'12345678';                             // SMTP password
						$mail->SMTPSecure = 'TLS';                                  // Enable TLS encryption, `ssl` also accepted
						$mail->Port       = '2525';  

						//Recipients
						$mail->setFrom($cuenta_act, utf8_decode('Portal de Trámites en Linea USEBEQ'));
						$mail->addAddress($correo);     								// Add a recipient

						// Content
						$mail->isHTML(true);                                  // Set email format to HTML
						$mail->Subject = utf8_decode("Solicitud Evaluación General de Conocimientos");
						$mail->Body    = "
						<head>
							<style>
						        body {
						            font-family: Arial, sans-serif;
						            background-color: #f4f4f4;
						            margin: 0;
						            padding: 0;
						            text-align: center;
						        }
						        .email-container {
						            background-color: #ffffff;
						            margin: 50px auto;
						            padding: 20px;
						            max-width: 600px;
						            border-radius: 8px;
						            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
						        }
					            .header-table {
						            width: 100%;
						        }
						        .header-table img {
						            max-width: 100px;
						        }
						        h1 {
						            color: #333333;
						        }
						        p {
						            color: #666666;
						            line-height: 1.5;
						        }
						        .button {
						            display: inline-block;
						            padding: 10px 20px;
						            margin-top: 20px;
						            font-size: 16px;
						            color: white;
						            background-color: #007BFF;
						            text-decoration: none;
						            border-radius: 5px;
						        }
						    </style>
						</head>
						<body>
						    <div class='email-container'>
					            <table class='header-table' cellpadding='0' cellspacing='0' border='0'>
						            <tr>
						                <td style='text-align: left; padding: 0px;'>
						                    <img src='https://portal.usebeq.edu.mx/portal_pruebas/login/images/Familia_USEBEQ.png' alt='Logo Izquierdo'>
						                </td>
						                <td style='text-align: right; padding: 0px;'>
						                    <img src='https://portal.usebeq.edu.mx/portal_pruebas/login/images/QRO_JUNTOS.png' alt='Logo Derecho'>
						                </td>
						            </tr>
						        </table>
						        <h1>Tu solicitud de Evaluación General de Conocimientos con folio ".$folio." se ha realizado exitosamente.</h1>
						        <p>Pronto tendrás más noticias sobre tu trámite.</p>
			        			<p>Si lo deseas también puedes consultar el estatus de tu solicitud con el número de folio en la opción <b>Estatus del trámite</b> desde https://portal.usebeq.edu.mx/portal/portal/tramites_ryc.php o dando clic en el botón de abajo.</p>
			        			<a href='https://portal.usebeq.edu.mx/portal/portal/tramites_ryc.php' style='display: inline-block; padding: 10px 20px; margin-top: 20px; font-size: 16px; color: #ffffff; background-color: #007BFF; text-decoration: none; border-radius: 5px;'>Seguimiento de solicitud</a>

						    </div>
						</body>
						";

						$mail->send();
							  //echo 'Cuenta creada exitosamente, favor de activar su cuenta verificando en su cuenta de correo electronico.';
						//echo "Correo enviado satisfactoriameente.";


					} catch (Exception $e) {
						//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
						$error = "Mailer Error: {$mail->ErrorInfo}";
						//echo $error;
					}


				}
				else {
					//echo "Hay algun error con el archivo cargado";
					$mensaje = 1;
				}

			}
			else {
				//echo "no es un pdf";
				$mensaje = 2;
			}

		}
		else {

			foreach ($existe_otra as $exis) {
				$numero = $exis['Total'];
				$folio_ant = $exis['folio'];
			}

			$mensaje = 5;

		}

	}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Trámites en Línea
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
                  <h3 class="mb-0">Trámites en Línea</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">
                    
                  </div>

                  <div class="row">

                  	<?php if ($mensaje == 0) { ?>

						<div class='row col-12 justify-content-center'>

	            <h4 align='center' class=''><b>Su solicitud se ha realizado correctamente, por favor imprimir su comprobante.</b></h4><br>

	          </div>

						<div class="col-lg-12 form-group text-center">

							<form action="tramites_ryc.php" method="post" enctype=" ">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>

							<br>

							<?php if ($tipo == "REVALIDACION DE ESTUDIOS") { ?>
								<form action="imprime_sol_reva.php" target="_blank" method="post" enctype=" ">
									<input type="hidden" name="nombre" value="<?php echo $nombre ?>">
									<input type="hidden" name="apaterno" value="<?php echo $apaterno ?>">
									<input type="hidden" name="amaterno" value="<?php echo $amaterno ?>">
									<input type="hidden" name="sexo" value="<?php echo $sexo ?>">
									<input type="hidden" name="nivel" value="<?php echo $nivel ?>">
									<input type="hidden" name="folio" value="<?php echo $folio ?>">        	
			            <input type="hidden" name="fecha" value="<?php echo $fecha ?>">
									<button type="submit" class="btn btn-info">Imprimir Solicitud</button>
								</form>
							<?php } if ($tipo == "LEGALIZACION DE FIRMA") { ?>
								<form action="imprime_sol_tramite.php" target="_blank" method="post" enctype=" ">
									<input type="hidden" name="nombre" value="<?php echo $nombre ?>">
									<input type="hidden" name="apaterno" value="<?php echo $apaterno ?>">
									<input type="hidden" name="amaterno" value="<?php echo $amaterno ?>">
									<input type="hidden" name="tipo" value="<?php echo $tipo ?>"> 
									<input type="hidden" name="folio" value="<?php echo $folio ?>">        	
			            <input type="hidden" name="fecha" value="<?php echo $fecha ?>">
									<button type="submit" class="btn btn-info">Imprimir Solicitud</button>
								</form>
							<?php } if ($tipo == "EXAMEN GENERAL") { ?>
								<form action="imprime_sol_tramite.php" target="_blank" method="post" enctype=" ">
									<input type="hidden" name="nombre" value="<?php echo $nombre ?>">
									<input type="hidden" name="apaterno" value="<?php echo $apaterno ?>">
									<input type="hidden" name="amaterno" value="<?php echo $amaterno ?>">
									<input type="hidden" name="tipo" value="<?php echo $tipo ?>">
									<input type="hidden" name="folio" value="<?php echo $folio ?>">        	
			            <input type="hidden" name="fecha" value="<?php echo $fecha ?>">
									<button type="submit" class="btn btn-info">Imprimir Solicitud</button>
								</form>
							<?php } ?>

						</div>

					<?php } if ($mensaje == 1) { ?>

						<div class='row col-12 justify-content-center'>

	            <h4 align='center' class=''><b>El documento cargado cuenta con algún error, por favor verifique el archivo e intente nuevamente.</b></h4><br>

	          </div>

						<div class="col-lg-12 form-group text-center">

							<form action="tramites_ryc.php" method="post" enctype=" ">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>

						</div>

					<?php } if ($mensaje == 2) { ?>

						<div class='row col-12 justify-content-center'>

	                      	<h4 align='center' class=''><b>El documento cargado no es un archivo en formato PDF, por favor verifique que el archivo se encuentre en formato PDF e intente nuevamente.</b></h4><br>

	                    </div>

						<div class="col-lg-12 form-group text-center">

							<form action="tramites_ryc.php" method="post" enctype=" ">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>

						</div>

					<?php } if ($mensaje == 3) { ?>

						<div class='row col-12 justify-content-center'>

	                      	<h4 align='center' class=''><b>La clave de la escuela no pertenece al estado de Querétaro, por favor verifique la clave ingresada e intente nuevamente.</b></h4><br>

	                    </div>	

						<div class="col-lg-12 form-group text-center">

							<form action="tramites_ryc.php" method="post" enctype=" ">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>

						</div>

					<?php } if ($mensaje == 4) { ?>

						<div class='row col-12 justify-content-center'>

	                      	<h4 align='center' class=''><b>La clave de la escuela no se encuentra, por favor verifique la clave ingresada e intente nuevamente.</b></h4><br>

	                    </div>		

	                  	<div class="col-lg-12 form-group text-center">

							<form action="tramites_ryc.php" method="post" enctype=" ">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>

						</div>

					<?php } if ($mensaje == 5) { ?>

						<div class='row col-12 justify-content-center'>

	                      	<h4 align='center' class=''><b>Ya existe una solicitud anterior con el folio <?php echo $folio_ant ?>, favor de dar seguimiento a su solicitud anterior.</b></h4><br>

	                    </div>		

	                  	<div class="col-lg-12 form-group text-center">

							<form action="tramites_ryc.php" method="post" enctype=" ">
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