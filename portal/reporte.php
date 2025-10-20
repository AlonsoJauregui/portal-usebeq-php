<?php

	require("../Conexion.php");

	if (isset($_POST['curp'])) {
		
		$al_curp = ($_POST['curp']);

		$consulta = $conexion->query("SELECT * FROM Historica_VH WHERE al_curp = '$al_curp'");

		foreach($consulta as $datos){
			$id = $datos['al_id'];
			$al_curp_h = $datos['al_curp_h'];
			$sis_estatus = $datos['sis_estatus'];
			$fecha_solicitud = $datos['fecha_solicitud'];
			$parentesco = $datos['parentesco'];
			$al_curp_t = $datos['al_curp_t'];
			$al_id_h = $datos['al_id_h'];
			$al_id_t = $datos['al_id_t'];
		}

		$fecha_solicitud = date("d-m-Y", strtotime($fecha_solicitud));

		if ($sis_estatus == "APROBADA") {
			
			// impresion del reporte para hermanos consanguineos
			if ($parentesco == "CONSANGUINEOS1" || $parentesco == "CONSANGUINEOS2" || $parentesco == "AFINIDAD") 
			{

				$nombre_asp = $conexion->query("SELECT al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_id = '$id'");
				foreach ($nombre_asp as $dato_asp) {
					$nombre_asp = $dato_asp['al_nombre']." ".$dato_asp['al_appat']." ".$dato_asp['al_apmat'];
				}

				$nombre_her = $conexion->query("SELECT al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_id = '$al_id_h'");
				foreach ($nombre_her as $dato_her) {
					$nombre_her = $dato_her['al_nombre']." ".$dato_her['al_appat']." ".$dato_her['al_apmat'];
				}
				
				$fecha = date("d-m-Y");
				include('encabezado.php');

				$pdf = new PDF('P','mm','Letter');
				$pdf->AddPage();

				$pdf->SetXY(10, 40);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, 'NOMBRE DEL ASPIRANTE:',1 ,1, 'L', 1);
				$pdf->SetXY(120, 40);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 47);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, utf8_decode($nombre_asp),1 ,1, 'L', 0);
				$pdf->SetXY(120, 47);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $al_curp,1 ,1, 'L', 0);

				$pdf->SetXY(10, 60);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(195, 7, 'DATOS DEL HERMANA (O) VINCULADA (O):',1 ,1, 'C', 1);
				$pdf->SetXY(10, 67);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, 'NOMBRE:',1 ,1, 'L', 1);
				$pdf->SetXY(120, 67);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 74);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, utf8_decode($nombre_her),1 ,1, 'L', 0);
				$pdf->SetXY(120, 74);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $al_curp_h,1 ,1, 'L', 0);

				$pdf->SetXY(10, 81);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, utf8_decode('FECHA DE VINCULACIÓN:'),1 ,1, 'L', 1);
				$pdf->SetXY(120, 81);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'ID:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 88);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, $fecha_solicitud,1 ,1, 'L', 0);
				$pdf->SetXY(120, 88);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $id.$al_curp,1 ,1, 'L', 0);

				$pdf->SetXY(10, 114);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Multicell(0, 6, utf8_decode('NOTA: Posterior a la "Vinculación Parental" debes validar tu lugar del 4 - 14 de Febrero de 2025 en la página www.usebeq.edu.mx/said, es indispensable para asegurar tu lugar.') );
				

				$pdf->SetXY(10, 130);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(96, 5, utf8_decode('FECHA DE IMPRESIÓN: '.$fecha),0 ,1, 'L', );

				$pdf->Output();

				$conexion = null;

			}
			// impresion del reporte para hermanos gemelos
			elseif ($parentesco == "gemelos" || $parentesco == "GEMELOS") {

				$nombre_asp = $conexion->query("SELECT al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_id = '$id'");
				foreach ($nombre_asp as $dato_asp) {
					$nombre_asp = $dato_asp['al_nombre']." ".$dato_asp['al_appat']." ".$dato_asp['al_apmat'];
				}

				$nombre_her = $conexion->query("SELECT al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_id = '$al_id_h'");
				foreach ($nombre_her as $dato_her) {
					$nombre_her = $dato_her['al_nombre']." ".$dato_her['al_appat']." ".$dato_her['al_apmat'];
				}
				
				$fecha = date("d-m-Y");
				include('encabezado.php');

				$pdf = new PDF('L','mm',array(215,160));
				$pdf->AddPage();

				$pdf->SetFillColor(225,225,225);
				$pdf->SetXY(10, 40);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(195, 7, 'DATOS DEL HERMANA (O) GEMELA (O) VINCULADA (O):',1 ,1, 'C', 1);

				$pdf->SetXY(10, 47);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, 'NOMBRE:',1 ,1, 'L', 1);
				$pdf->SetXY(120, 47);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 54);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, utf8_decode($nombre_asp),1 ,1, 'L', 0);
				$pdf->SetXY(120, 54);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $al_curp,1 ,1, 'L', 0);

				$pdf->SetXY(10, 61);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, 'NOMBRE:',1 ,1, 'L', 1);
				$pdf->SetXY(120, 61);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 68);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, $nombre_her,1 ,1, 'L', 0);
				$pdf->SetXY(120, 68);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $al_curp_h,1 ,1, 'L', 0);

				$pdf->SetXY(10, 81);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, utf8_decode('FECHA DE VINCULACIÓN:'),1 ,1, 'L', 1);
				$pdf->SetXY(120, 81);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'ID:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 88);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, $fecha_solicitud,1 ,1, 'L', 0);
				$pdf->SetXY(120, 88);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $id.$al_curp,1 ,1, 'L', 0);

				$pdf->SetXY(10, 114);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Multicell(0, 6, utf8_decode('NOTA: Posterior a la "Vinculación Parental" debes validar tu lugar del 4-14 de Febrero de 2025, es indispensable para asegurar tu lugar.') );
				

				$pdf->SetXY(10, 130);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(96, 5, utf8_decode('FECHA DE IMPRESIÓN: '.$fecha),0 ,1, 'L', );
				$pdf->Output();

				$conexion = null;

			}
			// impresion del reporte para hermanos gemelos
			elseif ($parentesco == "trillizos" || $parentesco == "TRILLIZOS") {

				$nombre_asp = $conexion->query("SELECT al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_id = '$id'");
				foreach ($nombre_asp as $dato_asp) {
					$nombre_asp = $dato_asp['al_nombre']." ".$dato_asp['al_appat']." ".$dato_asp['al_apmat'];
				}

				$nombre_her = $conexion->query("SELECT al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_id = '$al_id_h'");
				foreach ($nombre_her as $dato_her) {
					$nombre_her = $dato_her['al_nombre']." ".$dato_her['al_appat']." ".$dato_her['al_apmat'];
				}

				$nombre_her_t = $conexion->query("SELECT al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_id = '$al_id_t'");
				foreach ($nombre_her_t as $dato_her_t) {
					$nombre_her_t = $dato_her_t['al_nombre']." ".$dato_her_t['al_appat']." ".$dato_her_t['al_apmat'];
				}
				
				$fecha = date("d-m-Y");
				include('encabezado.php');

				$pdf = new PDF('L','mm',array(215,140));
				$pdf->AddPage();

				$pdf->SetFillColor(225,225,225);
				$pdf->SetXY(10, 40);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(195, 7, 'DATOS DE LAS (OS) HERMANAS (OS) TRILLIZAS (OS) VINCULADAS (OS):',1 ,1, 'C', 1);

				$pdf->SetXY(10, 47);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, 'NOMBRE:',1 ,1, 'L', 1);
				$pdf->SetXY(120, 47);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 54);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, $nombre_asp,1 ,1, 'L', 0);
				$pdf->SetXY(120, 54);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $al_curp,1 ,1, 'L', 0);

				$pdf->SetXY(10, 61);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, 'NOMBRE:',1 ,1, 'L', 1);
				$pdf->SetXY(120, 61);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 68);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, $nombre_her,1 ,1, 'L', 0);
				$pdf->SetXY(120, 68);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $al_curp_h,1 ,1, 'L', 0);

				$pdf->SetXY(10, 75);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, 'NOMBRE:',1 ,1, 'L', 1);
				$pdf->SetXY(120, 75);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 82);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, $nombre_her_t,1 ,1, 'L', 0);
				$pdf->SetXY(120, 82);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $al_curp_t,1 ,1, 'L', 0);

				$pdf->SetXY(10, 95);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, utf8_decode('FECHA DE VINCULACIÓN:'),1 ,1, 'L', 1);
				$pdf->SetXY(120, 95);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'ID:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 102);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, $fecha_solicitud,1 ,1, 'L', 0);
				$pdf->SetXY(120, 102);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $id.$al_curp,1 ,1, 'L', 0);

				$pdf->SetXY(10, 114);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Multicell(0, 6, utf8_decode('NOTA: Posterior a la "Vinculación Parental" debes validar tu lugar del 4-14 de Febrero de 2025, es indispensable para asegurar tu lugar.') );
				

				$pdf->SetXY(10, 130);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(96, 5, utf8_decode('FECHA DE IMPRESIÓN: '.$fecha),0 ,1, 'L', );
				$pdf->Output();

				$conexion = null;

			}elseif ($parentesco == "CONSANGUINEOSM" || $parentesco == "AFINIDADM") 
			{

				$nombre_asp = $conexion->query("SELECT al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_id = '$id'");
				foreach ($nombre_asp as $dato_asp) {
					$nombre_asp = $dato_asp['al_nombre']." ".$dato_asp['al_appat']." ".$dato_asp['al_apmat'];
				}

				$nombre_her = $conexion->query("SELECT al_nombre, al_appat, al_apmat FROM SCE004 WHERE al_id = '$al_id_h'");
				foreach ($nombre_her as $dato_her) {
					$nombre_her = $dato_her['al_nombre']." ".$dato_her['al_appat']." ".$dato_her['al_apmat'];
				}
				
				$fecha = date("d-m-Y");
				include('encabezado.php');

				$pdf = new PDF('P','mm','Letter');
				$pdf->AddPage();

				$pdf->SetXY(10, 40);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, 'NOMBRE DEL ASPIRANTE:',1 ,1, 'L', 1);
				$pdf->SetXY(120, 40);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 47);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, utf8_decode($nombre_asp),1 ,1, 'L', 0);
				$pdf->SetXY(120, 47);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $al_curp,1 ,1, 'L', 0);

				$pdf->SetXY(10, 60);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(195, 7, 'DATOS MAESTRA (O) VINCULADA (O):',1 ,1, 'C', 1);
				$pdf->SetXY(10, 67);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, 'NOMBRE:',1 ,1, 'L', 1);
				$pdf->SetXY(120, 67);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'CURP:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 74);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, utf8_decode($nombre_her),1 ,1, 'L', 0);
				$pdf->SetXY(120, 74);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $al_curp_h,1 ,1, 'L', 0);

				$pdf->SetXY(10, 81);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(110, 7, utf8_decode('FECHA DE VINCULACIÓN:'),1 ,1, 'L', 1);
				$pdf->SetXY(120, 81);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell(85, 7, 'ID:',1 ,1, 'L', 1);

				$pdf->SetXY(10, 88);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(110, 7, $fecha_solicitud,1 ,1, 'L', 0);
				$pdf->SetXY(120, 88);
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(85, 7, $id.$al_curp,1 ,1, 'L', 0);

				$pdf->SetXY(10, 114);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Multicell(0, 6, utf8_decode('NOTA: Posterior a la "Vinculación Parental" debes validar tu lugar del 4 - 14 de Febrero de 2025 en la página www.usebeq.edu.mx/said, es indispensable para asegurar tu lugar.') );
				

				$pdf->SetXY(10, 130);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(96, 5, utf8_decode('FECHA DE IMPRESIÓN: '.$fecha),0 ,1, 'L', );

				$pdf->Output();

				$conexion = null;

			}

		}
		else {
			echo "No se puede visualizar el reporte de vinculación, favor de intentar mas tarde.";
		}

	}
	else {
		echo "No se proporciono ningun identificador del trámite.";
	}

?>