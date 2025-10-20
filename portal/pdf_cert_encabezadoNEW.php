<?php 

	require 'fpdf/fpdf.php';

	class PDF extends FPDF {

		function Header() {

			$this->Image('img/nacional19.png','10','31','175','175','PNG');

			$this->Image('img/SEP19.png', '95', '10', '49', '16', 'PNG');
			$this->Image('img/logo_qro.png', '151', '10', '32', '17', 'PNG');
		/*	$this->Cell(35);
			$this->SetFont('Arial', 'B', 9);
			$this->Cell(120, 11, utf8_decode('UNIDAD DE SERVICIOS PARA LA EDUCACIÓN BÁSICA EN EL ESTADO DE QUERÉTARO'), 0, 1, 'C');
			$this->Cell(35);
			$this->SetFont('Arial', 'B', 15);
			$this->Cell(120, 5, 'SOLICITUD DE DOCUMENTOS', 0, 0, 'C');*/
			

			/*$this->Ln(15);*/
		}
	}

?>