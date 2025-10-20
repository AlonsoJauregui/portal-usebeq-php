<?php

	//$userpp = $_POST['userpp'];
	$correo = $_POST['mail'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];

	require("../conexion.php");

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	$verifica = $conexion->query("SELECT COUNT(*) AS TOTAL FROM PP_usuarios WHERE u_correo = '$correo'");


	foreach ($verifica as $value) {
    	$cuenta = $value['TOTAL'];
  	}


  	if ($cuenta == 0) {
  		
  		if ($pass1 == $pass2) {
  			
  			$pass1 = base64_encode($pass1);

			$enlace = "https://portal.usebeq.edu.mx/portal/activa.php?user=".$correo;
			//$destino = $mail;
			//$desde = "From:"."Control Escolar";
			//$asunto = "Activación de cuenta Portal de Padres USEBEQ";
			//$mensaje = "Gracias por tu registro en nuestro portal de padres.<br>Para finalizar el registro por favor activar su cuenta en el siguiente enlace:<br><br>".$enlace;

			//mail($destino, $asunto, $mensaje, $desde);
			$cuenta_act   = 'solicitar correo';

			// Instantiation and passing `true` enables exceptions
			$mail = new PHPMailer(true);

			//INICIO - Código agregado por Neored para hacer compatible la libreria con la ultima versión de PHP
			$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
			);
			// FIN - Código agregado por Neored

			try {
			    
			    //Server settings
				$mail->SMTPDebug = 0;                                       // Enable verbose debug output
				$mail->isSMTP();                                            // Set mailer to use SMTP
				$mail->Host       = 'ssmtp.neosmtp.com';  						// Specify main and backup SMTP servers
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = 'solicitar usuario';        // SMTP username
				$mail->Password   = 'solicitar pass';                           // SMTP password
				$mail->SMTPSecure = 'TLS';                                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port       = '2525';                                    // TCP port to connect to

				//Recipients
				$mail->setFrom($cuenta_act, 'Portal de Padres USEBEQ');
				$mail->addAddress($correo);     								// Add a recipient

			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = utf8_decode("Activación de cuenta Portal de Padres USEBEQ");
			    $mail->Body    = "Gracias por tu registro en nuestro portal de padres.<br>Para finalizar el registro por favor activar su cuenta en el siguiente enlace:<br><br>".$enlace."<br><br>Este mensaje se genera de forma automatica, por favor no responder a este correo.";

			    $mail->send();
			    //echo 'Cuenta creada exitosamente, favor de activar su cuenta verificando en su cuenta de correo electronico.';

			    $statement = $conexion->prepare('INSERT INTO PP_usuarios (u_correo, u_pass, estatus) VALUES (:u_correo, :u_pass, :estatus)');

				$statement->execute(array(":u_correo"=>$correo, ":u_pass"=>$pass1, ":estatus"=>'PENDIENTE'));

			    $mensaje = 1;

			} catch (Exception $e) {
			    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			    $mensaje = 4;
			    $error = "Mailer Error: {$mail->ErrorInfo}";
			}

			//echo "Cuenta creada exitosamente, favor de activar su cuenta verificando en su cuenta de correo electronico.";

  		}
  		else {

  			echo "las contraseñas no coinciden";
  			$mensaje = 2;

  		}

  	}
  	else {

  		echo "Ya existe una cuenta con este nombre de usuario";
  		$mensaje = 3;

  	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

	<script src="../js/jquery-3.2.1.min.js"></script>

	<?php if ($mensaje == 1) { ?>
		<script>
	   		$(document).ready(function()
	      		{
	         		$("#modal").modal("show");
	      		});
		</script>
	<?php } ?>
	<?php if ($mensaje == 4) { ?>
		<script>
	   		$(document).ready(function()
	      		{
	         		$("#modal").modal("show");
	      		});
		</script>
	<?php } ?>

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: linear-gradient(to left, rgba(31, 43, 105, 0.7), rgba(79, 134, 176, 0.3)), url('images/img-01.jpg');">
			<div class="wrap-login100 p-t-70 p-b-30">

			</div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <?php if ($mensaje == 1) { ?>
	      <div class="modal-body">
	        <h4>Cuenta creada exitosamente, favor de activarla verificando en su correo electronico.<br><br>
	        En caso de no encontrar nuestro correo en tu bandeja principal, por favor verifica en la bandeja de SPAM o Correo no deseado.</h4>
	      </div>
	      <?php } ?>
	       <?php if ($mensaje == 4) { ?>
	      <div class="modal-body">
	        <h4>Por el momento se está realizando mantenimiento al sistema de gestión de correos, por favor intenta más tarde. <?php echo $error ?></h4>
	      </div>
	      <?php } ?>
	      <div class="modal-footer">
	      	<form action="login.php">
	        	<button type="submit" class="btn btn-primary">Aceptar</button>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
				

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
<?php

	$verifica = null;
	$statement = null;
	$conexion = null;

?>