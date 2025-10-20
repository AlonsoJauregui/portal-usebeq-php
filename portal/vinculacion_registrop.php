<?php 
	error_reporting(0);
	require("../conexion.php");
	

	// tomo los datos del formulario anterior
	$tipo_v = $_POST['tipo'];
	$curp = trim(strtoupper($_POST['curp']));
	$curp_p = trim(strtoupper($_POST['curpd']));
	$sexo   = substr($curp_p,10,1);	
	$cct = strtoupper($_POST['cct']);
	$clave_prof   = substr($cct,2,3);
	$turno = strtoupper($_POST['turno']);
	$email = strtolower($_POST['email']);
	$tel = $_POST['tel'];	
	$nombre = mb_strtoupper($_POST['responsable']);

	//verificamos las extensiones de los archivos
	if ($_FILES["identificacion"]["type"] == 'application/pdf') {
		$ext_id = ".pdf";
	}

	$fecha = date("d-m-Y");
	$estatus = "SOLICITADO";
	$mensaje = 0;


	// Usuario responsable de autorizar la baja 

	$query_prof = $conexion->query("SELECT TOP 1 clavecct,turno, ce_inicic, pe_appat, pe_apmat, pe_nombre, pe_estatus, curpemp 
										   FROM SCE034_V
										   WHERE clavecct = '$cct' AND turno = '$turno' AND curpemp = '$curp_p' AND ce_inicic = 2024 AND pe_estatus = 'ACTIVO' ORDER BY 1 DESC ");
	$existe_prof = $query_prof->rowCount();
	foreach($query_prof as $datos_p){
		$ap_pat_p = trim($datos_p['pe_appat']);
		$ap_mat_p = trim($datos_p['pe_apmat']);		
	}

	$query_alumno = $conexion->query("SELECT TOP 1 sce004.al_id,sce004.al_curp,sce004.al_nombre,sce004.al_appat,sce004.al_apmat,sce004.al_estatus,sce002.eg_grado,sce002.eg_grupo,sce002.clavecct, sce002.ce_inicic 
    FROM SCE004 INNER JOIN SCE006 ON SCE004.al_id = SCE006.al_id
    INNER JOIN SCE002 ON SCE002.eg_id = SCE006.eg_id
    WHERE sce004.al_curp = '$curp'"); 
	$existe_alumno = $query_alumno->rowCount();

	foreach($query_alumno as $datosAlum){
			$estatusAlum = trim($datosAlum['al_estatus']);			
			$cctAlum = trim($datosAlum['clavecct']);
			$clave_asp   = substr($cctAlum,2,3);
			$al_appat = trim($datosAlum['al_appat']);
			$al_apmat = trim($datosAlum['al_apmat']);
			$al_grado = $datosAlum['eg_grado'];
			$al_id = $datosAlum['al_id'];
			

			}
	
			

	// VALIDAR QUE EL ALUMNO EXISTE
	if($existe_alumno == 0 || $existe_prof == 0)
	{

		$mensaje = 7; 
		
	}else
	{
		// //echo $estatusAlum;
		if ($estatusAlum == 'I' || $estatusAlum == 'A')  
		{

			if ($_FILES["identificacion"]["error"]) 
			{
				$mensaje = 6;
			}
			else 
			{

		// 		//=================== Consulta de registros existentes =================

				$registros = $conexion->query("SELECT COUNT(*) AS REGISTROS    
											FROM [sce2018].[dbo].[Historica_VH]
											WHERE AL_CURP IN ('$curp')");

				foreach ($registros as $fila) {
					$rev_cuenta = $fila['REGISTROS'];
				}
	
		// 		//revisamos si ya hay algun tramite realizado previamente
				if ($rev_cuenta == 0) 
				{
	
					$limite_kb = 2000;
					$permitidos = array('application/pdf');
	
		// 			//verificamos que los archivos no excedan el limite permitido
					if ($_FILES["identificacion"]["size"] <= $limite_kb*1024) 
					{
	
						if (in_array($_FILES["identificacion"]["type"], $permitidos)) 
						{						

							if(((($al_grado == '3') && ($clave_asp == 'DJN' || $clave_asp == 'DCC' || $clave_asp == 'EJN' || $clave_asp == 'PJN')) && 
							($clave_prof == 'DPR' || $clave_prof == 'DPB'))
							|| ((($al_grado == '6') && ($clave_asp == 'DPR' || $clave_asp == 'DPB' || $clave_asp == 'PPR' || $clave_asp == 'EPR'))
							&& ($clave_prof == 'DST' ||  $clave_prof == 'DES' || $clave_prof == 'DTV')))
							{
								
								if ($tipo_v == 'CONSANGUINEO') 
								{
									echo $sexo.$al_appat.$ap_pat_p;
									if(($sexo == 'M' && $al_apmat = $ap_pat_p) || ($sexo == 'H' && $ap_pat_p == $al_appat))
									{

											$identificacion = $curp."IDE".$ext_id;							
											 $ruta = "D:/certificados_pdf/archivos_vp/";
											//$ruta = "C:/xampp/htdocs/portal_24/portal/archivos_vp/";
											$archivo_iden = $ruta.$curp."IDE".$ext_id;							
					
											$carga1 = @move_uploaded_file($_FILES["identificacion"]["tmp_name"] , $archivo_iden);
											
											// $statement = $conexion->prepare('INSERT INTO tramite_baja (curp, nombre, cct, nombre_cct, grado, grupo, dom_cct, nivel, correo, motivo, realiza, identi, acta, curpf, fecha_sol, estatus, usuario, tel) VALUES (:curp, :nombre, :cct, :nombre_cct, :grado, :grupo, :dom_cct, :nivel, :correo, :motivo, :realiza, :identi, :acta, :curpf, :fecha_sol, :estatus, :usuario, :tel)');
											// $statement->execute(array(":curp"=>$curp, ":nombre"=>$nombre, ":cct"=>$cct, ":nombre_cct"=>$nombre_esc, ":grado"=>$grado, ":grupo"=>$grupo, ":dom_cct"=>$dom_esc, ":nivel"=>$nivel, ":correo"=>$email, ":motivo"=>$motivo, ":realiza"=>$realiza, ":identi"=>$identificacion, ":acta"=>$acta, ":curpf"=>$curpf, ":fecha_sol"=>$fecha, ":estatus"=>$estatus , ":usuario"=>$resposable, ":tel"=>$tel));
											// $resultado = $statement -> fetch();

											$parentesco = "CONSANGUINEOSM";
											$estatus = "APROBADA";
											$canal = 'LINEA';
											echo $nombre;
											
											$vh_c1 = $conexion->prepare('INSERT INTO Historica_VH ( al_id, al_curp, cct, eg_grado, al_id_h, al_curp_h, cct_h, eg_grado_h, fecha_solicitud, tel, correo, parentesco, estatus,
											estatus_multiHer, sis_nombre, sis_fecha, sis_estatus, comunicacion, comentarios, canal, al_id_t, al_curp_t, tutor) 
											VALUES (:al_id, :al_curp, :cct, :eg_grado, :al_id_h, :al_curp_h, :cct_h, :eg_grado_h, GETDATE(), :tel, :correo, :parentesco, NULL,
											NULL, :sis_nombre, GETDATE(),:sis_estatus, NULL, :comentarios, :canal, NULL, :al_curp_t, :tutor)');
											$vh_c1->execute(array(":al_id"=>$al_id,":al_curp"=>$curp,":cct"=>$cctAlum,":eg_grado"=>$al_grado,":al_id_h"=>$al_id,":al_curp_h"=>$curp_p,":cct_h"=>$cct,":eg_grado_h"=>$al_grado,
											":tel"=>$tel, ":correo"=>$email, ":parentesco"=>$parentesco, ":sis_nombre"=>$nombre, ":sis_estatus"=>$estatus, ":comentarios"=>$identificacion, ":canal"=>$canal, ":al_curp_t"=> $turno, ":tutor"=>$curp_p));
											$resultado_c1 = $vh_c1 -> fetch();
					
											sleep(2);
					
											//verificamos que el dato se insertara correctamente
											$conf_curp = $conexion->query("SELECT al_curp FROM Historica_VH WHERE al_curp = '$curp'");
											$conf_cuenta = $conf_curp->rowCount();
					
											if ($conf_cuenta == 0) {
												$mensaje = 5;
											}
											else {
												$mensaje = 1;
											}

			// 							
									}
									else {
										$mensaje = 11;
										// La vinculación no procede como consanguinea, debes ingresarla por afinidad, recuerda adjuntar acta de nacimiento del 
										// estudiante, INE del profesor y el Acta de matrimonio.
									}
									
								
								} else
								{

									$identificacion = $curp."IDE".$ext_id;							
										$ruta = "D:/certificados_pdf/archivos_vp/";
										$archivo_iden = $ruta.$curp."IDE".$ext_id;							
				
										$carga1 = @move_uploaded_file($_FILES["identificacion"]["tmp_name"] , $archivo_iden);
										
										// $statement = $conexion->prepare('INSERT INTO tramite_baja (curp, nombre, cct, nombre_cct, grado, grupo, dom_cct, nivel, correo, motivo, realiza, identi, acta, curpf, fecha_sol, estatus, usuario, tel) VALUES (:curp, :nombre, :cct, :nombre_cct, :grado, :grupo, :dom_cct, :nivel, :correo, :motivo, :realiza, :identi, :acta, :curpf, :fecha_sol, :estatus, :usuario, :tel)');
										// $statement->execute(array(":curp"=>$curp, ":nombre"=>$nombre, ":cct"=>$cct, ":nombre_cct"=>$nombre_esc, ":grado"=>$grado, ":grupo"=>$grupo, ":dom_cct"=>$dom_esc, ":nivel"=>$nivel, ":correo"=>$email, ":motivo"=>$motivo, ":realiza"=>$realiza, ":identi"=>$identificacion, ":acta"=>$acta, ":curpf"=>$curpf, ":fecha_sol"=>$fecha, ":estatus"=>$estatus , ":usuario"=>$resposable, ":tel"=>$tel));
										// $resultado = $statement -> fetch();

										$parentesco = "AFINIDADM";
										$estatus = "APROBADA";
										$canal = 'LINEA';
										
										$vh_c1 = $conexion->prepare('INSERT INTO Historica_VH ( al_id, al_curp, cct, eg_grado, al_id_h, al_curp_h, cct_h, eg_grado_h, fecha_solicitud, tel, correo, parentesco, estatus,
										estatus_multiHer, sis_nombre, sis_fecha, sis_estatus, comunicacion, comentarios, canal, al_id_t, al_curp_t, tutor) 
										VALUES (:al_id, :al_curp, :cct, :eg_grado, :al_id_h, :al_curp_h, :cct_h, :eg_grado_h, GETDATE(), :tel, :correo, :parentesco, NULL,
										NULL, :sis_nombre, GETDATE(),:sis_estatus, NULL, NULL, :canal, NULL, NULL, :tutor)');
										$vh_c1->execute(array(":al_id"=>$al_id,":al_curp"=>$curp,":cct"=>$cctAlum,":eg_grado"=>$al_grado,":al_id_h"=>$al_id,":al_curp_h"=>$curp_p,":cct_h"=>$cct,":eg_grado_h"=>$al_grado,
										":tel"=>$tel, ":correo"=>$email, ":parentesco"=>$parentesco, ":sis_nombre"=>$resposable, ":sis_estatus"=>$estatus, ":canal"=>$canal, ":tutor"=>$curp_p));
										$resultado_c1 = $vh_c1 -> fetch();
				
										sleep(2);
				
										//verificamos que el dato se insertara correctamente
										$conf_curp = $conexion->query("SELECT al_curp FROM Historica_VH WHERE al_curp = '$curp'");
										$conf_cuenta = $conf_curp->rowCount();
				
										if ($conf_cuenta == 0) {
											$mensaje = 5;
										}
										else {
											$mensaje = 1;
										}

		// 							
								}


							}
							else
							{
								$mensaje = 0;
								// Los alumnos no cumplen con los criterios para ser vinculados.
								
							}
	
						}
						else {
							$mensaje = 6;
						}
	
					}
					else {
						$mensaje = 6;
					}
	
				}
				else
				{				
						$mensaje = 2;				
	
				}

			}
			
	
		}	 
		else 
		{
			
			$mensaje = 9;
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
							<label>La vinculación se ha realizado correctamente, por favor imprimir su comprobante.</label>
							<br>
						</div>

						<!-- <div class="col-lg-12 form-group text-center">

						<form action="sol_bajas.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>	 -->

						<div class="col-lg-12 form-group text-center">

						<form action="reporte.php" method="post" enctype=" ">
							<input type="hidden" name="curp" value="<?php echo $curp ?>">							
							<button type="submit" class="btn btn-info">Imprimir Vinculación</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 2) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>El alumno que desea vincular ya cuenta con una vinculación, verifique la vinculación y en el caso de cancelar enviar un correo a rresendizg@usebeq.edu.mx.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="solicitud_vp_prof.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 3) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>Ya cuenta con una solicitud de baja, dicha fue rechazada por inconsistencias en la información.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="solicitud_vp_prof.php" method="post" enctype=" ">
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

						<form action="solicitud_vp_prof.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 6) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>Se detectó algún problema con el archivo proporcionado, el formato no es válido o bien exceden el límite soportado (2 MB), por favor intente nuevamente.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="solicitud_vp_prof.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 11) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>La vinculación no procede como consanguínea, debes ingresarla por afinidad, recuerda adjuntar acta de nacimiento del estudiante, INE y el Acta de matrimonio del profesor.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="solicitud_vp_prof.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } elseif ($mensaje == 12) { ?>

                  		<div class="col-lg-12 form-group text-center">
							<label>Se detectó algún problema con los archivos proporcionados, el formato no es válido, por favor verifique que los documentos se encuentren en formato PNG, JPG o JPEG e intente nuevamente.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="solicitud_vp_prof.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
						
					<?php } elseif ($mensaje == 7) { ?>

						<div class="col-lg-12 form-group text-center">
							<!-- <label>El estudiante no se encuentra con los datos ingresados, verificar que este inscrito en la escuela que registra, si tiene dudas puede contactarnos vía <a href="https://api.whatsapp.com/send?phone=524427573377">WhatsApp</a>.</label>
							<br> -->
							<label>Revisar que la información que ingresó sea correcta debido a que no se encontró información con esos datos.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="solicitud_vp_prof.php" method="post" enctype=" ">
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
							<form action="solicitud_vp_prof.php" method="post">
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

						<form action="solicitud_vp_prof.php" method="post" enctype=" ">
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