<?php

	require("../conexion.php");

	$folio = $_GET['folio'];

	$registro = $conexion->query("SELECT * FROM tramite_revocaciong WHERE folio = '$folio' and  estatus = 'APROBADA'");

	foreach($registro as $cert){

	    $curp = $cert['al_curp'];
	    $nombre = rtrim($cert['al_nombreComp']);
	    $cct = rtrim($cert['cct']);
	    $nombre_esc = rtrim($cert['esc_nombre']);
	    $grado = $cert['al_grado'];
	    $folio = $cert['folio']; 
	    $nivel = $cert['nivel'];       
	    $motivo = "REVOCACIÓN DE GRADO";
	    $realiza = $cert['padre_nombre'];
	    $fecha_res =substr($cert['fecha_elaborado'],0,10);
	    $fecha = date("d-m-Y");
		$ciclo = $cert['ciclo_escolar'];

	  }

	  if ($nivel == 'PRE'){
		$nivel = 'PREESCOLAR';
	  }elseif ($nivel == 'PRI') {
		$nivel = 'PRIMARIA';
	  }elseif ($nivel == 'SEC'){
		$nivel = 'SECUNDARIA';
	  }

	include('encabezado_revo.php');

	$pdf = new PDF('P','mm','Letter');
	$pdf->AddPage();

	$pdf->SetXY(10, 40);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(110, 7, 'NOMBRE DEL ALUMNO:',1 ,1, 'L', 1);
	$pdf->SetXY(120, 40);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

	$pdf->SetXY(10, 47);
	$pdf->SetFont('Arial', '', 11);
	$pdf->Cell(110, 7, utf8_decode($nombre),1 ,1, 'L', 0);
	$pdf->SetXY(120, 47);
	$pdf->SetFont('Arial', '', 11);
	$pdf->Cell(85, 7, $curp,1 ,1, 'L', 0);

	$pdf->SetXY(10, 60);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(30, 7, 'CLAVE CT:',1 ,1, 'L', 1);
	$pdf->SetXY(40, 60);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(113, 7, 'NOMBRE DE LA ESCUELA:',1 ,1, 'L', 1);
	$pdf->SetXY(153, 60);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(52, 7, 'ENTIDAD FEDERATIVA:',1 ,1, 'L', 1);

	$pdf->SetXY(10, 67);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(30, 7, $cct,1 ,1, 'L', 0);
	$pdf->SetXY(40, 67);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(113, 7, utf8_decode($nombre_esc),1 ,1, 'L', 0);
	$pdf->SetXY(153, 67);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(52, 7, utf8_decode('QUERÉTARO'),1 ,1, 'L', 0);

	$pdf->SetXY(10, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(30, 7, 'CICLO:',1 ,1, 'L', 1);
	$pdf->SetXY(40, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(45, 7, 'NIVEL:',1 ,1, 'L', 1);
	$pdf->SetXY(85, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(35, 7, 'GRADO:',1 ,1, 'L', 1);
	$pdf->SetXY(120, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(33, 7, 'FOLIO:',1 ,1, 'L', 1);
	$pdf->SetXY(153, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(52, 7,utf8_decode('FECHA APROBACIÓN:'),1 ,1, 'L', 1);

	$pdf->SetXY(10, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(30, 7, $ciclo,1 ,1, 'C', 0);
	$pdf->SetXY(40, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(45, 7, $nivel,1 ,1, 'C', 0);
	$pdf->SetXY(85, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(35, 7, $grado,1 ,1, 'C', 0);
	$pdf->SetXY(120, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(33, 7, $folio,1 ,1, 'C', 0);
	$pdf->SetXY(153, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(52, 7, $fecha_res,1 ,1, 'C', 0);

	$pdf->SetXY(10, 94);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(96, 7, utf8_decode('TRÁMITE:'),1 ,1, 'L', 1);
	$pdf->SetXY(106, 94);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(99, 7, utf8_decode('QUIEN SOLICITA LA REVOCACIÓN DE GRADO:'),1 ,1, 'L', 1);

	$pdf->SetXY(10, 101);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(96, 7, utf8_decode($motivo),1 ,1, 'L', 0);
	$pdf->SetXY(106, 101);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(99, 7, utf8_decode($realiza),1 ,1, 'L', 0);

	$pdf->SetXY(10, 115);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->MultiCell(192, 4, utf8_decode('SE GENERA EL PRESENTE DOCUMENTO A SOLICITUD DEL PADRE, MADRE DE FAMILIA O TUTOR, PARA LOS FINES ACADÉMICOS QUE REQUIERA, CONSIDERE QUE LA INSCRIPCIÓN PODRÁ REALIZARLA AL INICIO DEL CICLO ESCOLAR 2025-2026.'));

	$pdf->SetXY(10, 130);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(96, 7, utf8_decode('FECHA DE IMPRESIÓN: '.$fecha),0 ,1, 'L', );

	$pdf->Output();

	$conexion = null;

?>