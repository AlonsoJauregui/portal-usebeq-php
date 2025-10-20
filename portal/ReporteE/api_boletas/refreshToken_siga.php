<?php
	$api_url = 'https://siga-usebeq-api.azurewebsites.net/api/authentication/get-refresh-tokens';

	// Datos que quieres enviar
	$post_data = array(
	    'accessToken' => $token,
	    'refreshToken' => $refresh_token,
	    // Agrega más campos según sea necesario
	);

	// Convertir datos a formato JSON
	$json_data = json_encode($post_data);

	// Inicializar cURL
	$ch = curl_init($api_url);

	// Configurar opciones de cURL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($json_data)
	));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignorar la verificación del certificado SSL

	// Ejecutar la solicitud cURL y obtener la respuesta
	$response = curl_exec($ch);

	// Verificar si hubo errores en la solicitud
	if (curl_errno($ch)) {
	    echo 'Error en la solicitud cURL: ' . curl_error($ch);
	} else {

		// Cerrar la sesión cURL
		curl_close($ch);

	    // Hacer algo con la respuesta
	    //var_dump($response);

	    $siga_data = json_decode($response, true);
	    $accessToken = $siga_data['accessToken'];
	    $refreshToken = $siga_data['refreshToken'];

	    // Obtén la fecha y hora actual
		$fecha = new DateTime();
		$fecha = $fecha->format('Y-m-d H:i:s');

		//echo "token: ".$accessToken."<br>";
		//echo "refreshToken: ".$refreshToken."<br>";

		$ingresa_datos = $conexion->query("INSERT INTO pp_token (token, refresh_token, fecha_registro) VALUES ('$accessToken', '$refreshToken', '$fecha')");

	}

?>


