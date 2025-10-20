<?php set_time_limit(0);

	//agregamos archivo para conexion a base de datos
	require('conexion.php');
	$idAlumno = base64_decode($_GET["al_id"]);

	$consulta = $conexion->query("SELECT TOP(1) * FROM pp_token ORDER BY id DESC");

	foreach($consulta as $dat){
		$token = $dat['token'];
		$refresh_token = $dat['refresh_token'];
		$fecha_registro = $dat['fecha_registro'];
	}

	if (isset($token)) {

		echo "<script>console.log('Si tengo un token');</script>";
		//echo "<script>console.log('El token es: '+$token);</script>";
		//echo "El token es: ".$token."<br>";

		$fecha_registro = DateTime::createFromFormat('Y-m-d H:i:s', $fecha_registro);

		// Verificamos si el token aun esta vigente
		$fecha = new DateTime();
		// Calcula la diferencia en horas
		$diferencia = $fecha->diff($fecha_registro);
		// Obtiene la diferencia total en horas
		$horas_diferencia = $diferencia->h + ($diferencia->days * 24);

		// Muestra la diferencia en horas
		echo "<script>console.log('Diferencia en horas: '+$horas_diferencia+' horas');</script>";
		if ($horas_diferencia < 22) {

			echo "<script>console.log('El token aun es valido :D');</script>";
			
		}
		elseif ($horas_diferencia >= 22 AND $horas_diferencia < 160) {

			echo "<script>console.log('Ya es hora de renovar el token CON EL TOKEN DE REFRESCO');</script>";
			require('refreshToken_siga.php');

			$token = $accessToken;

		}
		else {

			echo "<script>console.log('El token DE REFRESCO YA NO ES VALIDO, se genera un nuevo token');</script>";
			require('token_siga.php');

			$token = $accessToken;

		}

	}
	else {

		echo "No tengo token, voy a generar uno";
		require('token_siga.php');

		$token = $accessToken;

	}

	// Insertamos info a la bitacora
	$fecha_bit = date("d-m-Y");
	$bitacora = $conexion->query("INSERT INTO bitacora_portal (al_id, al_curp, fecha_imp, lugar) VALUES ('$idAlumno', 'BOLETA2425', '$fecha_bit', 'BOLETA')");

	// Codigo para la generación de la boleta 2024
	require('boleta2025.php');


?>