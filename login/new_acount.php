<!DOCTYPE html>
<html lang="es">
<head>
	<title>Login V12</title>
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
	        document.getElementById("btsubmit").value = "Realizando el registro...";
	        document.getElementById("btsubmit").disabled = true;
	        return true;
	    }
	</script>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: linear-gradient(to left, rgba(31, 43, 105, 0.7), rgba(79, 134, 176, 0.3)), url('../assets/img/theme/fondo.png'); background-size: cover; background-position: center top;">
			<div class="wrap-login100 p-t-70 p-b-30">
				<form action="registro.php" method="POST" class="login100-form validate-form" onsubmit="return checkSubmit();">
					<div class="login100-form-title">
						<img width="220" src="images/USEBEQN.png" alt="AVATAR">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						Portal para Padres de Familia
					</span>

					<!-- <div class="wrap-input100 validate-input m-b-10" data-validate = "Nombre de Usuario requerido">
						<input class="input100" type="text" name="userpp" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div> -->

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Correo requerido">
						<input class="input100" type="email" name="mail" placeholder="Correo Electrónico">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-at"></i>
						</span>
					</div>

					<!--<div class="wrap-input100 validate-input m-b-10" data-validate = "Teléfono requerido">
						<input class="input100" type="text" name="tel" placeholder="Teléfono a 10 dígitos" maxlength="10">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-phone"></i>
						</span>
					</div>-->

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Contraseña requerida">
						<input class="input100" type="password" name="pass1" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Contraseña requerida">
						<input class="input100" type="password" name="pass2" placeholder="Repetir Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<input class="login100-form-btn1" type="submit" id="btsubmit" value="Registrarse" />
					</div>

					<div class="text-center w-full p-t-25 p-b-200">
						<a class="txt1" href="login.php">
							Inicia Sesión
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