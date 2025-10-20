<?php

	require("../conexion.php");

	$curp = $_POST['curp'];

	$registro = $conexion->query("SELECT sce004.al_id,sce004.al_curp,sce004.al_nombre,sce004.al_appat,sce004.al_apmat,sce004.al_estatus,sce002.eg_grado,sce002.eg_grupo,sce002.clavecct,sce002.nombrect, sce002.ce_inicic, sce002.ce_fincic, sce002.nivel
    FROM SCE004 INNER JOIN SCE006 ON SCE004.al_id = SCE006.al_id
    INNER JOIN SCE002 ON SCE002.eg_id = SCE006.eg_id
    WHERE sce004.al_curp = '$curp'");

	foreach($registro as $cert){

	    $curp = $cert['al_curp'];
	    $nombre = rtrim($cert['al_nombre'])." ". rtrim($cert['al_appat']) . " " . rtrim($cert['al_apmat']) ;
		
	    $cct = rtrim($cert['clavecct']);
	    $nombre_esc = rtrim($cert['nombrect']);
		$nivel = $cert['nivel'];
	    $grado = $cert['eg_grado'];
	    $grupo = $cert['eg_grupo'];
	   	$ciclo = $cert['ce_inicic']."-". $cert['ce_fincic'];
	    //$fecha_res = $cert['fecha_res'];
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
	$pdf->Cell(30, 7, 'NIVEL:',1 ,1, 'L', 1);
	$pdf->SetXY(40, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(37.6, 7, 'GRADO:',1 ,1, 'L', 1);
	$pdf->SetXY(77.6, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(37.6, 7, 'GRUPO:',1 ,1, 'L', 1);
	$pdf->SetXY(115.3, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(37.7, 7, 'CICLO:',1 ,1, 'L', 1);
	$pdf->SetXY(153, 74);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(52, 7, utf8_decode('FECHA DE IMPRESIÓN:'),1 ,1, 'L', 1);

	$pdf->SetXY(10, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(30, 7, $nivel,1 ,1, 'C', 0);
	$pdf->SetXY(40, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(37.6, 7, $grado,1 ,1, 'C', 0);
	$pdf->SetXY(77.6, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(37.6, 7, $grupo,1 ,1, 'C', 0);
	$pdf->SetXY(115.3, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(37.7, 7, $ciclo,1 ,1, 'C', 0);
	$pdf->SetXY(153, 81);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(52, 7, $fecha,1 ,1, 'C', 0);

	// $pdf->SetXY(10, 94);
	// $pdf->SetFont('Arial', 'B', 10);
	// $pdf->SetFillColor(225,225,225);
	// $pdf->Cell(96, 7, 'MOTIVO DE BAJA:',1 ,1, 'L', 1);
	// $pdf->SetXY(106, 94);
	// $pdf->SetFont('Arial', 'B', 10);
	// $pdf->SetFillColor(225,225,225);
	// $pdf->Cell(99, 7, 'QUIEN SOLICITA LA BAJA:',1 ,1, 'L', 1);

	// $pdf->SetXY(10, 101);
	// $pdf->SetFont('Arial', '', 10);
	// $pdf->Cell(96, 7, $motivo,1 ,1, 'L', 0);
	// $pdf->SetXY(106, 101);
	// $pdf->SetFont('Arial', '', 10);
	// $pdf->Cell(99, 7, $realiza,1 ,1, 'L', 0);

	$pdf->SetXY(10, 95);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->MultiCell(192, 4, utf8_decode('SE GENERA EL PRESENTE DOCUMENTO A SOLICITUD DEL PADRE, MADRE DE FAMILIA O TUTOR, PARA LOS FINES ACADÉMICOS QUE CONSIDERE.'));

	// $pdf->SetXY(10, 115);
	// $pdf->SetFont('Arial', 'B', 9);
	// $pdf->Cell(96, 7, utf8_decode('FECHA DE IMPRESIÓN: '.$fecha),0 ,1, 'L', );

	$pdf->Output();

	$conexion = null;

?>