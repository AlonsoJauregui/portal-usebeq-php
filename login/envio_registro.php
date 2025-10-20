<?php 

require("../conexion.php");

// tomo los datos del formulario anterior.
$folio = trim($_POST['folio']);
$email = $_POST['email'];
$tel = $_POST['tel'];
$msg =  mb_strtoupper($_POST['msg']);

$revisalog = $conexion->query("SELECT COUNT(folio) AS NUMERO FROM log_doc_portal WHERE folio = '$folio'");

foreach ($revisalog as $rev) {
	$cuentalog = $rev['NUMERO'];
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($cuentalog == 0) {

	$verifica7 = $conexion->query("SELECT COUNT(pr_id) AS TOTAL FROM SCE007 WHERE pr_id = '$folio'");

	foreach($verifica7 as $veri) {
		$numero = $veri['TOTAL'];
	}

	if ($numero > 0) {

		//echo "Si se enccontro el folio de preinscripción<br>";

		$datos7 = $conexion->query("SELECT al_curp, al_nombre, al_appat, al_apmat, cvecct_F, nomct_F, turno_f, al_estatus FROM SCE007 WHERE pr_id = '$folio'");

		foreach($datos7 as $dat) {
			$al_curp = $dat['al_curp'];
			$al_nombre = $dat['al_nombre'];
			$al_appat = $dat['al_appat'];
			$al_apmat = $dat['al_apmat'];
			$cvecct_F = $dat['cvecct_F'];
			$nomct_F = $dat['nomct_F'];
			$turno_f = $dat['turno_f'];
			$al_estatus = $dat['al_estatus'];
		}

		if ($al_estatus == "V") {
			$es = "ESCUELA VALIDADA";
		}
		if ($al_estatus == "P") {
			$es = "ESCUELA PENDIENTE DE VALIDACION";
		}
		if ($al_estatus == "R") {
			$es = "ALUMNO NO REALIZO VALIDACIÓN EN FEBRERO";
		}

		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';

		$mail = new PHPMailer(true);

		$file = fopen("bandera4.txt", "r");

		while(!feof($file)) {

			$flag = fgets($file);
					//echo "la bandera es: ".$flag."<br>";

		}

		fclose($file);

		if ($flag == 1) {

			$cuenta_act   = 'controlescolar30@usebeq.edu.mx';

		}
		if ($flag == 2) {

			$cuenta_act   = 'controlescolar2@usebeq.edu.mx';

		}
		if ($flag == 3) {

			$cuenta_act   = 'controlescolar3@usebeq.edu.mx';

		}
		if ($flag == 4) {

			$cuenta_act   = 'controlescolar4@usebeq.edu.mx';

		}
		if ($flag == 5) {

			$cuenta_act   = 'controlescolar5@usebeq.edu.mx';

		}
		if ($flag == 6) {

			$cuenta_act   = 'controlescolar6@usebeq.edu.mx';

		}
		if ($flag == 7) {

			$cuenta_act   = 'controlescolar7@usebeq.edu.mx';

		}
		if ($flag == 8) {

			$cuenta_act   = 'controlescolar7@usebeq.edu.mx';

		}
		if ($flag == 9) {

			$cuenta_act   = 'controlescolar9@usebeq.edu.mx';

		}
		if ($flag == 10) {

			$cuenta_act   = 'controlescolar8@usebeq.edu.mx';

		}
		if ($flag == 11) {

			$cuenta_act   = 'controlescolar11@usebeq.edu.mx';

		}
		if ($flag == 12) {

			$cuenta_act   = 'controlescolar12@usebeq.edu.mx';

		}
		if ($flag == 13) {

			$cuenta_act   = 'controlescolar13@usebeq.edu.mx';

		}
		if ($flag == 14) {

			$cuenta_act   = 'controlescolar14@usebeq.edu.mx';

		}
		if ($flag == 15) {

			$cuenta_act   = 'controlescolar16@usebeq.edu.mx';

		}
		if ($flag == 16) {

			$cuenta_act   = 'controlescolar16@usebeq.edu.mx';

		}
		if ($flag == 17) {

			$cuenta_act   = 'controlescolar17@usebeq.edu.mx';

		}
		if ($flag == 18) {

			$cuenta_act   = 'controlescolar18@usebeq.edu.mx';

		}
		if ($flag == 19) {

			$cuenta_act   = 'controlescolar19@usebeq.edu.mx';

		}
		if ($flag == 20) {

			$cuenta_act   = 'controlescolar20@usebeq.edu.mx';

		}
		if ($flag == 21) {

			$cuenta_act   = 'controlescolar21@usebeq.edu.mx';

		}
		if ($flag == 22) {

			$cuenta_act   = 'controlescolar22@usebeq.edu.mx';

		}
		if ($flag == 23) {

			$cuenta_act   = 'controlescolar23@usebeq.edu.mx';

		}
		if ($flag == 24) {

			$cuenta_act   = 'controlescolar24@usebeq.edu.mx';

		}
		if ($flag == 25) {

			$cuenta_act   = 'controlescolar25@usebeq.edu.mx';

		}
		if ($flag == 26) {

			$cuenta_act   = 'controlescolar26@usebeq.edu.mx';

		}
		if ($flag == 27) {

			$cuenta_act   = 'controlescolar27@usebeq.edu.mx';

		}
		if ($flag == 28) {

			$cuenta_act   = 'controlescolar28@usebeq.edu.mx';

		}
		if ($flag == 29) {

			$cuenta_act   = 'controlescolar29@usebeq.edu.mx';

		}
		if ($flag == '') {
			$cuenta_act = 'controlescolar29@usebeq.edu.mx';
			$flag = 29;
		}

		try {

			//Server settings
			$mail->SMTPDebug = 0;                                       // Enable verbose debug output
			$mail->isSMTP();                                            // Set mailer to use SMTP
			$mail->Host       = 'smtp.gmail.com';  						// Specify main and backup SMTP servers
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = $cuenta_act;        // SMTP username
			$mail->Password   = '';                             // SMTP password
			$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port       = 587;                                    // TCP port to connect to

			$email_va = "modulo2021@usebeq.edu.mx";
			//Recipients
			$mail->setFrom($cuenta_act, 'PortalPadres');
			$mail->addAddress($email_va);     								// Add a recipient

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = utf8_decode("Envio de documentos Aclaración");
			$mail->Body    = "Folio de ficha: ".$folio."<br>Correo proporcionado: ".$email."<br>Telefono proporcionado: ".$tel."<br>Mensaje: ".$msg."<br><br>Datos del alumno: <br>Nombre: ".$al_nombre." ".$al_appat." ".$al_apmat."<br>CURP: ".$al_curp."<br>Escuela asignada: ".$cvecct_F." ".$nomct_F." ".$turno_f."<br>Estatus proceso: ".$es;

			if (isset($_FILES['a1']) AND $_FILES["a1"]["error"] == 0) {
				$mail->AddAttachment($_FILES["a1"]['tmp_name'], $_FILES["a1"]['name']);
			}
			if (isset($_FILES['a2']) AND $_FILES["a2"]["error"] == 0) {
				$mail->AddAttachment($_FILES["a2"]['tmp_name'], $_FILES["a2"]['name']);
			}
			if (isset($_FILES['a3']) AND $_FILES["a3"]["error"] == 0) {
				$mail->AddAttachment($_FILES["a3"]['tmp_name'], $_FILES["a3"]['name']);
			}

			$mail->send();

			$fecha = date("d-m-Y");

			$guarda_sol = $conexion->query("INSERT INTO log_doc_portal (folio, al_curp, email, tel, email_envia, fecha) VALUES ('$folio', '$al_curp', '$email', '$tel', '$cuenta_act', '$fecha')");

			$mensaje = 3;

		} catch (Exception $e) {
			$mensaje = 5;
		}

			++$flag;

			if ($flag == 30) {
				$flag = 1;
			}

			$file = fopen("bandera4.txt", "w");

			fwrite($file, $flag);

			fclose($file);

	}
	else {

		$mensaje = 4;

	}

}
else {
	$mensaje = 6;
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
  <link href="../portal/assets/img/brand/favicon.ico" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="../portal/assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="../portal/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../portal/assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link href="../portal/assets/fontawesome.min.css" rel="stylesheet">

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
                <img alt="Image placeholder" width="150" src="../portal/assets/img/brand/USEBEQN.png">
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
                <img src="../portal/assets/img/brand/USEBEQB.png">
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
        <a class="h1 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="../index.php">
          &nbsp;SISCER
        </a>
        <!-- Form -->
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="">
                  <img alt="Image placeholder" width="160" src="../portal/assets/img/brand/USEBEQB.png">
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
                  <h3 class="mb-0">Buzón Portal de Padres.</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">

                   <div class="row col-12 justify-content-center">

                   	  <?php if ($mensaje == 6) { 
                   	  	//cuando ya se realizo un envio al buzon con el mismo folio de preinscripción?>
                        <h4 align="center" class=""><b class="text-danger">Ya se ha realizado una petición anteriormente, por favor esté atento de respuesta por los medios de contacto que proporciono.</b></h4>
                  	  <?php } if ($mensaje == 5) { 
                  	  	// si se generó algun problema con los documentos proporcionados o con el envío del correo electrónico?>
                  	  	<h4 align="center" class=""><b class="text-danger">Se ha producido un error al intentar generar su solicitud, por favor revise la información y documentos proporcionados e intente nuevamente.</b></h4>
                  	  <?php } if ($mensaje == 4) { 
                  	  	// cuando el folio proporcionado no existe en la base de datos?>
                  	  	<h4 align="center" class=""><b class="text-danger">El folio de preinscripción proporcionado no existe para este proceso, favor de verificarlo.</b></h4>
                  	  <?php } if ($mensaje == 3) { 
                  	  	// si se generó la solicitud en el buzon correctamente?>
                  	  	<h4 align="center" class=""><b class="text-danger"></b>Envió exitoso de documentos, favor de esperar respuesta a través de los datos de contacto proporcionados.</h4>
                  	  <?php } ?>
                      <br><br>

                    </div>
                    
                  </div>

                  <div id="dato">

                    <form action='../index.php' method='POST'>
                    <div class='row'>
                      <div class='row col-12 justify-content-center espacios'>
                      </div>
                      
                      <div class='col-lg-12 form-group text-center'>
                        <input type='submit' id='btsubmit' class='btn btn-info' value='Aceptar' />
                      </div>
                    </div>
                  </form>
          
                  </div>

                  
                </div> 
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2021 <a href="https://www.usebeq.edu.mx/PaginaWEB/" class="font-weight-bold ml-1" target="_blank">USEBEQ</a>
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
  <script src="../portal/assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="../portal/assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="../portal/assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script src="../portal/assets/js/formularios.js"></script>
</body>

</html>
