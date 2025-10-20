<?php

	require("../conexion.php");

	$curp = $_POST['curp'];

	$registro = $conexion->query("SELECT * FROM tramite_baja WHERE curp = '$curp'");

	foreach($registro as $cert){

	    $curp = $cert['curp'];
	    $nombre = rtrim($cert['nombre']);
	    $cct = rtrim($cert['cct']);
	    $nombre_esc = rtrim($cert['nombre_cct']);
	    $grado = $cert['grado'];
	    $grupo = $cert['grupo'];
	    $nivel = $cert['nivel'];       
	    $motivo = $cert['motivo'];
	    $realiza = $cert['realiza'];
	    $fecha_res = $cert['fecha_res'];
	    $fecha = date("d-m-Y");

	  }

	include('encabezado_baja.php');

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
	$pdf->Cell(49, 7, 'NIVEL:',1 ,1, 'L', 1);
	$pdf->SetXY(59, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(47, 7, 'GRADO:',1 ,1, 'L', 1);
	$pdf->SetXY(106, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(47, 7, 'GRUPO:',1 ,1, 'L', 1);
	$pdf->SetXY(153, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(52, 7, 'FECHA BAJA:',1 ,1, 'L', 1);

	$pdf->SetXY(10, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(49, 7, $nivel,1 ,1, 'C', 0);
	$pdf->SetXY(59, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(47, 7, $grado,1 ,1, 'C', 0);
	$pdf->SetXY(106, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(47, 7, $grupo,1 ,1, 'C', 0);
	$pdf->SetXY(153, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(52, 7, $fecha_res,1 ,1, 'C', 0);

	$pdf->SetXY(10, 94);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(96, 7, 'MOTIVO DE BAJA:',1 ,1, 'L', 1);
	$pdf->SetXY(106, 94);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(99, 7, 'QUIEN SOLICITA LA BAJA:',1 ,1, 'L', 1);

	$pdf->SetXY(10, 101);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(96, 7, $motivo,1 ,1, 'L', 0);
	$pdf->SetXY(106, 101);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(99, 7, $realiza,1 ,1, 'L', 0);

	$pdf->SetXY(10, 115);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->MultiCell(192, 4, utf8_decode('SE GENERA EL PRESENTE DOCUMENTO A SOLICITUD DEL PADRE, MADRE DE FAMILIA O TUTOR, PARA LOS FINES ACADÉMICOS QUE CONSIDERE.'));

	$pdf->SetXY(10, 130);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(96, 7, utf8_decode('FECHA DE IMPRESIÓN: '.$fecha),0 ,1, 'L', );

	$pdf->Output();

	$conexion = null;

?>