<?php

	// Configurar cabeceras con codificación
	header('Content-Type: application/json; charset=utf-8');

	// conexion a la base de datos
	include("conexion.php");

	// Obtener parámetros de la URL
	$tipo_documento = $_GET['tipo_documento'] ?? '';
	$ciclo = $_GET['ciclo'] ?? '';
	$folio = $_GET['folio'] ?? '';

	// Validar parámetros recibidos
	if (empty($tipo_documento) || empty($ciclo) || empty($folio)) {
	    http_response_code(400);
	    die(json_encode(array("error" => "Parámetros incompletos")));
	}

	// Configurar modo de errores
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if ($tipo_documento == 'CERTIFICACION') {
		
		// Para du´plicados electronicos a partir de la creación del SISCER (2017-2018)
		// Consulta SQL con parámetros
		$sql = "SELECT al_curp, al_appat, al_apmat, al_nombre, clavecct, nombrect, turno, foliosep FROM SCE039_DUPLI WHERE ce_fincic = :ciclo AND foliosep = :folio";

		// Preparar y ejecutar consulta
	    $stmt = $conexion->prepare($sql);
	    $stmt->execute([
	        ':ciclo' => $ciclo,
	        ':folio' => $folio
	    ]);

	    // Obtener resultados
    	$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    	if ($resultado) {
	        $resultado['nombrect'] = rtrim($resultado['nombrect']);

    		$resultado['responsable_firma'] = 'CARLOS SAMUEL LEAL GUERRERO';
    		$resultado['no_certificado_autoridad'] = '00001000000508866503';
	    }

	}
	elseif ($tipo_documento == 'CERTIFICADO') {

		// Para certificados emitidos a partir del ciclo 2016-2017
		$year = date("Y");

		// Verificamos que entre dentro de los ciclos que se han certificado
		if ($ciclo >= 2017 AND $ciclo <= $year) {
			
			// Operaciones para obtener la tabla del ciclo que corresponde en el duplicado
			$cic_div = substr($ciclo, 2, 2);
			$cic_ant = $cic_div-1;
			$cic = "SCE039_".$cic_ant.$cic_div;

			$sql = "SELECT al_curp, al_appat, al_apmat, al_nombre, clavecct, nombrect, turno, foliosep FROM ".$cic." WHERE foliosep = :folio";

		    // Preparar y ejecutar consulta
		    $stmt = $conexion->prepare($sql);
		    $stmt->execute([
		        ':folio' => $folio
		    ]);

		    // Obtener resultados
	    	$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

	    	if ($resultado) {
		        $resultado['nombrect'] = rtrim($resultado['nombrect']);

	    		$resultado['responsable_firma'] = 'CARLOS SAMUEL LEAL GUERRERO';
	    		$resultado['no_certificado_autoridad'] = '00001000000508866503';
		    }

		}
		else {

			http_response_code(400);
	    	die(json_encode(array("error" => "El año no es valido dentro de los periodos establecidos.")));

		}

	}
	elseif ($tipo_documento == 'BOLETA') {
		
		// Para boletas del ciclo 19-20 en adelante
		$year = date("Y");

		// Verificamos que entre dentro de los ciclos que se han certificado
		if ($ciclo >= 2020 AND $ciclo <= $year) {

			// Operaciones para obtener si es un id de 6 o 7 digitos
			$folio_div = substr($folio, 6, 1);

			if ($folio_div == 0) {
				
				$folio_id = substr($folio, 7, 6);

			}
			else {

				$folio_id = substr($folio, 6, 7);

			}

			$sql = "SELECT TOP 1 dbo.SCE004.al_curp AS curp, dbo.SCE004.al_appat AS primer_apellido, dbo.SCE004.al_apmat AS segundo_apellido, dbo.SCE004.al_nombre AS nombre, dbo.SCE005.eg_grado AS grado_escolar, dbo.SCE005.clavecct3 AS clave_escuela, dbo.SCE005.turno3 AS turno FROM dbo.SCE004 INNER JOIN dbo.SCE005 ON dbo.SCE004.al_id = dbo.SCE005.al_id WHERE (dbo.SCE004.al_id = :id) AND (dbo.SCE005.ce_fincic = :ciclo)";

		    // Preparar y ejecutar consulta
		    $stmt = $conexion->prepare($sql);
		    $stmt->execute([
		        ':id' => $folio_id,
		        ':ciclo' => $ciclo
		    ]);

		    // Obtener resultados
	    	$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

	    	if ($resultado['clave_escuela'] == NULL) {
	    		$resultado['clave_escuela'] = "Ciclo escolar no concluido";
	    	}

	    	if ($resultado) {
	    		$resultado['responsable_firma'] = 'CARLOS SAMUEL LEAL GUERRERO';
	    		$resultado['no_certificado_autoridad'] = '00001000000508866503';
		    }

		}
		else {

			http_response_code(400);
	    	die(json_encode(array("error" => "El año no es valido dentro de los periodos establecidos.")));

		}

	}
	else {

		http_response_code(400);
	    die(json_encode(array("error" => "Tipo de documento erroneo")));

	}

	if ($stmt === false) {
	    http_response_code(500);
	    die(json_encode(array("error" => "Error en consulta: " . sqlsrv_errors())));
	}

	if ($resultado) {
        echo json_encode($resultado);
    } else {
        http_response_code(404);
        echo json_encode(['mensaje' => 'Documento no encontrado']);
    }

	// Liberar recursos
	$conexion = null;

?>