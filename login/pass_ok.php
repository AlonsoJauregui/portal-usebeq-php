<?php

	//$userpp = $_POST['userpp'];
	$correo = $_POST['mail'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];


	require("../conexion.php");

	if ($pass1 == $pass2) {

		$pass1 = base64_encode($pass1);

		$agrega = $conexion->query("UPDATE PP_usuarios SET u_pass = '$pass1', estatus = 'VALIDADO' WHERE u_correo = '$correo'");

		$mensaje = 1;
		
	}
	else {
		$mensaje = 2;
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
	<?php if ($mensaje == 2) { ?>
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
	        <h5><!--Gracias por el interés en nuestro Portal de Padres USEBEQ. <br><br>-->
	        	La nueva contraseña ha sido establecida correctamente para la cuenta con el correo <b><?php echo $correo; ?></b>.<br><br>Da clic en Aceptar para iniciar sesión.</h5>
	      </div>
	      <div class="modal-footer">
	      	<form action="login.php">
	        	<button type="submit" class="btn btn-primary">Aceptar</button>
	        </form>
	      </div>
	      <?php } ?>
	      <?php if ($mensaje == 2) { ?>
	      <div class="modal-body">
	        <h5>Las contraseñas ingresadas no coinciden, por favor intentalo nuevamente.</h5>
	      </div>
	      <div class="modal-footer">
	      	<form action="cambio_pass.php" method="GET">
	        	<button type="submit" class="btn btn-primary">Aceptar</button>
	        	<input type="hidden" name="user" value="<?php echo $mail; ?>">
	        </form>
	      </div>
	      <?php } ?>
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

	$agrega = null;
	$conexion = null;

?>