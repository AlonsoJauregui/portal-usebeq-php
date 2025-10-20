<?php

	//$userpp = $_POST['userpp'];
	$correo = $_POST['mail'];

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


  	if ($cuenta == 1) {  

  			$correo1 = base64_encode($correo);		

			$enlace = "https://portal.usebeq.edu.mx/portal/login/cambio_pass.php?user=".$correo1;
			//$destino = $mail;
			//$desde = "From:"."Control Escolar";
			//$asunto = "Activación de cuenta Portal de Padres USEBEQ";
			//$mensaje = "Gracias por tu registro en nuestro portal de padres.<br>Para finalizar el registro por favor activar su cuenta en el siguiente enlace:<br><br>".$enlace;

			//mail($destino, $asunto, $mensaje, $desde);

			// Instantiation and passing `true` enables exceptions
			$mail = new PHPMailer(true);

			$file = fopen("bandera2.txt", "r");

			while(!feof($file)) {

				$flag = fgets($file);
				//echo "la bandera es: ".$flag."<br>";

			}

			fclose($file);

				if ($flag == 1) {
					
				    $cuenta_act   = 'controlescolar30@usebeq.edu.mx';

				}
				if ($flag == 2) {
					
					$cuenta_act   = 'controlescolar2@usebeq.edu.mx';

				}
				if ($flag == 3) {
					
					$cuenta_act   = 'controlescolar3@usebeq.edu.mx';

				}
				if ($flag == 4) {
					
					$cuenta_act   = 'controlescolar4@usebeq.edu.mx';

				}
				if ($flag == 5) {
					
					$cuenta_act   = 'controlescolar5@usebeq.edu.mx';

				}
				if ($flag == 6) {
					
					$cuenta_act   = 'controlescolar6@usebeq.edu.mx';

				}
				if ($flag == 7) {
					
					$cuenta_act   = 'controlescolar7@usebeq.edu.mx';

				}
				if ($flag == 8) {
					
					$cuenta_act   = 'controlescolar7@usebeq.edu.mx';

				}
				if ($flag == 9) {
					
					$cuenta_act   = 'controlescolar9@usebeq.edu.mx';

				}
				if ($flag == 10) {
					
				    $cuenta_act   = 'controlescolar8@usebeq.edu.mx';

				}
				if ($flag == 11) {
					
					$cuenta_act   = 'controlescolar11@usebeq.edu.mx';

				}
				if ($flag == 12) {
					
					$cuenta_act   = 'controlescolar12@usebeq.edu.mx';

				}
				if ($flag == 13) {
					
					$cuenta_act   = 'controlescolar13@usebeq.edu.mx';

				}
				if ($flag == 14) {
					
					$cuenta_act   = 'controlescolar14@usebeq.edu.mx';

				}
				if ($flag == 15) {
					
					$cuenta_act   = 'controlescolar16@usebeq.edu.mx';

				}
				if ($flag == 16) {
					
					$cuenta_act   = 'controlescolar16@usebeq.edu.mx';

				}
				if ($flag == 17) {
					
					$cuenta_act   = 'controlescolar17@usebeq.edu.mx';

				}
				if ($flag == 18) {
					
					$cuenta_act   = 'controlescolar18@usebeq.edu.mx';

				}
				if ($flag == 19) {
					
				    $cuenta_act   = 'controlescolar19@usebeq.edu.mx';

				}
				if ($flag == 20) {
					
					$cuenta_act   = 'controlescolar20@usebeq.edu.mx';

				}
				if ($flag == 21) {
					
					$cuenta_act   = 'controlescolar21@usebeq.edu.mx';

				}
				if ($flag == 22) {
					
					$cuenta_act   = 'controlescolar22@usebeq.edu.mx';

				}
				if ($flag == 23) {
					
					$cuenta_act   = 'controlescolar23@usebeq.edu.mx';

				}
				if ($flag == 24) {
					
					$cuenta_act   = 'controlescolar24@usebeq.edu.mx';

				}
				if ($flag == 25) {
					
					$cuenta_act   = 'controlescolar25@usebeq.edu.mx';

				}
				if ($flag == 26) {
					
					$cuenta_act   = 'controlescolar26@usebeq.edu.mx';

				}
				if ($flag == 27) {
					
					$cuenta_act   = 'controlescolar27@usebeq.edu.mx';

				}
				if ($flag == 28) {
					
					$cuenta_act   = 'controlescolar28@usebeq.edu.mx';

				}
				if ($flag == 29) {
					
					$cuenta_act   = 'controlescolar29@usebeq.edu.mx';

				}
				if ($flag == '') {
					$cuenta_act = 'controlescolar29@usebeq.edu.mx';
					$flag = 29;
				}

			try {
			    
			    //Server settings
				$mail->SMTPDebug = 0;                                       // Enable verbose debug output
				$mail->isSMTP();                                            // Set mailer to use SMTP
				$mail->Host       = 'smtp.gmail.com';  						// Specify main and backup SMTP servers
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = $cuenta_act;        // SMTP username
				$mail->Password   = '';                             // SMTP password
				$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port       = 587;                                    // TCP port to connect to

				//Recipients
				$mail->setFrom($cuenta_act, 'PortalPadres');
				$mail->addAddress($correo);     								// Add a recipient

			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = utf8_decode("Cambio de contraseña Portal de Padres");
			    $mail->Body    = "Accede al enlace que se incluye en este mensaje para restablecer tu contraseña.<br><br> Enlace:<br>".$enlace."<br><br>Este mensaje se genera de forma automatica, por favor no contestes a este mensaje.";

			    $mail->send();
			    //echo 'Cuenta creada exitosamente, favor de activar su cuenta verificando en su cuenta de correo electronico.';

			    $mensaje = 1;

			} catch (Exception $e) {
			    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			    $mensaje = 4;
			}

			//echo "Cuenta creada exitosamente, favor de activar su cuenta verificando en su cuenta de correo electronico.";

			++$flag;

			if ($flag == 30) {
				$flag = 1;
			}

			$file = fopen("bandera2.txt", "w");

			fwrite($file, $flag);


			fclose($file);

  	}
  	else {

  		//echo "El correo ingresado no se encuentra registrado en el Portal de Padres o no ha sido validado, por favor ingrese una cuenta de correo registrada o valide su cuenta.";
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
	         		$("#staticBackdrop").modal("show");
	      		});
		</script>
	<?php } ?>
	<?php if ($mensaje == 4) { ?>
		<script>
	   		$(document).ready(function()
	      		{
	         		$("#staticBackdrop").modal("show");
	      		});
		</script>
	<?php } ?>
	<?php if ($mensaje == 3) { ?>
		<script>
	   		$(document).ready(function()
	      		{
	         		$("#staticBackdrop").modal("show");
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
	<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
    	<div class="modal-content">
      	  <div class="modal-header">
	        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>-->
	      </div>
	      <?php if ($mensaje == 1) { ?>
	      <div class="modal-body">
	        <h5>Gracias por el interés en nuestro Portal de Padres USEBEQ. <br><br>
	        	Por favor ingresa a tu cuenta de correo <b><?php echo $correo; ?></b> y busca el correo del portal para restablecer tu contraseña.</h5>
	      </div>
	      <?php } ?>
	      <?php if ($mensaje == 4) { ?>
	      <div class="modal-body">
	        <h5>Por el momento se está realizando mantenimiento al sistema de gestión de correos, por favor intenta más tarde.</h5>
	      </div>
	      <?php } ?>
	      <?php if ($mensaje == 3) { ?>
	      <div class="modal-body">
	        <h5>El correo ingresado no se encuentra registrado en el Portal de Padres o no ha sido validado, por favor ingrese una cuenta de correo registrada o valide su cuenta.</h5>
	      </div>
	      <?php } ?>
	      <div class="modal-footer">
	      	<form action="../index.php">
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
	$conexion = null;

?>