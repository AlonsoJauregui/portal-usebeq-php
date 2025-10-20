<?php 
	set_time_limit(0); // Sin límite de tiempo de ejecución.
	ini_set('memory_limit', '-1'); // para no tener límite de memoria, establezca esta directiva en -1.
	header("Content-Type: text/html;charset=utf-8");
	header('Content-Transfer-Encoding: binary');
	header('Content-Description: File Transfer');
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate');
	require("../conexion.php");

	// tomo los datos del formulario anterior.
	$curp = trim($_POST['curp']);	
	$parentesco = $_POST['parentesco'];
	$nombre_padre = mb_strtoupper($_POST['nombre_padre']);
	$motivo = mb_strtoupper($_POST['motivo']);
	$tel = $_POST['tel'];
	$email = strtolower($_POST['email']);
	
	$year = date("Y");
	$ciclo_esc = $year-1;
	$fecha_actual = date("Y-m-d");
	$fecha_inicio_promocion = '2025-07-22';
	$fecha_fin_promocion = '2025-08-05';
	$mensaje = 0;



	// AGREGAR FECHAS DE LA PROMOCIÓN Y POSTERIOR Y ANTES DE LA PROMOCION

	if ($fecha_actual < $fecha_inicio_promocion || $fecha_actual >= $fecha_fin_promocion ){



		
		require("../api_neored.php");
		// 	if (isset($_GET['resp_api'])) {
				
		// 		$resp_api = $_GET['resp_api'];
			

		//    }
		//    else {
		// 	   No hay información por validar.
		// 	   echo $resp_api = 0;

		//    }
		if ($resp_api == 1) {
			$mensaje = 20;
			//$mensaje = "El input de la dirección del correo esta vacío, ingrese nuevamente la solicitud con toda la información capturada.";
		}elseif ($resp_api == 2) {
			$mensaje = 21;
			//$mensaje = 'Error de comunicación al validar el correo.';
		}elseif ($resp_api == 'valido'){
			//echo $curp;
			//verificamos las extensiones de los archivos
			if ($_FILES["identificacion"]["type"] == 'image/png') {
				$ext_iden = ".png";
			}
			if ($_FILES["identificacion"]["type"] == 'image/jpeg') {
				$ext_iden = ".jpg";
			}
			if ($_FILES["identificacion"]["type"] == 'image/jpg') {
				$ext_iden = ".jpg";
			}
			if ($_FILES["identificacion"]["type"] == 'image/gif') {
				$ext_iden = ".gif";
			}
			if ($_FILES["identificacion"]["type"] == 'application/pdf') {
				$ext_iden = ".pdf";
			}

			if ($_FILES["actafile"]["type"] == 'image/png') {
				$ext_acta = ".png";
			}
			if ($_FILES["actafile"]["type"] == 'image/jpeg') {
				$ext_acta = ".jpg";
			}
			if ($_FILES["actafile"]["type"] == 'image/jpg') {
				$ext_acta = ".jpg";
			}
			if ($_FILES["actafile"]["type"] == 'image/gif') {
				$ext_acta = ".gif";
			}
			if ($_FILES["actafile"]["type"] == 'application/pdf') {
				$ext_acta = ".pdf";
			}

			if ($_FILES["anexo8"]["type"] == 'image/png') {
				$ext_ane8 = ".png";
			}
			if ($_FILES["anexo8"]["type"] == 'image/jpeg') {
				$ext_ane8 = ".jpg";
			}
			if ($_FILES["anexo8"]["type"] == 'image/jpg') {
				$ext_ane8 = ".jpg";
			}
			if ($_FILES["anexo8"]["type"] == 'image/gif') {
				$ext_ane8 = ".gif";
			}
			if ($_FILES["anexo8"]["type"] == 'application/pdf') {
				$ext_ane8 = ".pdf";
			}

			// REVOCACIONES REGISTRADAS ANTES DE LA PROMOCIÓN				
				if ($fecha_actual < $fecha_inicio_promocion){
					$curpExiste = $conexion->query("SELECT TOP 1 sce004.al_id,sce004.al_curp,sce004.al_appat,sce004.al_apmat, sce004.al_nombre,sce004.al_estatus, sce004.IdEstatusAcreditacion, sce002.eg_grado,
						sce002.eg_grupo,sce002.clavecct,sce002.nombrect,sce002.nivel,sce002.ce_inicic, sce002.ce_fincic,sce002.turno, A_CTBA.serreg, A_CTBA.director, A_CTBA.sos_des, COUNT(*) CANT
						FROM SCE004 INNER JOIN SCE006 ON SCE004.al_id = SCE006.al_id
						INNER JOIN SCE002 ON SCE002.eg_id = SCE006.eg_id
						INNER JOIN A_CTBA ON A_CTBA.clavecct = sce002.clavecct
						WHERE al_curp = '$curp' 
						GROUP BY sce004.al_id,sce004.al_curp,sce004.al_appat,sce004.al_apmat, sce004.al_nombre, sce004.al_estatus, sce004.IdEstatusAcreditacion, sce002.eg_grado,
						sce002.eg_grupo,sce002.clavecct,sce002.nombrect, sce002.nivel, sce002.eg_grado,sce002.ce_inicic, sce002.ce_fincic, A_CTBA.serreg, A_CTBA.director, A_CTBA.sos_des, sce002.turno");
					$cantcurp = $curpExiste->rowCount();
					
					$consulta = $conexion->query("SELECT sce004.al_id,sce004.al_curp,sce004.al_nombre,sce004.al_appat,sce004.al_apmat,sce004.al_estatus,sce002.eg_grado,sce002.eg_grupo,sce002.clavecct FROM SCE004 INNER JOIN SCE006 ON SCE004.al_id = SCE006.al_id
						INNER JOIN SCE002 ON SCE002.eg_id = SCE006.eg_id
						WHERE AL_CURP = '$curp'");

				}elseif ($fecha_actual > $fecha_fin_promocion ){

					$curpExiste = $conexion->query("SELECT TOP 1 sce004.al_id,sce004.al_curp,sce004.al_appat,sce004.al_apmat, sce004.al_nombre,sce004.al_estatus, sce004.IdEstatusAcreditacion, sce002.eg_grado,
						sce002.eg_grupo,sce002.clavecct,sce002.nombrect,sce002.nivel,sce002.ce_inicic, sce002.ce_fincic,sce002.turno, A_CTBA.serreg, A_CTBA.director, A_CTBA.sos_des, COUNT(*) CANT
						FROM sce017 INNER JOIN sce002 ON  sce017.eg_id = sce002.eg_id INNER JOIN sce004 ON sce004.al_id = sce017.al_id INNER JOIN A_CTBA ON A_CTBA.clavecct = sce002.clavecct 
						WHERE al_curp = '$curp' AND sce002.ce_inicic = '$ciclo_esc'
						GROUP BY sce004.al_id,sce004.al_curp,sce004.al_appat,sce004.al_apmat, sce004.al_nombre, sce004.al_estatus, sce004.IdEstatusAcreditacion, sce002.eg_grado,
						sce002.eg_grupo,sce002.clavecct,sce002.nombrect, sce002.nivel, sce002.eg_grado,sce002.ce_inicic, sce002.ce_fincic, A_CTBA.serreg, A_CTBA.director, A_CTBA.sos_des, sce002.turno");
					$cantcurp = $curpExiste->rowCount();
					
					$consulta = $conexion->query("SELECT sce004.al_id,sce004.al_curp,sce004.al_nombre,sce004.al_appat,sce004.al_apmat,sce004.al_estatus,sce002.eg_grado,sce002.eg_grupo,sce002.clavecct 
						FROM SCE004 INNER JOIN SCE017 ON SCE004.al_id = SCE017.al_id
						INNER JOIN SCE002 ON SCE002.eg_id = SCE017.eg_id
						WHERE AL_CURP = '$curp' AND sce017.am_ciclo = '$ciclo_esc'");

				}

				
				//echo $cantcurp. "<br>". $cantcurp;
				foreach ($curpExiste as $fila) {
					$curpCantA = $fila['CANT'];
					$al_id = $fila['al_id'];
					$turno = $fila['turno'];
					// echo $curpCantA;
					$nombre_alum = mb_strtoupper($fila['al_appat']. " " . $fila['al_apmat'] . " " . $fila['al_nombre']);
					$nombre_director = mb_strtoupper($fila['director']);
					$cct = trim(strtoupper($fila['clavecct']));
					$especial = substr($cct,0,-5);
					//echo $especial;
					$nombre_esc = mb_strtoupper($fila['nombrect']);
					$region =substr(mb_strtoupper($fila['serreg']),2,1);
					//echo $region;
					$grado = $fila['eg_grado'];	
					$grupo = trim($fila['eg_grupo']);	
					$nivel = $fila['nivel'];	
					$acreditacion = $fila['IdEstatusAcreditacion'];
					$ciclo_ini = trim(strtoupper($fila['ce_inicic']));
					$ciclo_fin = trim(strtoupper($fila['ce_fincic']));
					$ciclo = $ciclo_ini ."-". $ciclo_fin;
					if ($nivel == 'PRE'){
						$nivel = 'PREESCOLAR';			
					}elseif ($nivel == 'PRI') {
						$nivel = 'PRIMARIA';	
					}elseif ($nivel == 'SEC') {
						$nivel = 'SECUNDARIA';	
					}
					$sostenimiento = trim(strtoupper($fila['sos_des']));
					if ($sostenimiento == 'FEDERAL TRANSFERIDO'){
						$sostenimiento = 'PUBLICO';
					}
					//$sostenimiento = 'PUBLICO';

				}

				if ($cantcurp == -1) {
					while ($row=$consulta->fetch(PDO:: FETCH_ASSOC)) {
						# code...		
						$al_estatus = trim(strtoupper($row['al_estatus'])); 
						//echo " ". $al_estatus;
						if (($acreditacion == 1 || $acreditacion == 3) || ($nivel == 'PREESCOLAR')) {		
							# code...
							//echo $al_estatus;
							
							$fecha = date("d-m-Y");
							$estatus = "SOLICITADO";
							$mensaje = 0;
				
							if ($_FILES["identificacion"]["error"] OR $_FILES["actafile"]["error"] OR $_FILES["anexo8"]["error"]) {
								$mensaje = 6;
								//echo $mensaje;
							}
							else{
				
								$rev_registros = $conexion->query("SELECT TOP 1 al_curp, estatus, folio, comentarios, nivel FROM tramite_revocaciong WHERE al_curp = '$curp' ORDER BY id_rev DESC");
								$rev_cantidad = $rev_registros->rowCount();
								// https://codea.app/blog/subir-una-imagen-a-una-carpeta-interna-de-un-servidor-web
								//revisamos si ya hay algun tramite realizado previamente
								foreach($rev_registros as $dato){
									$estatus = $dato['estatus'];
									$nivel_ant = $dato['nivel'];
									$folio = $dato['folio'];
									$comentarios = $dato['comentarios'];
								}
								if ($rev_cantidad == 0 || $estatus == 'RECHAZADA') {
									$estatus = "SOLICITADO";	
									$limite_kb = 2000;
									$extensiones = array('image/png','image/jpeg','image/jpg','image/gif', 'application/pdf');
				
									//verificamos que los archivos no excedan el limite permitido
									if ($_FILES["identificacion"]["size"] <= $limite_kb*1024 && $_FILES["actafile"]["size"] <= $limite_kb*1024 && $_FILES["anexo8"]["size"] <= $limite_kb*1024) {
										// vericando la extensión 
										if (in_array($_FILES["identificacion"]["type"], $extensiones) && in_array($_FILES["actafile"]["type"], $extensiones) && in_array($_FILES["anexo8"]["type"], $extensiones)) {
									
											$identificacion = $curp."IDE".$ext_iden;
											$actafile = $curp."ACTA".$ext_acta;
											$anexo8 = $curp."ANE8".$ext_ane8;
											
											// ======================= VERIFICAR RUTA DE LAS REVOCACIONES  =========================
											//$ruta = "E:/certificados_pdf/archivos_baja/";
											//$ruta = "D:/certificados_pdf/archivos_baja/";
											$ruta = "D:/certificados_pdf/archivos_revocacion/";
											//$ruta = "C:/xampp/htdocs/MEJORAS/portal/portal/archivos_revocacion/";
											$archivo_iden = $ruta.$curp."IDE".$ext_iden;
											$archivo_acta = $ruta.$curp."ACTA".$ext_acta;
											$archivo_anexo = $ruta.$curp."ANE8".$ext_ane8;
				
											$carga1 = @move_uploaded_file($_FILES["identificacion"]["tmp_name"] , $archivo_iden);
											$carga2 = @move_uploaded_file($_FILES["actafile"]["tmp_name"] , $archivo_acta);
											$carga3 = @move_uploaded_file($_FILES["anexo8"]["tmp_name"] , $archivo_anexo);
											//echo $curp. " ". $grado . " " .$nombre_alum. " ". $nombre_director. " ". $nombre_esc . " ". $cct . " ". $dom_esc. " " . $fecha . " " . $nivel . " " . $parentesco . " " . $nombre_padre . " ". $dom_padre ." ". $tel ." ". $email . " ". $identificacion . " " . $anexo8 . " " . $actafile ." ". $responsable . " " . $fecha;
											
											// CREAR FOLIO
											$queryfolio = $conexion -> query("SELECT TOP 1 * FROM tramite_revocaciong WHERE folio like 'RE25%'  ORDER BY folio DESC");
											foreach ($queryfolio as $datofolio) {
												$folio = $datofolio['folio'];
											}
											
											if ($datofolio['folio'] == '') {
												$folio="RG25-0001";
											}
											$year = substr($year,2,2);
											$year_tram = substr($datofolio['folio'], 2, 2);

											if ($year_tram != $year) {
												$folio="RE".$year."-0001";
											}else{
												$folio = $datofolio['folio'];
												$folio++;
											}

											if ($region == 1){
												$responsable = 'REGION 1';
											}elseif ($region == 2){
												$responsable = 'REGION 2';
											}elseif ($region == 3){
												$responsable = 'REGION 3';
											}else {
												$tipo_cct = substr($cct,2,3);
												if( $tipo_cct == 'DML' || $tipo_cct == 'PIV'){
													$responsable = 'ahurtado';
												}else{
													if ($nivel == 'PREESCOLAR' || $nivel == 'PRIMARIA'){
														$usuario1 = $conexion -> query("SELECT * FROM tramite_revocaciong WHERE region = '4' AND responsable <> 'ahurtado' AND nivel IN ('PREESCOLAR','PRIMARIA') AND responsable = 'eugalde' AND YEAR(fecha_solicitud) = $year");
														$cant_usu1 = $usuario1->rowCount();
														$usuario2 = $conexion -> query("SELECT * FROM tramite_revocaciong WHERE region = '4' AND responsable <> 'ahurtado' AND nivel IN ('PREESCOLAR','PRIMARIA') AND responsable = 'arangelp' AND YEAR(fecha_solicitud) = $year");
														$cant_usu2 = $usuario2->rowCount();
														$usuario3 = $conexion -> query("SELECT * FROM tramite_revocaciong WHERE region = '4' AND responsable <> 'ahurtado' AND nivel IN ('PREESCOLAR','PRIMARIA') AND responsable = 'mmartinezf' AND YEAR(fecha_solicitud) = $year");
														$cant_usu3 = $usuario3->rowCount();
														$usuario4 = $conexion -> query("SELECT * FROM tramite_revocaciong WHERE region = '4' AND responsable <> 'ahurtado' AND nivel IN ('PREESCOLAR','PRIMARIA') AND responsable = 'acoronar' AND YEAR(fecha_solicitud) = $year");
														$cant_usu4 = $usuario4->rowCount();
														
														if ($cant_usu1 == 0) {
															$responsable = 'eugalde';
														}elseif ($cant_usu2 == 0){
															$responsable = 'arangelp';
														}elseif ($cant_usu3 == 0){
															$responsable = 'mmartinezf';
														}elseif ($cant_usu4 == 0){
															$responsable = 'acoronar';
														}
														else{
														$usuario_min = $conexion -> query("SELECT TOP 1 responsable, COUNT(*) cantSol  FROM tramite_revocaciong WHERE region = '4' AND responsable <> 'ahurtado' AND nivel IN ('PREESCOLAR','PRIMARIA') AND responsable IN ('eugalde','arangelp','mmartinezf','acoronar') AND YEAR(fecha_solicitud) = $year GROUP BY responsable ORDER BY cantSol");
														foreach ($usuario_min as $dato_min) {
															$responsable = $dato_min['responsable'];
														}	
														}
													}elseif ($nivel == 'SECUNDARIA'){
														$usuario5 = $conexion -> query("SELECT * FROM tramite_revocaciong WHERE region = '4' AND responsable <> 'ahurtado' AND nivel = 'SECUNDARIA' AND responsable = 'agraciam' AND YEAR(fecha_solicitud) = $year");
														$cant_usu5 = $usuario5->rowCount();
														$usuario6 = $conexion -> query("SELECT * FROM tramite_revocaciong WHERE region = '4' AND responsable <> 'ahurtado' AND nivel IN ('SECUNDARIA') AND responsable = 'aortiz' AND YEAR(fecha_solicitud) = $year");
														$cant_usu6 = $usuario6->rowCount();
														$usuario7 = $conexion -> query("SELECT * FROM tramite_revocaciong WHERE region = '4' AND responsable <> 'ahurtado' AND nivel IN ('SECUNDARIA') AND responsable = 'hsalazar' AND YEAR(fecha_solicitud) = $year");
														$cant_usu7 = $usuario7->rowCount();
															
														if ($cant_usu5 == 0) {
															$responsable = 'agraciam';
														}elseif ($cant_usu6 == 0) {
															$responsable = 'aortiz';
														}elseif ($cant_usu7 == 0) {
															$responsable = 'hsalazar';
														}else{
														$usuario_min = $conexion -> query("SELECT TOP 1 responsable, COUNT(*) cantSol  FROM tramite_revocaciong WHERE region = '4' AND responsable <> 'ahurtado' AND nivel = ('SECUNDARIA') AND responsable IN ('agraciam','aortiz','hsalazar') AND YEAR(fecha_solicitud) = $year GROUP BY responsable ORDER BY cantSol");
														foreach ($usuario_min as $dato_min) {
															$responsable = $dato_min['responsable'];
														}
														}
													}
												
													//$responsable = 'REGION 4';
												}
												
											}

											// //$responsable = 'SISCER';
											$statement = $conexion->prepare('INSERT INTO tramite_revocaciong (folio, al_curp, al_grado, al_grupo, al_nombreComp, director_nom, esc_nombre, cct, region, fecha_solicitud, ciclo_escolar, nivel, sostenimiento, parentesco, padre_nombre, padre_domicilio, padre_tel, padre_correo, identificacion, curp_file, acta_nacimiento, anexo8, responsable, fecha_elaborado, estatus, observaciones, comentarios, motivo, al_id, al_turno)
											VALUES (:folio, :al_curp, :al_grado, :al_grupo, :al_nombreComp, :director_nom, :esc_nombre, :cct, :region, GETDATE(), :ciclo_escolar, :nivel, :sostenimiento, :parentesco, :padre_nombre, NULL, :padre_tel, :padre_correo, :identificacion, NULL, :acta_nacimiento, :anexo8, :responsable, NULL, :estatus, NULL, NULL, :motivo, :al_id, :al_turno)');
											$statement->execute(array( ":folio"=>$folio, ":al_curp"=>$curp, ":al_grado"=> $grado, ":al_grupo"=> $grupo, ":al_nombreComp"=>$nombre_alum, ":director_nom"=>$nombre_director, ":esc_nombre"=>$nombre_esc, ":cct"=>$cct, ":region"=>$region,":ciclo_escolar"=> $ciclo, ":nivel"=>$nivel, ":sostenimiento"=>$sostenimiento, ":parentesco"=>$parentesco, ":padre_nombre"=>$nombre_padre, ":padre_tel"=>$tel, ":padre_correo"=>$email, ":identificacion"=>$identificacion, ":acta_nacimiento"=>$actafile, ":anexo8"=>$anexo8, ":responsable"=>$responsable, ":estatus"=>$estatus, ":motivo"=>$motivo, ":al_id"=>$al_id, ":al_turno"=>$turno));
											$resultado = $statement -> fetch();	
											sleep(2);	
											//verificamos que el dato se insertara correctamente
											$conf_curp = $conexion->query("SELECT al_curp, estatus, folio FROM tramite_revocaciong WHERE al_curp = '$curp'");
											$conf_cuenta = $conf_curp->rowCount();

											foreach ($conf_curp as $solicitud) {
											
											}
				
											if ($conf_cuenta == 0) {
											
												$mensaje = 5;
											}
											else {
												include("../correo_automatico.php");
												if ($mensaje == 1){
													$mensaje = 1;
												}elseif ($mensaje == 30){
													$mensaje = 30;
												}else{
													$mensaje = 1;
												}
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
								else {	

									//echo $rev_cantidad." ".$estatus. " ".$nivel. " ".$nivel_ant. " ".$especial;
									

									//validamos en que estatus se encuentra el tramite solicitado
									if ($estatus == 'SOLICITADO' OR $estatus == 'PREVIA') {							
										$mensaje = 2;
									}
									if ($estatus == 'CANCELADA') {
										$mensaje = 3;
									}
									if ($estatus == 'REALIZADA' || $estatus == 'APROBADA') {
										$mensaje = 4;
									}

									// VALIDAMOS QUE NO SOLICITE LA REVOCACION EN EL MISMO NIVEL
									if ($rev_cantidad <> 0 && $estatus == 'APROBADA' && $nivel == $nivel_ant){
										$mensaje = 9;
									}

								
				
								}
				
							}
				
				
							
							
						}else{	
							$mensaje = 7; // EL ALUMNO NO CUMPLE CON LOS CRITERIOS PARA UBNA REVOCACIÓN	
						}
				
						
					}
				}else{
					$mensaje = 8;
				}
				
			// }elseif ($fecha_actual > $fecha_fin_promo){

			// }
			
		}else{
			// $mensaje = 'El correo no es valido, registra la solicitud con un correo activo.';
			$mensaje = 22;
		}
	

	}else{
		$mensaje = 40;
	}

	
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Revocación en Línea
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
  <link href="./assets/fontawesome.min.css" rel="stylesheet">

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
	<div class="header pb-9 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(/*./assets/img/theme/fondo.png*/); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-lighter opacity-8"></span>
      
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--10">
      <div class="row justify-content-md-center">

        <div class="col-xl-10 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-12 text-center">
                  <h3 class="mb-0">Solicitud de Revocación de Grado.</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">
                    
                  </div>

                  <div class="row col-12 justify-content-center">
					<!-- revisar 1 y 4  -->
					<!-- 
					1. Su solicitud se ha realizado correctamente, por favor imprimir su comprobante. sol_bajas / imprime_sol_baja
					2. Ya cuenta con una solicitud de revocación, actualmente se encuentra en proceso de validación.
					3. Ya cuenta con una solicitud de revocación, dicha fue rechazada por inconsistencias en la información.
					4. Ya cuenta con una solicitud de revocación, su petición de revocación fue realizada con éxito, por favor imprima su comprobante de revocación. imprime_baja
					5. No fue posible generar su solicitud debido a un problema con la comunicación, por favor intente nuevamente.
					6. Se detectó algún problema con los archivos proporcionados, el formato no es valido o bien exceden el limite soportado (500 kb), por favor intente nuevamente.
					7. El estudiante no se encuentra inscrito por tanto no puede solicitar la revocación.
					8. No se encontró registro con la CURP que ingreso. 
					-->



                  	<?php if ($mensaje == 1) { ?>

                  		<div class="row col-12 justify-content-center">
							
							<label>¡La solicitud de revocación de grado fue registrada!</label>
							
						</div>
						<div class="row col-12 justify-content-center">						
							
							<label>Nota: Se le dará una respuesta lo más pronto posible, favor de revisar el estatus de su tramite.</label>
							
						</div>
						<div class="row col-12 justify-content-center">
							
							<label><b>¡No olvides descargar tu solicitud!</b></label>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="imprime_anexo8.php" method="post" enctype=" ">
							<input type="hidden" name="nombre_director" value="<?php echo $nombre_director ?>">
							<input type="hidden" name="nombre_esc" value="<?php echo $nombre_esc ?>">
							<input type="hidden" name="cct" value="<?php echo $cct ?>">
							<input type="hidden" name="region" value="<?php echo $region ?>">
							<input type="hidden" name="fecha" value="<?php echo $fecha ?>">
							<input type="hidden" name="nombre_alum" value="<?php echo $nombre_alum ?>">
							<input type="hidden" name="curp" value="<?php echo $curp ?>">
							<input type="hidden" name="grado" value="<?php echo $grado ?>">
							<input type="hidden" name="ciclo" value="<?php echo $ciclo ?>">
							<input type="hidden" name="nivel" value="<?php echo $nivel ?>">							
							<input type="hidden" name="nombre_padre" value="<?php echo $nombre_padre ?>">
							<input type="hidden" name="tel" value="<?php echo $tel ?>">
							<input type="hidden" name="folio" value="<?php echo $folio ?>">
							<input type="hidden" name="correo" value="<?php echo $email ?>">
						
							<button type="submit" class="btn btn-info">Descargar Solicitud</button>
						</form>

						</div>							

					<?php } if ($mensaje == 2) { ?>

                  		<div class="row col-12 justify-content-center">
							<label>Ya cuenta con el folio <b><?php echo $folio ?></b> de revocación de grado, actualmente su solicitud se encuentra en proceso de validación.</label>
						</div>
						<div class="row col-12 justify-content-center">
							<label><b>¡No olvides descargar tu solicitud con folio y revisa el estatus de la revocación más tarde!</b></label>
							
						</div>

						<div class="col-lg-12 form-group text-center">
						<form action="imprime_anexo8.php" method="post" enctype=" ">
							<input type="hidden" name="nombre_director" value="<?php echo $nombre_director ?>">
							<input type="hidden" name="nombre_esc" value="<?php echo $nombre_esc ?>">
							<input type="hidden" name="cct" value="<?php echo $cct ?>">
							<input type="hidden" name="region" value="<?php echo $region ?>">
							<input type="hidden" name="fecha" value="<?php echo $fecha ?>">
							<input type="hidden" name="nombre_alum" value="<?php echo $nombre_alum ?>">
							<input type="hidden" name="curp" value="<?php echo $curp ?>">
							<input type="hidden" name="grado" value="<?php echo $grado ?>">
							<input type="hidden" name="ciclo" value="<?php echo $ciclo ?>">
							<input type="hidden" name="nivel" value="<?php echo $nivel ?>">
							<input type="hidden" name="nombre_padre" value="<?php echo $nombre_padre ?>">
							<input type="hidden" name="tel" value="<?php echo $tel ?>">
							<input type="hidden" name="folio" value="<?php echo $folio ?>">
							<input type="hidden" name="correo" value="<?php echo $email ?>">
						
							<button type="submit" class="btn btn-info">Descargar Solicitud</button>
						</form>
						</div>

					<?php } if ($mensaje == 3) { ?>

                  		<div class="row col-12 justify-content-center">
							<label align="center">Ya cuenta con una solicitud de revocación, dicha fue <b>cancelada</b> . </label>
							<br>
						</div>
						<div class="row col-12 justify-content-center">
							<label align="center">Observaciones: <?php echo $comentarios ?></label>
						</div>
						<div class="col-lg-12 form-group text-center">
							<form action="solicitud_revocacion.php" method="post">
								<button type="submit" class="btn btn-info">Aceptar</button>
							</form>
						</div>    

						

					<?php } if ($mensaje == 4) { ?>

	                  	<div class="row col-12 justify-content-center">
							<label>Ya cuenta con una solicitud de revocación de grado aprobada, imprima el comprobante de baja.</label>
							<br>
						</div>	
						<div class="row col-12 justify-content-center">
							<label><b>¡No olvides descargar tu comprobante de baja!</b></label>
						</div>		

						<div class="col-lg-12 form-group text-center">						
							<!-- IMPRIMIR BAJA -->
						<form action="imprime_comprobante_revo.php" method="post">
						<input type="hidden" id= "curp" name="curp" value="<?php echo $curp ?>">
							<button type="submit" class="btn btn-info">Descargar Baja</button>
						</form>

						</div>
						

					<?php } if ($mensaje == 5) { ?>

	                  	<div class="row col-12 justify-content-center">
							<label>No fue posible generar su solicitud debido a un problema con la comunicación, por favor intente nuevamente.</label>
							<br>
						</div>		

	                  	<div class="col-lg-12 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } if ($mensaje == 6) { ?>

                  		<div class="row col-12 justify-content-center">
							<label>Se detectó algún problema con los archivos proporcionados, el formato no es valido o bien exceden el limite soportado (2 MB), por favor intente nuevamente.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
						
					<?php } if ($mensaje == 7) { ?>
						<div class="row col-12 justify-content-center">
							<label>El estudiante no cumple con los requisitos para una revocación de grado.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
					<?php } if ($mensaje == 8) { ?>
						<div class="row col-12 justify-content-center">
							<label>No se encontró registro con los datos que ingresó, verifique que el CURP sea el mismo que el de la boleta de evaluación.</label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
					<?php } if ($mensaje == 9) { ?>
						<div class="row col-10 justify-content-center">
							<label><b>Solicitud rechazada</b>, <b> la Revocación de Grado solo aplica una vez por nivel educativo </b> y ya fue aplicada anteriormente para el estudiante con CURP <?php echo $curp ?>.</label>
							<br>
						</div>

						<div class="col-lg-10 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
					<?php } if ($mensaje == 20) { ?>
						<div class="row col-10 justify-content-center">
							<label><b>Solicitud rechazada</b>, el input de la dirección del correo esta vacío, ingrese nuevamente la solicitud con toda la información capturada.</label>
							<br>
						</div>

						<div class="col-lg-10 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
					<?php } if ($mensaje == 21) { ?>
						<div class="row col-10 justify-content-center">
							<label> Error de comunicación al validar el correo, registre más tarde su solicitud.</label>
							<br>
						</div>

						<div class="col-lg-10 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
					<?php } if ($mensaje == 22) { ?>
						<div class="row col-10 justify-content-center">
							<label>El correo que capturó no es válido, registra la solicitud con un correo activo.</label>
							<br>
						</div>

						<div class="col-lg-10 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
					<?php } if ($mensaje == 30) { ?>
						<div class="row col-12 justify-content-center">
							
							<label>La solicitud de revocación de grado fue registrada con el folio:<b> <?php echo $folio ?></b></label>
							
						</div>
						<div class="row col-12 justify-content-center">						
							
							<label>Se le dará una respuesta lo más pronto posible a través del correo que registró, mantengase pendiente.</label>
							
						</div>
						
						<div class="col-lg-10 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>
					<?php } if ($mensaje == 40) { ?>
						<div class="row col-12 justify-content-center">
							
							<label><b>No es posible hacer el registro de su solicitud en este momento, el servicio se reanudará a partir del 4 de agosto de 2025. Gracias por su comprensión.</b></label>
							
						</div>
						<!-- <div class="row col-12 justify-content-center">						
							
							<label>Gracias por su comprensión.</label>
							
						</div> -->
						
						<div class="col-lg-10 form-group text-center">

						<form action="solicitud_revocacion.php" method="post" enctype=" ">
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

  $rev_registros = null;
  $conf_curp = null;
  $conexion = null;

?>