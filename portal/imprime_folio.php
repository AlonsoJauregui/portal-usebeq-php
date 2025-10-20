<?php

	require("../conexion.php");

	$curp = $_POST['curp'];	
	$folio = $_POST['folio'];
	$mensaje = 0;

	//$curp = 'OEPY041002MQTLRDA8';	
	//$curp = 'RESA100813MQTSLSA4';	
	//$folio = '2025-IV-01909';


	//echo $curp." ".$folio;


	// Revisar en base de datos la inserción del registro, empatar con folio y curp 
	$consultar_reg = $conexion->query("SELECT * FROM tramites1 WHERE folio = '$folio' AND curp = '$curp'");
	$result = $consultar_reg->rowCount();
	// $consultar_reg = $conexion->query("SELECT * FROM tramites1 WHERE  curp = '$curp'");
	//$result = $consultar_reg->fetchColumn();
	// https://es.stackoverflow.com/questions/153612/dato-incorrecto-al-obtener-valor-count-de-una-consulta-con-rowcount-pdo-php
	//echo $result;
	if ($result == 0){
		
		$mensaje = 1;

	}else {

		foreach($consultar_reg as $fila){
			$curp = $fila['curp'];
			$tipo_tramite = $fila['tipo_tramite'];
			$fecha = $fila['fecha'];
			$nombre_alumno = $fila['nombre_alumno'];
			$a_paterno  = $fila['a_paterno'];
			$a_materno  = $fila['a_materno'];
			$nombre_esc  = $fila['nombre_esc'];
			$turno  = $fila['turno'];
			$cct  = $fila['cct'];
			$dom_esc  = $fila['dom_esc'];
			$ciclo = $fila['ciclo_terminacion'];

		}
		include('pdf_solicitud.php');

			$pdf = new PDF();
			$pdf->AddPage();

			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(113, 6, '' ,0 ,0, 'L', 1);
			$pdf->SetFont('Arial', 'B', 15);
			$pdf->Cell(41, 6, 'Fecha de Solicitud:',0 ,0, 'R', 1);
			$pdf->SetFont('Arial', '', 15);
			$pdf->SetTextColor(0, 0, 0);	
			$pdf->Cell(35, 6, $fecha,0 ,1, 'L', 1);

			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetTextColor(176, 17, 0);	
			$pdf->Cell(125, 15, '' ,0 ,0, 'L', 1);
			$pdf->SetFont('Arial', 'B', 15);
			$pdf->Cell(20, 15, 'Folio:',0 ,0, 'R', 1);
			$pdf->SetFont('Arial', '', 15);
			$pdf->SetTextColor(0, 0, 0);	
			$pdf->Cell(40, 15, $folio,0 ,1, 'C', 1);

			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetFont('Arial', 'B', 11);	
			$pdf->Cell(50, 6, 'NOMBRE DEL ALUMNO: ',0 ,0, 'L', 1);
			$pdf->SetFont('Arial', '', 11);
			$pdf->Cell(110, 6, utf8_decode($nombre_alumno) . " " . utf8_decode($a_paterno) . " " . utf8_decode($a_materno),0 ,1, 'L', 1);

			$pdf->SetFont('Arial', 'B', 11);	
			$pdf->Cell(55, 6, 'NOMBRE DE LA ESCUELA: ',0 ,0, 'L', 1);
			$pdf->SetFont('Arial', '', 11);
			$pdf->Cell(90, 6, utf8_decode($nombre_esc),0 ,0, 'L', 1);
			$pdf->SetFont('Arial', 'B', 11);	
			$pdf->Cell(20, 6, 'TURNO: ',0 ,0, 'L', 1);
			$pdf->SetFont('Arial', '', 11);
			$pdf->Cell(35, 6, $turno,0 ,1, 'L', 1);

			$pdf->SetFont('Arial', 'B', 11);	
			$pdf->Cell(20, 6, 'CLAVE: ',0 ,0, 'L', 1);
			$pdf->SetFont('Arial', '', 11);
			$pdf->Cell(40, 6, $cct,0 ,0, 'L', 1);
			$pdf->SetFont('Arial', 'B', 11);	
			$pdf->Cell(25, 6, utf8_decode('UBICACIÓN:'),0 ,0, 'L', 1);
			$pdf->SetFont('Arial', '', 11);
			$pdf->MultiCell(110, 6, utf8_decode($dom_esc),0 ,1, 'L', 1);

			$pdf->Ln(5);

			$pdf->SetFont('Arial', 'B', 11);	
			$pdf->Cell(67, 6, utf8_decode('TIPO DE TRÁMITE QUE SOLICITÓ:'),0 ,0, 'L', 1);
			$pdf->SetFont('Arial', 'B', 11);
			$pdf->Cell(80, 6, $tipo_tramite,0 ,1, 'L', 1);

			$pdf->SetFont('Arial', 'B', 11);	
			$pdf->Cell(50, 6, utf8_decode('CICLO DE TERMINACIÓN:'),0 ,0, 'L', 1);
			$pdf->SetFont('Arial', '', 11);
			$pdf->Cell(30, 6, $ciclo,0 ,0, 'L', 1);

			$pdf->Ln(13);
			
		/*	$pdf->Cell(190, 6, utf8_decode('IMPRIME ESTE DOCUMENTO O GUARDA TU NUMERO DE FOLIO, YA QUE ES TU COMPROBANTE DE TRAMITE.'),0 ,1, 'C', 1); */

			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(190, 6, utf8_decode('PARA DUDAS O ACLARACIONES, CONTACTAR A epena@usebeq.edu.mx O A TRAVÉS DEL NÚMERO 442-238-6000 EXT. 1330.'),0 ,1, 'C', 1);
			$pdf->SetFont('Arial', 'B', 8);	
			$pdf->Cell(190, 6, utf8_decode('NOTA: EL TRÁMITE TARDA 6 DÍAS HÁBILES A PARTIR DE LA FECHA DE GENERACIÓN DE ESTA SOLICITUD.'),0 ,1, 'C', 1);
			//$pdf->Cell(190, 6, utf8_decode('EN CASO DE QUE LOS DATOS NO COINCIDAN CON LOS REGISTROS, SE AMPLIARÁ EL TIEMPO DE TRÁMITE.'),0 ,1, 'C', 1);

			$pdf->Ln(1);

			$pdf->SetFont('Arial', 'B', 12);	
			$pdf->Cell(190, 8, utf8_decode('* SI NO RECOGE SU DOCUMENTO EN 3 MESES, SE CANCELA.'),0 ,1, 'C', 1);
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor(176, 17, 0);
			$pdf->MultiCell(190, 5, utf8_decode('EL DOCUMENTO NO ES ENVIADO POR CORREO, DEBERÁ DE DAR SEGUIMIENTO A TRAVÉS DEL MEDIO POR EL CUAL REALIZO SU SOLICITUD.'),0, 'C', 1);
			$pdf->SetTextColor(0, 0, 0);

			//$pdf->Cell(190, 6, utf8_decode('-------------------------------------------------------------------------------------------------------------------------------------'),0 ,1, 'C', 1);

			$pdf->SetXY(10, 132);
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(190, 6, utf8_decode('¿COMO DAR SEGUIMIENTO AL TRÁMITE?'),0 ,1, 'C', 1);

			$pdf->SetXY(10, 139);
			$pdf->SetFont('Arial', '', 11);
			$pdf->MultiCell(190, 6, utf8_decode('Generada esta solicitud puede consultar el estatus del trámite, efectuar el pago y realizar la descarga del documento desde la opción "ESTATUS DEL TRÁMITE", ubicada en el menú de opciones donde realizo esta solicitud.'));

			$pdf->SetXY(30, 151);
			$pdf->SetFont('Arial', '', 11);
			$pdf->MultiCell(190, 6, utf8_decode('(http://portal.usebeq.edu.mx:8080/portal/portal/duplicados.php)'));

			$pdf->Image('img/duplicados.png', 20, 160, 169, 53);

			$pdf->SetXY(10, 218);
			$pdf->SetFont('Arial', '', 11);
			$pdf->MultiCell(110, 6, utf8_decode('Una vez generado, podrá efectuar el pago del documento mediante el botón que se habilita y permite el pago en línea.

			Si el pago es realizado con tarjeta de crédito / débito, la acreditación del pago se verá reflejada el mismo día, en caso de realizar el pago en practicaja de BBVA, la acreditación tardará de 1 a 9 días hábiles.'));

			$pdf->Image('img/pago.png', 130, 225, 70, 27);

			$pdf->SetXY(90, 263);
			$pdf->SetFont('Arial', '', 11);
			$pdf->MultiCell(110, 6, utf8_decode('Acreditado el pago, se muestra el botón para la descarga del Duplicado de certificado.'));

			$pdf->Image('img/pagado.png', 10, 263, 70, 21);

			$pdf->Output();

	}

		$conexion = null;

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Duplicados en Linea
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

                  	<?php if ($mensaje == 1) { ?>

                  		<div class="row col-12 justify-content-center">
							<h4 align="center" class="">Error en la conexión del servidor, ingrese nuevamente su solicitud.</h4>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="duplicados.php" method="post" enctype=" ">
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

      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2024 <a href="https://www.usebeq.edu.mx/PaginaWEB/" class="font-weight-bold ml-1" target="_blank">USEBEQ</a>
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

  $verifica_dupli = null;
  $responsable = null;
  $consulta = null;
  $statement = null;
  $extrae = null;
  $dupli = null;
  $conexion = null;

?>