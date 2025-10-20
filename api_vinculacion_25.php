<?php
	set_time_limit(0);
	ini_set('memory_limit', '-1');	
	header('Content-Type: application/json; charset=utf-8');
	header('Content-Transfer-Encoding: binary');
	header('Content-Description: File Transfer');
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate');

	//agregamos archivo para conexion a base de datos
	require('conexion.php');

	//verificamos que la peticion se realice por metodo POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{

		$valor = json_decode(file_get_contents('php://input'), true);
		
		//se valida que el metodo no venga vacio	
		if (isset($valor['opcion']))
		{

			//asignamos el valor a una variable
			$opcion = $valor['opcion'];
			
			if (isset($valor['curp1']))
			{			

				$curp1 = $valor['curp1'];
				
				if ($opcion == "verificar"){
					$curp2 = "";
					$curp3 = "";
					$tel = "";
					$nombre = "";
				}					
				
				//=================== Consulta de registros existentes Historica =================

				$registros = $conexion->query("SELECT COUNT(*) AS REGISTROS    
				FROM [sce2018].[dbo].[Historica_VH]
				WHERE (AL_CURP = '$curp1' or al_curp_h = '$curp1' or al_curp_t = '$curp1') AND ((year(fecha_Solicitud) >=2024 and month(fecha_solicitud) >= 11) OR (year(fecha_Solicitud) >=2025 AND month(fecha_solicitud) <= 1))");

				foreach ($registros as $fila) {
				$cant_registros = $fila['REGISTROS'];
				}				

				if($opcion == "verificar")
					{
						if ($cant_registros >= 1)
						{
							$datos = $conexion->query("SELECT id_vr, al_curp, al_curp_h, sis_estatus, comentarios,correo, parentesco, al_curp_t, tutor FROM Historica_VH WHERE al_curp = '$curp1' or al_curp_h = '$curp1' or al_curp_t = '$curp1' AND ((year(fecha_Solicitud) >=2024 and month(fecha_solicitud) >= 11) or (year(fecha_Solicitud) >=2025 and month(fecha_solicitud) <= 1))");
							while ($row = $datos->fetch(PDO:: FETCH_ASSOC))
							{
							$id_vr = $row['id_vr'];
							$al_curp = trim($row['al_curp']);
								 
							$al_curp_h = trim($row['al_curp_h']);	
							$al_curp_t = trim($row['al_curp_t']); // CREAR CAMPOS DEL HERMANO 3 EN LA TABLA NUEVA 
							$al_estatus = trim($row['sis_estatus']);
							$comentarios = $row['comentarios'];
							$parentesco = $row['parentesco'];
							$correonom = trim($row['correo']);
							$tutor = trim($row['tutor']);
							}

							// Enviar respuesta aprobatoria
							header("HTTP/1.1 200");
							$al_curp = base64_encode($al_curp);
							$array = array("respuesta" => "APROBADA", "mensaje" => "Ingrese al siguiente enlace para descargar el comprobante de vinculación parental: http://portal.usebeq.edu.mx/portal/formato_vinculacion/reporte.php?curp=$al_curp");
							echo json_encode($array);
							exit();

						}else{
							header("HTTP/1.1 200");
							$array = array("respuesta" => "ERROR", "mensaje" => "No hay registro de una vinculación parental con los datos que proporciona, favor de verificar que la CURP que ingresó sea la correcta, o bien, del 4-14 de febrero consultar la pre asignación debido a que el proceso de vinculación concluyó.");
							echo json_encode($array);
							exit();
						}

					}
					else
					{ 
						header("HTTP/1.1 200");
						$array = array("respuesta" => "ERROR", "mensaje" => "La opción seleccionada es incorrecta.");
						echo json_encode($array);
						exit();
					} 
			}	
			else
			{
			header("HTTP/1.1 200");
			$array = array("respuesta" => "ERROR", "mensaje" => "No se proporcionaron todos los datos solicitados.");
			echo json_encode($array);
			exit();
			}	
		}
		else
		{
			header("HTTP/1.1 200");
			$array = array("respuesta" => "ERROR", "mensaje" => "No se proporcionaron todos los datos solicitados.");
			echo json_encode($array);
			exit();
		}	
	}	
	else 
	{
		header("HTTP/1.1 200");
		// $array = array("respuesta" => "ERROR", "mensaje" => "No se envió información por el método adecuado.");
		$array = array("respuesta" => "ERROR", "mensaje" => "No se envió información por el método adecuado.");
	
		echo json_encode($array);
		exit();
	}

?>

