<?php

	require("../conexion.php");
	$folio = $_GET['folio'];

	$registro = $conexion->query("SELECT * FROM tramite_revocaciong WHERE folio = '$folio'");

	foreach($registro as $rev){
		$director = $rev['director_nom'];
		$nombre_esc = $rev['esc_nombre'];
		$cct = $rev['cct'];
		$dom_esc = $rev['region'];
		$nombre_alum = $rev['al_nombreComp'];
		$curp = $rev['al_curp'];
		$grado = $rev['al_grado'];
		$ciclo = $rev['ciclo_escolar'];
		$nivel = $rev['nivel'];
		$folio = $rev['folio'];	
		$nombre_padre = $rev['padre_nombre'];
		$tel = $rev['padre_tel'];
		$correo = $rev['padre_correo'];
		$fecha = substr($rev['fecha_solicitud'],0,10);
		
	 

	  }

	

	include('encabezado_revocacion.php');
			$pdf = new PDF();
			$pdf->AddPage();

			$pdf->SetXY(10, 28);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', 'B', 12);
			$pdf->Cell(0, 13, utf8_decode("Anexo 8. Autorización Expresa de la madre, el padre de familia o tutor para revocar la"), 0, 1, '');
			$pdf->SetXY(10, 33);
			$pdf->Cell(10);
			$pdf->Cell(0, 13, utf8_decode("promoción de cualquier grado de su hijo."), 0, 1, '');
								
			// $pdf->SetXY(10, 50);
			// $pdf->Cell(10);
			$pdf->SetFillColor(255, 255, 255);
			// $pdf->SetFont('ARIAL', '', 10);	
			// $pdf->Cell(45, 6, 'DIRECTOR DEL PLANTEL: ',0 ,0, 'L', 1);
			// $pdf->SetFont('ARIAL', '', 9);
			// $pdf->Cell(110, 6, utf8_decode($director),0 ,1, 'L', 1);

			$pdf->SetXY(10, 50);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', 'B', 10);	
			$pdf->Cell(19, 6, 'ESCUELA: ',0 ,0, 'L', 1);
			$pdf->SetFont('ARIAL', '', 9);
			$pdf->Cell(55, 6, utf8_decode($nombre_esc),0 ,0, 'L', 1);			

			$pdf->SetXY(10, 57);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', 'B', 10);	
			$pdf->Cell(22, 6, 'CLAVE CCT: ',0 ,0, 'L', 1);
			$pdf->SetFont('ARIAL', '', 9);
			$pdf->Cell(40, 6, $cct,0 ,0, 'L', 1);

			$pdf->SetXY(10, 64);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', 'B', 10);	
			$pdf->Cell(17, 6, utf8_decode('REGIÓN:'),0 ,0, 'L', 1);
			$pdf->SetFont('ARIAL', '', 9);
			$pdf->Cell(20, 6, utf8_decode($dom_esc),0 ,0, 'L', 1);
			
			$pdf->SetXY(10, 71);
			$pdf->Cell(10);
			$pdf->SetFont('Arial', 'b', 10);
			$pdf->Cell(15, 6, 'FECHA:',0 ,0, 'L', 1);
			$pdf->SetFont('Arial', '', 9);
			$pdf->Cell(35, 6, $fecha,0 ,0, 'L', 1);

			$pdf->SetXY(10, 78);
			$pdf->Cell(10);
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(15, 6, 'FOLIO:',0 ,0, 'L', 1);
			$pdf->SetFont('Arial', 'U', 10);
			$pdf->Cell(20, 6, $folio,0 ,0, 'L', 1);			

			$pdf->SetXY(10, 95);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', 'B', 10);	
			$pdf->Cell(25, 6, utf8_decode('P R E S E N T E :'),0 ,0, 'L', 1);
			
			$pdf->SetXY(10, 103);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', '', 10);
			$pdf->MultiCell(0, 5, utf8_decode("Por este conducto, como padre, madre de familia o tutor del alumno ".$nombre_alum . " con CURP ". $curp . " quien cursó el " . $grado . 
											" grado en el plantel arriba citado durante el Ciclo Escolar ".$ciclo.", me permitió otorgar mi consentimiento para que mi hijo sea reinscrito en "
											 . $grado . " grado de EDUCACIÓN " . $nivel . "."), 0, 1, '');
		
			
			$pdf->SetXY(10, 125);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', '', 10);
			$pdf->MultiCell(0, 5, utf8_decode("Por lo anterior, manifiesto que conozco, las consecuencias pedagógicas, psicológicas y jurídicas de la decisión anteriormente expresada."), 0, 1, '');
			
			$pdf->SetXY(10, 140);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', '', 10);
			$pdf->MultiCell(0, 5, utf8_decode("Asimismo, estoy enterado, que en caso de un traslado posterior de escuela, la ubicación de mi menor hijo o pupilo, será de acuerdo al grado cursado y no de acuerdo a su edad, lo anterior como consecuencia de la solicitud de Revocación de Grado."), 0, 1, '');
			
			$pdf->SetXY(10, 164);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', 'B', 10);
			$pdf->Cell(0, 13, utf8_decode("Atentamente"), 0, 1, '');

			$pdf->SetXY(10, 176);
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(70, 6, 'Nombre del padre, madre de familia o tutor: ',0 ,0, 'L', 1);
			$pdf->SetFont('Arial', '', 9);
			$pdf->Cell(0, 6, $nombre_padre,0 ,0, 'L', 1);

			// $pdf->SetXY(10, 169);
			// $pdf->Cell(10);
			// $pdf->SetFont('ARIAL', '', 10);	
			// $pdf->Cell(20, 6, utf8_decode('Domicilio:'),0 ,0, 'L', 1);
			// $pdf->SetFont('ARIAL', '', 9);
			// $pdf->Cell(50, 6, utf8_decode($dom_padre),0 ,0, 'L', 1);

			$pdf->SetXY(10, 181);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', '', 10);	
			$pdf->Cell(32, 6, utf8_decode('Correo electrónico:'),0 ,0, 'L', 1);
			$pdf->SetFont('ARIAL', '', 9);
			$pdf->Cell(80, 6, utf8_decode($correo),0 ,0, 'L', 1);

			$pdf->SetXY(10, 186);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', '', 10);	
			$pdf->Cell(16, 6, utf8_decode('Teléfono:'),0 ,0, 'L', 1);
			$pdf->SetFont('ARIAL', '', 9);
			$pdf->Cell(18, 6, $tel,0 ,0, 'L', 1);
			
			$pdf->SetXY(10, 200);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', '', 8);	
			$pdf->Cell(20, 4, utf8_decode('c.c.p. Responsable del Área de Control Escolar'),0 ,0, 'L', 1);
			$pdf->SetXY(10, 204);
			$pdf->Cell(10);
			$pdf->SetFont('ARIAL', '', 8);	
			$pdf->Cell(20, 4, utf8_decode('Madre, Padre de familia o tutor'),0 ,0, 'L', 1);

			$pdf->Output();

			$conexion = null;

?>