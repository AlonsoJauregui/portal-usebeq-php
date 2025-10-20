<?php

	require("../conexion.php");

	require 'fpdf/fpdf.php';

	$curp = trim(strtoupper($_POST['curp']));
	$nombre = mb_strtoupper($_POST['nombre']);
	$cct = strtoupper($_POST['cct']);
	$nombre_esc =  mb_strtoupper($_POST['nombre_esc']);
	$grado = $_POST['grado'];
	$grupo = strtoupper($_POST['grupo']);
	$dom_esc =  mb_strtoupper($_POST['dom_esc']);
	$nivel = $_POST['nivel'];
	$motivo = $_POST['motivo'];
	$realiza = $_POST['realiza'];
	$fecha = $_POST["fecha"];
	
	if ($nivel == 'PRE'){
		$nivel = 'PREESCOLAR';
	}elseif ($nivel == 'PRI'){
		$nivel = 'PRIMARIA';
	}elseif ($nivel = 'SEC') {
		$nivel = 'SECUNDARIA';
	}
	class PDF extends FPDF {

		function Header() {

			$this->Image('img/USEBEQ.png', 10, 10, 25);
			$this->SetXY(10, 12);
			$this->SetFont('Arial', 'B', 9);
			$this->Cell(195, 5, utf8_decode('UNIDAD DE SERVICIOS PARA LA EDUCACIÓN BÁSICA EN EL ESTADO DE QUERÉTARO'), 0, 1, 'C');
			$this->SetXY(10, 17);
			$this->SetFont('Arial', '', 11);
			$this->Cell(195, 5, utf8_decode('PORTAL PARA PADRES DE FAMILIA'), 0, 1, 'C');
			$this->SetXY(10, 25);
			$this->SetFont('Arial', 'B', 15);
			$this->Cell(195, 7, 'SOLICITUD DE BAJA', 0, 0, 'C');
			$this->Image('img/Queretaro.png', 180, 10, 25);

			$this->Ln(15);
		}

	}

	$pdf = new PDF('P','mm','Letter');
	$pdf->AddPage();

	$pdf->SetXY(95, 40);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(58, 7, 'CURP DEL ALUMNO: ',0 ,1, 'R', 0);
	$pdf->SetXY(153, 40);
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(52, 7, $curp,0 ,1, 'L', 0);

	$pdf->SetXY(95, 47);
	$pdf->SetFont('Arial', 'B', 11);
	$pdf->Cell(58, 7, 'FECHA SOLICITUD: ',0 ,1, 'R', 0);
	$pdf->SetXY(153, 47);
	$pdf->SetFont('Arial', '', 11);
	$pdf->Cell(52, 7, $fecha,0 ,1, 'L', 0);	

	$pdf->SetXY(10, 65);
	$pdf->SetFont('Arial', '', 12);
	$pdf->MultiCell(192, 5, utf8_decode('Yo '.$realiza.' del menor: '.$nombre.', que está inscrito en el  grado '.$grado.', grupo '.$grupo.', de la escuela '.$nombre_esc.' con clave '.$cct.', del nivel '.$nivel.', ubicada en el domicilio '.$dom_esc.', solicito su intervención para gestionar la baja en el Sistema en Línea de Control Escolar del Estado de Querétaro (SILCEQ).'));

	$pdf->SetXY(10, 94);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->SetFillColor(225,225,225);
	$pdf->Cell(96, 7, 'MOTIVO DE BAJA:',0 ,1, 'L', 0);

	$pdf->SetXY(10, 99);
	$pdf->SetFont('Arial', '', 12);
	$pdf->Cell(96, 7, $motivo,0 ,1, 'L', 0);

	$pdf->SetXY(10, 115);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->MultiCell(192, 4, utf8_decode('SE GENERA EL PRESENTE DOCUMENTO A SOLICITUD DEL PADRE, MADRE DE FAMILIA O TUTOR, PODRA CONSULTAR LA RESOLUCIÓN DEL TRÁMITE A TRÁVES DE LA OPCIÓN "ESTATUS DE SOLICITUD" DENTRO DEL MENÚ DE SOLICITUD DE BAJA EN LINEA.'));

	$pdf->Output();

	$conexion = null;

?>