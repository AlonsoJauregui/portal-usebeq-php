<?php
    $api_url = 'https://sce-usebeq-api.azurewebsites.net/api/boleta/historica/'.$idAlumno."/2024";//produccion
    // LIGA PARA EL CICLO ACTUAL $api_url = 'https://sce-usebeq-api.azurewebsites.net/api/boletas/'.$idAlumno;//produccion
    //$api_url = 'https://sce-usebeq-api-qa.azurewebsites.net/api/boletas/734652'; //pruebas

    // Configurar el token de autenticación Bearer
    //$token = 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImVkLnBlbmEuOTRAaG90bWFpbC5jb20iLCJuYW1lIjoiTGFsbyIsImdpdmVuX25hbWUiOiJFZHVhcmRvIFBlw7FhIE9tYcOxYSIsInJvbCI6IjEiLCJzdWJjYXRlZ29yaWEiOlsiMTAiLCIyIiwiMyIsIjQiLCI1IiwiNiIsIjciLCI4IiwiOSJdLCJjYXRlZ29yaWEiOiIxIiwibmJmIjoxNzAwNTk2ODMyLCJleHAiOjE3MDA2ODMyMzIsImlhdCI6MTcwMDU5NjgzMiwiaXNzIjoiU2lnYSIsImF1ZCI6IkF1ZGllbmNlIn0.q9dwtsirCDylcZThsXyVIluTil1JcPEg404bSN56Ojmf6oke-Aj1hhUWB0j2qq88Pu432uifqTX6FDNYfBOtIg';

    // Inicializar cURL
    $ch = curl_init($api_url);

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token,
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignorar la verificación del certificado SSL

    // Ejecutar la solicitud cURL y obtener la respuesta
    $response = curl_exec($ch);

    // Verificar si hubo errores en la solicitud
    if (curl_errno($ch)) {
        echo 'Error en la solicitud cURL: ' . curl_error($ch);
    } else {
        // Hacer algo con la respuesta
        //var_dump($response);

        // Obtener el código de estado de la respuesta
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Verificar si la respuesta es un PDF o un mensaje de error
        if ($http_code == 200 && strpos($response, '%PDF-') === 0) {
            // Configurar los encabezados para mostrar el PDF en el navegador
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="boleta2324.pdf"'); // Puedes cambiar el nombre del archivo

            // Mostrar el contenido del PDF
            echo $response;
        } else {
            // Decodeamos la respuesta JSON para poder obtener el mensaje de error
            $data = json_decode($response, true);
                
            echo '<!DOCTYPE html>';
            echo '<html lang="en">';
            echo '<head>';
            echo '    <meta charset="UTF-8">';
            echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
            echo '    <title>Div en el Centro</title>';
            echo '    <style>';
            echo '        body {';
            echo '            background-color: #E7E7E7;';
            echo '            display: flex;';
            echo '            align-items: center;';
            echo '            justify-content: center;';
            echo '            height: 100vh;';
            echo '            margin: 0;';
            echo '            font-family: Arial, sans-serif; /* Cambio de la fuente del cuerpo del documento */';
            echo '        }';
            echo '        #miDiv {';
            echo '            background-color: #FFFFFF;';
            echo '            text-align: center;';
            echo '            padding: 20px;';
            echo '            border: 1px solid #ccc;';
            echo '            border-radius: 10px;';
            echo '        }';
            echo '        #miBoton {';
            echo '            background-color: #3498db;';
            echo '            color: #fff;';
            echo '            padding: 10px 20px;';
            echo '            font-size: 16px;';
            echo '            border: none;';
            echo '            border-radius: 5px;';
            echo '            cursor: pointer;';
            echo '            transition: background-color 0.3s;';
            echo '        }';
            echo '        #miBoton:hover {';
            echo '            background-color: #2980b9;';
            echo '        }';
            echo '    </style>';
            echo '</head>';
            echo '<body>';

            // Contenido del div
            echo '<form action="https://portal.usebeq.edu.mx/portal/index.php">';
            echo '<div id="miDiv">';
            echo '    <h2>No es posible generar la boleta en este momento, favor de intentarlo más tarde.</h2>';
            echo '    <button id="miBoton" type="submit">Regresar</button>';
            echo '</div>';
            echo '</form>';

            echo '</body>';
            echo '</html>';
            
        }

    }

    // Cerrar la sesión cURL
    curl_close($ch);
?>

