<?php

    if (isset($_GET['email'])) {
        
         $email = $_GET['email'];
       

    }
    else {
        // No hay información por validar.
        $resp_api = 1;

    }
   // echo $email. "desde la api";
class VmNeoRedResult {
    public $Resultado;
    public $Estatus;
    
    // Añadir otros campos según sea necesario
}

class NeoApiCaller {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function NeoApiCall($dato, $tipo) {
        $result = null;
        $url = $this->config['url'];
        $key = $this->config['key'];

        $payload = json_encode([
            'key' => $key,
            'dato' => $dato,
            'tipo' => $tipo
        ]);

        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n" .
                            "Content-Length: " . strlen($payload) . "\r\n",
                'method' => 'POST',
                'content' => $payload,
                'timeout' => 60
            ]
        ];

        $context = stream_context_create($options);

        try { 
            // leer el archivo en una cadena
            $response = file_get_contents($url, false, $context);
            if ($response) {
                $responseData = json_decode($response, true);
                $result = new VmNeoRedResult();
                $result->Resultado = $responseData['resultado'] ?? null;
                $result->Estatus = ($result->Resultado ?? 'invalido') != 'invalido';
            }
        } catch (Exception $e) {
            // Manejar la excepción según sea necesario
            error_log('Request failed: ' . $e->getMessage());
        }

        return $result;
    }
}

// Ejemplo de configuración y uso
$config = [
    
];

$neoApiCaller = new NeoApiCaller($config);
$result = $neoApiCaller->NeoApiCall($email, 'correo');

// Manejar el resultado
if ($result !== null) {
     $resp_api = $result->Resultado;
    // echo '<br>';
    //echo 'Estatus: ' . ($result->Estatus ? 'válido' : 'inválido');
    
} else {
    // no hay comunicación con la API
    $resp_api = 2;
}
?>