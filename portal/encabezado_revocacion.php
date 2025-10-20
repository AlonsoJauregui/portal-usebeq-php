<?php 

	require 'fpdf/fpdf.php';

	class PDF extends FPDF {

		function Header() {

			
			$this->SetXY(10, 12);
			$this->SetFont('Arial', '', 9);
			$this->Cell(195, 5, utf8_decode('Dirección General de Acreditación, Incorporación y Revalidación'), 0, 1, 'R');
			

		
		}

		function Footer() {

			/*$this->SetY(-15);
			$this->SetFont('Arial', 'I', 8);
			$this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');*/
		}
	}

?>