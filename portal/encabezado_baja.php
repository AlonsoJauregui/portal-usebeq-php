<?php 

	require 'fpdf/fpdf.php';

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
			$this->Cell(195, 7, 'REPORTE DE BAJA REALIZADA', 0, 0, 'C');
			$this->Image('img/Queretaro.png', 180, 10, 25);

			$this->Ln(15);
		}

		function Footer() {

			/*$this->SetY(-15);
			$this->SetFont('Arial', 'I', 8);
			$this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');*/
		}
	}

?>