<?php 
	error_reporting(0);
	require("../conexion.php");
	

	// tomo los datos del formulario anterior.
	$curp = trim(strtoupper($_POST['curp']));
	$nombre = mb_strtoupper($_POST['nombre']);
	$cct = strtoupper($_POST['cct']);
	//$cct_10 = substr($al_clave,0,10);
	$nombre_esc =  mb_strtoupper($_POST['escuela']);
	$grado = $_POST['grado'];
	$grupo = strtoupper($_POST['grupo']);
	$dom_esc =  mb_strtoupper($_POST['dom_esc']);
    // $nivel = $_POST['nivel'];
	$email = strtolower($_POST['email']);
	$tel = $_POST['tel'];
	$motivo = $_POST['motivo'];
	$realiza = $_POST['realiza'];

	//verificamos las extensiones de los archivos
	if ($_FILES["identificacion"]["type"] == 'image/png') {
		$ext_id = ".png";
	}
	if ($_FILES["identificacion"]["type"] == 'image/jpeg') {
		$ext_id = ".jpg";
	}
	if ($_FILES["identificacion"]["type"] == 'image/jpg') {
		$ext_id = ".jpg";
	}
	if ($_FILES["identificacion"]["type"] == 'image/gif') {
		$ext_id = ".gif";
	}

	if ($_FILES["acta"]["type"] == 'image/png') {
		$ext_acta = ".png";
	}
	if ($_FILES["acta"]["type"] == 'image/jpeg') {
		$ext_acta = ".jpg";
	}
	if ($_FILES["acta"]["type"] == 'image/jpg') {
		$ext_acta = ".jpg";
	}
	if ($_FILES["acta"]["type"] == 'image/gif') {
		$ext_acta = ".gif";
	}

	if ($_FILES["curpf"]["type"] == 'image/png') {
		$ext_curp = ".png";
	}
	if ($_FILES["curpf"]["type"] == 'image/jpeg') {
		$ext_curp = ".jpg";
	}
	if ($_FILES["curpf"]["type"] == 'image/jpg') {
		$ext_curp = ".jpg";
	}
	if ($_FILES["curpf"]["type"] == 'image/gif') {
		$ext_curp = ".gif";
	}
	
	$fecha = date("d-m-Y");

	$estatus = "SOLICITADO";
	$mensaje = 0;
	// Usuario responsable de autorizar la baja 

	$query_responsable = $conexion->query("SELECT TOP 1  clave, responsable, responsables.region, responsables.nivel FROM responsables INNER JOIN usuarios ON RESPONSABLES.RESPONSABLE = USUARIOS.nombre WHERE clave = '$cct'");
	foreach($query_responsable as $datosRespon){
		$clave_resp = trim($datosRespon['clave']);
		//echo $estatusAlum;
		$resposable = trim($datosRespon['responsable']);
		//echo $cctAlum;
		$region =  trim($datosRespon['region']);
		$nivel =  trim($datosRespon['nivel']);
	}

	$query_alumno = $conexion->query("SELECT TOP 1 sce004.al_id,sce004.al_curp,sce004.al_nombre,sce004.al_appat,sce004.al_apmat,sce004.al_estatus,sce002.eg_grado,sce002.eg_grupo,sce002.clavecct, sce002.ce_inicic 
    FROM SCE004 INNER JOIN SCE006 ON SCE004.al_id = SCE006.al_id
    INNER JOIN SCE002 ON SCE002.eg_id = SCE006.eg_id
    WHERE sce004.al_curp = '$curp'"); 
	$existe_alumno = $query_alumno->rowCount();

	foreach($query_alumno as $datosAlum){
			$estatusAlum = trim($datosAlum['al_estatus']);
			//echo $estatusAlum;
			$cctAlum = trim($datosAlum['clavecct']);
			//echo $cctAlum;
			}
	
			

	// VALIDAR QUE EL ALUMNO EXISTE
	if($existe_alumno == 0){

		$mensaje = 7; 
		//El alumno no se encuentra con los datos ingresados, verifique que el estudiante este inscrito en la escuela que registra, si tiene dudas envie WhatsApp.
		//https://api.whatsapp.com/send?phone=524427573377
	}else{
		//echo $estatusAlum;
		if (($estatusAlum == 'I' || $estatusAlum == 'A') && $cctAlum == $cct) {

			if ($_FILES["identificacion"]["error"] OR $_FILES["acta"]["error"] OR $_FILES["curpf"]["error"]) {
				$mensaje = 6;
			}
			else {
	
				$rev_curp = $conexion->query("SELECT curp, estatus FROM tramite_baja WHERE curp = '$curp' and estatus in ('SOLICITADO', 'PREVIA') and cct = '$cct'");
				$rev_cuenta = $rev_curp->rowCount();
	
				//revisamos si ya hay algun tramite realizado previamente
				if ($rev_cuenta == 0) {
	
					$limite_kb = 2000;
					$permitidos = array('image/png','image/jpeg','image/jpg','image/gif');
	
					//verificamos que los archivos no excedan el limite permitido
					if ($_FILES["identificacion"]["size"] <= $limite_kb*1024 && $_FILES["acta"]["size"] <= $limite_kb*1024 && $_FILES["curpf"]["size"] <= $limite_kb*1024) {
	
						if (in_array($_FILES["identificacion"]["type"], $permitidos) && in_array($_FILES["acta"]["type"], $permitidos) && in_array($_FILES["curpf"]["type"], $permitidos)) {
	
							$identificacion = $curp."IDE".$ext_id;
							$acta = $curp."ACTA".$ext_acta;
							$curpf = $curp."CURP".$ext_curp;
							
							$ruta = "D:/certificados_pdf/archivos_baja/";
							$archivo_iden = $ruta.$curp."IDE".$ext_id;
							$archivo_acta = $ruta.$curp."ACTA".$ext_acta;
							$archivo_curp = $ruta.$curp."CURP".$ext_curp;

							if ($region == 1) {
								$resposable = 'REGION 1';
							}elseif ($region == 2) {
								$resposable = 'REGION 2';
							}elseif ($region == 3) {
								$resposable = 'REGION 3';
							}
	
							$carga1 = @move_uploaded_file($_FILES["identificacion"]["tmp_name"] , $archivo_iden);
							$carga2 = @move_uploaded_file($_FILES["acta"]["tmp_name"] , $archivo_acta);
							$carga3 = @move_uploaded_file($_FILES["curpf"]["tmp_name"] , $archivo_curp);
							

							$statement = $conexion->prepare('INSERT INTO tramite_baja (curp, nombre, cct, nombre_cct, grado, grupo, dom_cct, nivel, correo, motivo, realiza, identi, acta, curpf, fecha_sol, estatus, usuario, tel) VALUES (:curp, :nombre, :cct, :nombre_cct, :grado, :grupo, :dom_cct, :nivel, :correo, :motivo, :realiza, :identi, :acta, :curpf, :fecha_sol, :estatus, :usuario, :tel)');
	
							$statement->execute(array(":curp"=>$curp, ":nombre"=>$nombre, ":cct"=>$cct, ":nombre_cct"=>$nombre_esc, ":grado"=>$grado, ":grupo"=>$grupo, ":dom_cct"=>$dom_esc, ":nivel"=>$nivel, ":correo"=>$email, ":motivo"=>$motivo, ":realiza"=>$realiza, ":identi"=>$identificacion, ":acta"=>$acta, ":curpf"=>$curpf, ":fecha_sol"=>$fecha, ":estatus"=>$estatus , ":usuario"=>$resposable, ":tel"=>$tel));
							$resultado = $statement -> fetch();
	
							sleep(2);
	
							//verificamos que el dato se insertara correctamente
							$conf_curp = $conexion->query("SELECT curp, estatus FROM tramite_baja WHERE curp = '$curp'");
							$conf_cuenta = $conf_curp->rowCount();
	
							if ($conf_cuenta == 0) {
								$mensaje = 5;
							}
							else {
								$mensaje = 1;
							}
	
						}
						else {
							$mensaje = 12;
						}
	
					}
					else {
						$mensaje = 11;
					}
	
				}
				else {
	
					// foreach($rev_curp as $dato){
					// 	$estatus = $dato['estatus'];
					// }
	
					//validamos en que estatus se encuentra el tramite solicitado
					// if ($estatus == 'SOLICITADO' OR $estatus == 'PREVIA') {
						$mensaje = 2;
					// }
					// if ($estatus == 'RECHAZADA') {
					// 	$mensaje = 3;
					// }
					// if ($estatus == 'REALIZADA') {
					// 	$mensaje = 4;
					// }
	
				}
	
			}
		} else {
			
			$mensaje = 9;
		}
		
		if ($estatusAlum == 'E' || $estatusAlum == 'B') {
			if ($estatusAlum == 'E'){
				$estatusAlum = 'egresado';
			}
			if ($estatusAlum == 'B'){
				$estatusAlum = 'baja';
			}

			$mensaje = 8;
		}
		
		
	}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Duplicados en Linea
  </title>
  <!-- Favicon -->
  <link href="./assets/img/brand/favicon.ico" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="./assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="./assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="./assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link href="/assets/fontawesome.min.css" rel="stylesheet">

</head>

<body class="">

  <!--inicia barra de navegacion -->

  <nav class="navbar navbar-vertical navbar-expand-md navbar-light bg-white d-md-none" id="sidenav-main">
    <div class="container-fluid">
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="panel.php">
        <img src="assets/img/brand/USEBEQ2.png" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
                <img alt="Image placeholder" width="100" src="./assets/img/brand/USEBEQ.png">
            </div>
          </a>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="panel.php">
                <img src="./assets/img/brand/USEBEQ2.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        
      </div>
    </div>
  </nav>

  <div class="main-content">
  <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h2 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="panel.php">
          <img src="assets/img/brand/USEBEQ2.png" width="50" class="navbar-brand-img" alt="...">
          &nbsp;SISCER
        </a>
        <!-- Form -->
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="">
                  <img alt="Image placeholder" width="140" src="./assets/img/brand/USEBEQB.png">
                </span>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
  

    <!-- Header -->
    <div class="header pb-9 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(./assets/img/theme/fondo.png); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-info opacity-8"></span>
      
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--10">
      <div class="row justify-content-md-center">

        <div class="col-xl-10 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-12 text-center">
                  <h3 class="mb-0">Solicitud de baja en linea.</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">
                    
                  </div>

                  <div class="row">

                  	<?php if ($mensaje == 1) { ?>

                  		<div class="col-12 text-center">
							<label>Su solicitud se ha realizado correctamente, por favor imprimir su comprobante.</label>
							<br>
						</div>

						<!-- <div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>	 -->

						<div class="col-lg-12 form-group text-center">

						<form action="imprime_sol_baja.php" method="post" enctype=" ">
							<input type="hidden" name="curp" value="<?php echo $curp ?>">
							<input type="hidden" name="nombre" value="<?php echo $nombre ?>">
							<input type="hidden" name="cct" value="<?php echo $cct ?>">
							<input type="hidden" name="nombre_esc" value="<?php echo $nombre_esc ?>">
							<input type="hidden" name="grado" value="<?php echo $grado ?>">
		                    <input type="hidden" name="grupo" value="<?php echo $grupo ?>">
		                    <input type="hidden" name="dom_esc" value="<?php echo $dom_esc ?>">
		                    <input type="hidden" name="nivel" value="<?php echo $nivel ?>"> 
		                    <input type="hidden" name="motivo" value="<?php echo $motivo ?>">
		                    <input type="hidden" name="realiza" value="<?php echo $realiza ?>">
		                    <input type="hidden" name="fecha" value="<?php echo $fecha ?>">
							<button type="submit" class="btn btn-info">Imprimir Solicitud</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 2) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>Ya cuenta con una solicitud de baja, actualmente se encuentra en proceso de validación.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 3) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>Ya cuenta con una solicitud de baja, dicha fue rechazada por inconsistencias en la información.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 4) { ?>

	                  	<div class="col-lg-12 form-group text-center">
							<label>Ya cuenta con una solicitud de baja, su petición de baja fue realizada con éxito, por favor imprima su comprobante de baja.</label>
							<br>
						</div>		

						<div class="col-lg-12 form-group text-center">

						<form action="imprime_baja.php" method="post" enctype=" ">
	                    <input type="hidden" name="curp" value="<?php echo $curp ?>">
							<button type="submit" class="btn btn-info">Imprimir Solicitud</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 5) { ?>

	                  	<div class="col-lg-12 form-group text-center">
							<label>No fue posible generar su solicitud debido a un problema con la comunicación, por favor intente nuevamente.</label>
							<br>
						</div>		

	                  	<div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 6) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>Se detectó algún problema con los archivos proporcionados, el formato no es válido o bien exceden el límite soportado (2 MB), por favor intente nuevamente.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 11) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>Se detectó algún problema con los archivos proporcionados, exceden el límite soportado (2 MB), por favor verifique que los documentos cuenten con el peso requerido e intente nuevamente.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 12) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>Se detectó algún problema con los archivos proporcionados, el formato no es válido, por favor verifique que los documentos se encuentren en formato PNG, JPG o JPEG e intente nuevamente.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
						
					<?php } elseif ($mensaje == 7) { ?>

						<div class="col-lg-12 form-group text-center">
							<!-- <label>El estudiante no se encuentra con los datos ingresados, verificar que este inscrito en la escuela que registra, si tiene dudas puede contactarnos vía <a href="https://api.whatsapp.com/send?phone=524427573377">WhatsApp</a>.</label>
							<br> -->
							<label>El estudiante no se encuentra con los datos ingresados, tenga en cuenta que no se realizan bajas de otros Estados.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 8) { 
						if ($estatusAlum == 'egresado') {
						?>

							<div class="col-lg-12 form-group text-center">
								<label> El estudiante se encuentra con estatus de <?php echo $estatusAlum; ?>, no procede su solicitud debido a que no está inscrito en alguna institución.</label>
								<br>
							</div>

							<div class="col-lg-12 form-group text-center">
							<form action="../index.php" method="post" enctype=" ">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>
							</div>

						<?php } else { ?>

							<div class="row col-12 justify-content-center">
							<label align="center">El estudiante se encuentra con estatus de <?php echo $estatusAlum; ?>, pude reimprimir su comprobante.</label>
							</div>

							

							<div class="col-lg-12 form-group text-center">
							<div class="col-12 centrado">
								<form action="reimprime_baja.php" target="_blank" method="POST">
								<button type="submit" class="btn btn-info">Reimprime formato baja</button>
								<input type="hidden" name="curp" value="<?php echo $curp ?>">
								</form>								
							</div>
							</div>
							<div class="col-lg-12 form-group text-center">
							<div class="col-12 centrado">	

								<form action="https://www.usebeq.edu.mx/PaginaWEB/encuestas/evaluacionServicioSGC" target="_blank" method="POST">
								<button type="submit" class="btn btn-success">Evaluación del servicio</button>
								</form>
							</div>
							</div>
							<div class="col-lg-12 form-group text-center">
							<form action="sol_bajas.php" method="post">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>
							</div>
					
					<?php }
					 } elseif ($mensaje == 9) { ?>

						<div class="col-lg-12 form-group text-center">
							<label> El estudiante no se encuentra con los datos ingresados, verificar que esté inscrito en la escuela que esta registrando.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
					
					<?php } ?>
					

                  </div>
                  
                </div> 
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2019 <a href="https://www.usebeq.edu.mx/PaginaWEB/" class="font-weight-bold ml-1" target="_blank">USEBEQ</a>
            </div>
          </div>
          <div class="col-xl-6">
            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
              <li class="nav-item">
                <a href="https://www.usebeq.edu.mx/PaginaWEB/" class="nav-link" target="_blank">USEBEQ</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!--   Core   -->
  <script src="./assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="./assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="./assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
</body>

</html>
<?php

  $rev_curp = null;
  $conf_curp = null;
  $conexion = null;

?>