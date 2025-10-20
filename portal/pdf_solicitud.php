<?php 

	require 'fpdf/fpdf.php';

	class PDF extends FPDF {

		function Header() {

			$this->Image('img/USEBEQ.png', 10, 10, 25);
			$this->Cell(35);
			$this->SetFont('Arial', 'B', 9);
			$this->Cell(120, 11, utf8_decode('UNIDAD DE SERVICIOS PARA LA EDUCACIÓN BÁSICA EN EL ESTADO DE QUERÉTARO'), 0, 1, 'C');
			$this->Cell(35);
			$this->SetFont('Arial', 'B', 15);
			$this->Cell(120, 5, 'SOLICITUD DE DOCUMENTOS', 0, 0, 'C');
			$this->Image('img/Queretaro.png', 172, 10, 25);

			$this->Ln(15);
		}

		function Footer() {

			/*$this->SetY(-15);
			$this->SetFont('Arial', 'I', 8);
			$this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');*/
		}
	}

?>