<?php
	if (isset($_GET['email']) && isset($_GET['folio']) && isset($_GET['estatus'])){			
		$email = $_GET['email'];
		$folio = $_GET['folio'];
		$estatus = $_GET['estatus'];
	}
	else {
		// No hay información por validar.
		$mensaje = 1;
	}
	//echo $email . " " . $folio. " " . $estatus;
	$cuenta_act   = 'solicitar correo';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

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
	//$folio = 'RE23-0003';
	try {

		//Server settings
		$mail->SMTPDebug = 0;                                       // Enable verbose debug output
		$mail->isSMTP();                                            // Set mailer to use SMTP
		$mail->Host       = 'ssmtp.neosmtp.com';                    //'smtp.gmail.com';  						// Specify main and backup SMTP servers
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'solicitar usuario';           //$cuenta_act;        // SMTP username
		$mail->Password   = 'solicitar pass'; //'12345678';                             // SMTP password
		$mail->SMTPSecure = 'TLS';                                  // Enable TLS encryption, `ssl` also accepted
		$mail->Port       = '2525';  

		//Recipients
		$mail->setFrom($cuenta_act, utf8_decode('USEBEQ: Portal de trámites en línea.'));
		$mail->addAddress($email);     								// Add a recipient

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = utf8_decode("Solicitud de Revocación de Grado");
		if ($estatus == 'SOLICITADO'){

			$mail->Body    = "<img src='https://portal.usebeq.edu.mx/portal/login/images/Familia_USEBEQ.png'  width='180' alt='...'> <img src='https://portal.usebeq.edu.mx/portal/login/images/QRO_JUNTOS.png' align='right' width='180' alt='...'><br><hr><h3 align='right'> Folio: $folio </h3>Gracias por tu registro.<br>Tu solicitud será revisada, si tienes un error o la revocación de grado es aprobada recibirás un correo electrónico con más detalles o bien puedes consultar el estatus de tu trámite <a href='https://portal.usebeq.edu.mx/portal/portal/solicitud_revocacion.php'>aquí</a>.<br><br> 
			Descarga tu solicitud en el siguiente enlace: https://portal.usebeq.edu.mx/portal/portal/imprime_anexo8_link.php?folio=$folio<br><br><br>Este mensaje se genera de forma automatica, por favor no responder a este correo.";
			// $mail->Body    = "Gracias por tu registro.<br>Para finalizar el registro por favor activar su cuenta en el siguiente enlace:<br><br><br><br>Este mensaje se genera de forma automatica, por favor no responder a este correo.";
		}
		// }elseif ($estatus == 'APROBADA') {
		// 	$mail->Body    = "<img src='https://portal.usebeq.edu.mx/portal/login/images/Familia_USEBEQ.png'  width='180' alt='...'> <img src='https://portal.usebeq.edu.mx/portal/login/images/QRO_JUNTOS.png' align='right' width='180' alt='...'><br><hr><h3 align='right'> Folio: $folio </h3>Gracias por tu registro.<br>Tu solicitud será revisada, si tienes un error o la revocación de grado es aprobada recibirás un correo electrónico con más detalles o bien puedes consultar el estatus de tu trámite <a href='https://portal.usebeq.edu.mx/portal/portal/solicitud_revocacion.php'>aquí</a>.<br><br> 
		// Descarga tu solicitud en el siguiente enlace: https://portal.usebeq.edu.mx/portal/portal/solicitud_revocacion.php.<br><br><br>Este mensaje se genera de forma automatica, por favor no responder a este correo.";
		// // $mail->Body    = "Gracias por tu registro.<br>Para finalizar el registro por favor activar su cuenta en el siguiente enlace:<br><br><br><br>Este mensaje se genera de forma automatica, por favor no responder a este correo.";

		// }elseif ($estatus == 'RECHAZADA') {
		// 	$mail->Body    = "<img src='https://portal.usebeq.edu.mx/portal/login/images/Familia_USEBEQ.png'  width='180' alt='...'> <img src='https://portal.usebeq.edu.mx/portal/login/images/QRO_JUNTOS.png' align='right' width='180' alt='...'><br><hr><h3 align='right'> Folio: $folio </h3>Gracias por tu registro.<br>Tu solicitud será revisada, si tienes un error o la revocación de grado es aprobada recibirás un correo electrónico con más detalles o bien puedes consultar el estatus de tu trámite <a href='https://portal.usebeq.edu.mx/portal/portal/solicitud_revocacion.php'>aquí</a>.<br><br> 
		// 	Descarga tu solicitud en el siguiente enlace: https://portal.usebeq.edu.mx/portal/portal/solicitud_revocacion.php.<br><br><br>Este mensaje se genera de forma automatica, por favor no responder a este correo.";
		// 	// $mail->Body    = "Gracias por tu registro.<br>Para finalizar el registro por favor activar su cuenta en el siguiente enlace:<br><br><br><br>Este mensaje se genera de forma automatica, por favor no responder a este correo.";
	
		// }elseif ($estatus == 'CANCELADA') {
		// 	$mail->Body    = "<img src='https://portal.usebeq.edu.mx/portal/login/images/Familia_USEBEQ.png'  width='180' alt='...'> <img src='https://portal.usebeq.edu.mx/portal/login/images/QRO_JUNTOS.png' align='right' width='180' alt='...'><br><hr><h3 align='right'> Folio: $folio </h3>Gracias por tu registro.<br>Tu solicitud será revisada, si tienes un error o la revocación de grado es aprobada recibirás un correo electrónico con más detalles o bien puedes consultar el estatus de tu trámite <a href='https://portal.usebeq.edu.mx/portal/portal/solicitud_revocacion.php'>aquí</a>.<br><br> 
		// 	Descarga tu solicitud en el siguiente enlace: https://portal.usebeq.edu.mx/portal/portal/solicitud_revocacion.php.<br><br><br>Este mensaje se genera de forma automatica, por favor no responder a este correo.";
		// 	// $mail->Body    = "Gracias por tu registro.<br>Para finalizar el registro por favor activar su cuenta en el siguiente enlace:<br><br><br><br>Este mensaje se genera de forma automatica, por favor no responder a este correo.";
	
		// }
		
		$mail->send();
			  //echo 'Cuenta creada exitosamente, favor de activar su cuenta verificando en su cuenta de correo electronico.';
		//echo "Correo enviado satisfactoriamente.";
		$mensaje = 30;


	} catch (Exception $e) {
		//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		$error = "Mailer Error: {$mail->ErrorInfo}";
		//echo $error;
		$mensaje = 1;
	}

?>