<?php

	$correo = $_GET['user'];

	//echo $correo;

	require("conexion.php");

	$activa = $conexion -> prepare("UPDATE PP_usuarios SET estatus = 'VALIDADO' WHERE u_correo = '$correo'");
	$activa -> execute(array());

	//echo "Cuenta verificada con exito :D";

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Login V12</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel=”Shortcut Icon” href=”img/favicon.ico” type=”image/x-icon” />
	<script src="js/popper.min.js"></script>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

		<script>
	   		$(document).ready(function()
	      		{
	         		$("#modal").modal("show");
	      		});
		</script>

</head>
<body>
	
	<!-- Modal -->
	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <h4>Cuenta verificada con exito</h4>
	      </div>
	      <div class="modal-footer">
	      	<form action="index.php">
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

	$activa = null;
	$conexion = null;

?>