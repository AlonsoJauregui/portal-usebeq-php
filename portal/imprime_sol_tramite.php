<?php

	require("../conexion.php");

	$tipo_tramite = $_POST['tipo'];
	$nombre_alumno = mb_strtoupper($_POST['nombre']);
	$a_paterno = mb_strtoupper($_POST['apaterno']);
	$a_materno = mb_strtoupper($_POST['amaterno']);
	$folio = $_POST['folio'];
	$fecha = $_POST['fecha'];

	if ($tipo_tramite == "LEGALIZACION DE FIRMA") {
		$tipo_tramite = "LEGALIZACIÓN DE FIRMA";
	}
	if ($tipo_tramite == "EXAMEN GENERAL") {
		$tipo_tramite = "EXAMEN GENERAL DE CONOCIMIENTOS";
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

			$pdf->Ln(5);

			$pdf->SetFont('Arial', 'B', 11);	
			$pdf->Cell(67, 6, utf8_decode('TIPO DE TRÁMITE QUE SOLICITÓ:'),0 ,0, 'L', 1);
			$pdf->SetFont('Arial', 'B', 11);
			$pdf->Cell(80, 6, utf8_decode($tipo_tramite),0 ,1, 'L', 1);

			$pdf->Ln(13);
			
		/*	$pdf->Cell(190, 6, utf8_decode('IMPRIME ESTE DOCUMENTO O GUARDA TU NUMERO DE FOLIO, YA QUE ES TU COMPROBANTE DE TRAMITE.'),0 ,1, 'C', 1); */

			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(190, 6, utf8_decode('PARA CUALQUIER DUDA O COMENTARIO RESPECTO A LA INFORMACIÓN DE ESTA SOLICITUD, CONTACTAR A epena@usebeq.edu.mx.'),0 ,1, 'C', 1);
			$pdf->SetFont('Arial', 'B', 8);	
			$pdf->Cell(190, 6, utf8_decode('NOTA: EL TRÁMITE TARDA 6 DÍAS HÁBILES A PARTIR DE LA FECHA DE GENERACIÓN DE ESTA SOLICITUD.'),0 ,1, 'C', 1);
			//$pdf->Cell(190, 6, utf8_decode('EN CASO DE QUE LOS DATOS NO COINCIDAN CON LOS REGISTROS, SE AMPLIARÁ EL TIEMPO DE TRÁMITE.'),0 ,1, 'C', 1);

			$pdf->Ln(2);

			$pdf->SetFont('Arial', 'B', 9.5);
			$pdf->Cell(190, 6, utf8_decode('CONSERVA ESTE COMPROBANTE YA QUE SERÁ REQUERIDO AL MOMENTO DE LA ENTREGA DEL DOCUMENTO.'),0 ,1, 'C', 1);
			$pdf->SetFont('Arial', 'B', 12);	
			$pdf->Cell(190, 6, utf8_decode('* SI NO RECOGE SU DOCUMENTO EN 3 MESES, SE CANCELA.'),0 ,1, 'C', 1);

			$pdf->Cell(190, 6, utf8_decode('-------------------------------------------------------------------------------------------------------------------------------------'),0 ,1, 'C', 1);

			$pdf->SetXY(10, 132);
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(190, 6, utf8_decode('¿COMO DAR SEGUIMIENTO AL TRÁMITE?'),0 ,1, 'C', 1);

			$pdf->SetXY(10, 139);
			$pdf->SetFont('Arial', '', 11);
			$pdf->MultiCell(190, 6, utf8_decode('Generada esta solicitud puede consultar el estatus del trámite, efectuar el pago y realizar la descarga del documento desde la opción "ESTATUS DEL TRÁMITE", ubicada en el menú de opciones donde realizo esta solicitud.'));

			$pdf->SetXY(30, 151);
			$pdf->SetFont('Arial', '', 11);
			$pdf->MultiCell(190, 6, utf8_decode('(http://portal.usebeq.edu.mx:8080/portal/portal/tramites_ryc.php)'));

			$pdf->Image('img/tramites.png', 20, 160, 169, 53);

			$pdf->SetXY(10, 218);
			$pdf->SetFont('Arial', '', 11);
			$pdf->MultiCell(110, 6, utf8_decode('Una vez generado, podrá efectuar el pago del documento mediante el botón que se habilita y permite el pago en línea.

Si el pago es realizado con tarjeta de crédito / débito, la acreditación del pago se verá reflejada el mismo día, en caso de realizar el pago en practicaja de BBVA, la acreditación tardará de 1 a 3 días hábiles.'));

			$pdf->Image('img/pago.png', 130, 225, 70, 27);

			$pdf->SetXY(90, 263);
			$pdf->SetFont('Arial', '', 11);
			$pdf->MultiCell(110, 6, utf8_decode('Acreditado el pago, se muestra el botón para la descarga del Duplicado de certificado.'));

			$pdf->Image('img/pagado.png', 10, 263, 70, 21);

			$pdf->Output();

			$conexion = null;

?>