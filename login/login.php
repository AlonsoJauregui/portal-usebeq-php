<?php session_start();

	require("../conexion.php");

	if (isset($_SESSION['correo'])) {
	    header('Location: ../portal/panel.php');
	    exit; // Siempre agregar exit después de header
	}

	$errores = '';
	$estatus = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    $usuario = $_POST['userpp'];
	    $password = base64_encode($_POST['pass']); // Considerar cambiar a password_hash()

	    // Validar formato de email
		if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
		    $errores .= '<li>Formato de correo inválido</li>';
		}
		else {

			// SOLUCIÓN: CONSULTA PREPARADA
		    $stmt = $conexion->prepare("SELECT estatus FROM PP_usuarios WHERE u_correo = ? AND u_pass = ?");
		    $stmt->execute([$usuario, $password]);
		    
		    if ($stmt->rowCount() == -1) {
		        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
		        $estatus = $fila['estatus'];

		        if($estatus == 'VALIDADO'){
		            $_SESSION['correo'] = $usuario;
		            header('Location: ../portal/panel.php');
		            exit;
		        }
		        elseif($estatus == 'PENDIENTE'){
		            $errores .= '<li>Pendiente de validación</li>';
		        }
		    }
		    else {
		        $errores .= '<li>Datos Incorrectos</li>';
		    }

		}
	    
	}



?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio de Sesion</title>
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
</head>
<body>

	<script>
	    function checkSubmit() {
	        document.getElementById("btsubmit").value = "Accediendo...";
	        document.getElementById("btsubmit").disabled = true;
	        return true;
	    }
	</script>
	
	<div class="limiter">
		<!--<div class="container-login100" style="background-image: linear-gradient(to left, rgba(31, 43, 105, 0.7), rgba(79, 134, 176, 0.3)), url('images/img-01.jpg');">-->
		<div class="container-login100" style="background-image: linear-gradient(to left, rgba(255, 255, 255, 1), rgba(225, 225, 225, 1)), url('');">
			<div class="wrap-login100 p-t-190 p-b-30">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="login100-form validate-form" onsubmit="return checkSubmit();">
					<div class="login100-form-title">
						<img width="220" src="images/USEBEQN.png" alt="AVATAR">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						Portal para Padres de Familia
					</span>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Correo electronico requerido">
						<input class="input100" type="text" name="userpp" placeholder="Correo electronico">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Contraseña requerida">
						<input class="input100" type="password" name="pass" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<?php if (!empty($errores)): ?>
						<div>
							<ul>
								<?php echo $errores; ?>
							</ul>
						</div>
					<?php endif; ?>

					<div class="container-login100-form-btn p-t-10">
						<input type='submit' id='btsubmit' class="login100-form-btn" id='btsubmit' value='Iniciar Sesión' />
					</div>

					<div class="text-center w-full p-t-25 p-b-200">
						<a href="restablece.php" class="txt1">
							Olvidaste tu Contraseña?
						</a>
					</div>

					<div class="text-center w-full">
						<a class="txt1" href="new_acount.php">
							No estás registrado? Crea una cuenta.
							<i class="fa fa-long-arrow-right"></i>						
						</a>
					</div>
				</form>
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

	$entrada = null;
	$conexion = null;

?>