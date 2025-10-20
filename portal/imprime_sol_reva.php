<?php

	require("../conexion.php");

	require 'fpdf/fpdf.php';

	$nombre = utf8_decode($_POST['nombre']);
	$apaterno = utf8_decode($_POST['apaterno']);
	$amaterno = utf8_decode($_POST['amaterno']);
	$sexo = $_POST['sexo'];
	$nivel =  $_POST['nivel'];
	$folio = $_POST['folio'];
	$fecha = $_POST["fecha"];

	class PDF extends FPDF {

		function Header() {

			$this->Image('img/reva.jpg', 0, 0, 217);
			$this->Ln(15);
		}

	}

	$pdf = new PDF('P','mm','Letter');
	$pdf->AddPage();

	$pdf->SetXY(46.5, 51);
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(7, 7, 'X',0 ,1, 'R', 0);

	$pdf->SetXY(115, 45);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->Cell(58, 7, 'FOLIO: ',0 ,1, 'R', 0);
	$pdf->SetXY(175, 45);
	$pdf->SetFont('Arial', '', 11);
	$pdf->Cell(52, 7, $folio,0 ,1, 'L', 0);

	$pdf->SetXY(115, 51);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->Cell(58, 7, 'FECHA SOLICITUD: ',0 ,1, 'R', 0);
	$pdf->SetXY(175, 51);
	$pdf->SetFont('Arial', '', 11);
	$pdf->Cell(52, 7, $fecha,0 ,1, 'L', 0);	

	$pdf->SetXY(37, 66);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(96, 7, $apaterno."         ".$amaterno."         ".$nombre,0 ,1, 'L', 0);

	if ($sexo == 'M') {
		$pdf->SetXY(185, 64);
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(7, 7, 'X',0 ,1, 'L', 0);
	}
	else {
		$pdf->SetXY(190.5, 64);
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(7, 7, 'X',0 ,1, 'L', 0);
	}

	if ($nivel == 'PRI') {
		$pdf->SetXY(32.5, 85.5);
		$pdf->SetFont('Arial', '', 12);
		$pdf->SetFillColor(225,225,225);
		$pdf->Cell(7, 7, 'X',0 ,1, 'R', 0);
	}
	else {
		$pdf->SetXY(76, 85.5);
		$pdf->SetFont('Arial', '', 12);
		$pdf->SetFillColor(225,225,225);
		$pdf->Cell(7, 7, 'X',0 ,1, 'R', 0);
	}

	/*$pdf->SetXY(10, 115);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->MultiCell(192, 4, utf8_decode('SE GENERA EL PRESENTE DOCUMENTO A SOLICITUD DEL PADRE, MADRE DE FAMILIA O TUTOR, PODRA CONSULTAR LA RESOLUCIÓN DEL TRÁMITE A TRÁVES DE LA OPCIÓN "ESTATUS DE SOLICITUD" DENTRO DEL MENÚ DE SOLICITUD DE BAJA EN LINEA.'));*/

	$pdf->Output();

	$conexion = null;

?>