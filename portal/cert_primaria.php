<?php 

	include("../conexion.php");
	//funcion para eliminar caracteres especiales y acentos
	function eliminar_tildes($cadena){

		//Codificamos la cadena en formato utf8 en caso de que nos de errores
		//$cadena = utf8_encode($cadena);

		//Ahora reemplazamos las letras
		$cadena = str_replace(
			array('à', 'ä', 'â', 'ª', 'À', 'Â', 'Ä', 'Á'),
			array('a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
		);

		$cadena = str_replace(
			array('è', 'ë', 'ê', 'È', 'Ê', 'Ë', 'É'),
			array('e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );

		$cadena = str_replace(
			array('ì', 'ï', 'î', 'Ì', 'Ï', 'Î', '1', 'Í'),
			array('i', 'i', 'i', 'I', 'I', 'I', 'I', 'I'),
			$cadena );

		$cadena = str_replace(
			array('ò', 'ö', 'ô', 'Ò', 'Ö', 'Ô', '0', 'Ó'),
			array('o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
			$cadena );

		$cadena = str_replace(
			array('ù', 'ü', 'û', 'Ù', 'Û', 'Ü', 'Ú'),
			array('u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );

		$cadena = str_replace(
			array('    ', '|', '/', '*', '-', '+', '!', '¡', '"', '_', ',', '1', '=', '{', '}', '(', ')', '[', ']'),
			array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
			$cadena );

		return $cadena;
	}

	// tomo los datos del formulario anterior.

	$tipo_tramite = "CERTIFICADO DE PRIMARIA";
	$nombre_alumno = eliminar_tildes(mb_strtoupper($_POST['alumno']));
	$a_paterno = eliminar_tildes(mb_strtoupper($_POST['a_paterno']));
	$a_materno = eliminar_tildes(mb_strtoupper($_POST['a_materno']));
	$tel = $_POST['tel'];
	$curp = trim(strtoupper($_POST['curp']));
	$cct = strtoupper($_POST['cct']);
	$nombre_esc =  mb_strtoupper($_POST['escuela']);
	$dom_esc =  mb_strtoupper($_POST['dom_esc']);
	$turno = strtoupper($_POST['turno']);
	$ciclo_terminacion = ($_POST['terminacion']);
	$email = strtolower($_POST['email']);
	$usuario = "";
	$status = "";
	$foto = "";
	$fecha = date("d-m-Y");
	$fecha_elaborado = date("Y-m-d");
	$date = "";
	$al_id = $_POST['al_id'];
	$id = $_POST['id'];
	$year = date("Y");
	$core = $_POST['origen'];

	$nivel_busca = 'nivel';

	$status = "SOLICITADO";
	$longitud_curp = strlen($curp);
	//echo $longitud_curp;
	if ( $longitud_curp == '18' ) {	

		if (isset($_POST['core']) && $_POST['core'] == 'SI') {
			$check = "SI";
		}
		else {
			$check = "NO";
		}

		//OBTENEMOS SI EL TRÁMITE ES DE UNA ESCUELA DEL ESTADO Y SI ES EL NIVEL CORRECTO.
		$estado_cct = substr($cct, 0, 2);
		$nivel_cct = substr($cct, 2, 3);

		//VERIFICA ALUMNOS CERTIFICADOS EN ULTIMO CICLO (APLICA SOLO PARA LOS PRIMEROS 2 MESES POSTERIORES A LA CERTIFICACION)
		/*$verifica_certificado = $conexion->query("SELECT COUNT(*) AS CER FROM SCE039 WHERE al_curp = '$curp' AND nivel = 'PRI'");

		foreach($verifica_certificado as $muestra){
			$cert_existe = $muestra['CER'];
		}

		if ($cert_existe == 0) {*/

		//VALIDACIÓN PARA SABER SI EL TRÁMITE ES DEDL ESTADO Y DEL NIVEL CORRESPONDIENTE
		if ($estado_cct == 22 AND ($nivel_cct == 'DPR' OR $nivel_cct == 'PPR' OR $nivel_cct == 'DPB' OR $nivel_cct == 'DML' OR $nivel_cct == 'EPR' OR $nivel_cct == 'ADG' OR $nivel_cct == 'NBA')) {

			//Verificamos si el alumno se encuentra inscrito en el nivel que esta solicitando
			$si_existe = $conexion->query("SELECT dbo.SCE002.nivel FROM dbo.SCE002 INNER JOIN dbo.SCE006 ON dbo.SCE002.eg_id = dbo.SCE006.eg_id INNER JOIN dbo.SCE004 ON dbo.SCE006.al_id = dbo.SCE004.al_id WHERE (dbo.SCE004.al_curp = '$curp') AND (dbo.SCE004.al_estatus IN ('I', 'A'))");

			foreach($si_existe as $dat1){
				$nivel_busca = $dat1['nivel'];
			}

			if ($nivel_busca == 'PRI') {
				$val_tram = 6;
			}
			else {

				//verificamos si no existe ya un tramite en proceso para el mismo usuario
				$verifica_dupli = $conexion->query("SELECT COUNT(*) AS NUM FROM tramites1 WHERE curp = '$curp' AND tipo_tramite = '$tipo_tramite'");

				foreach($verifica_dupli as $ver){
					$num = $ver['NUM'];
				}

				if ($num == 0) {
					$val_tram = 0;
				}
				else {

					$verifica_estado = $conexion->query("SELECT COUNT(*) AS NUMERO FROM tramites1 WHERE curp = '$curp' AND tipo_tramite = '$tipo_tramite' AND (status = 'firmado' OR status = 'REIMPRESION')");

					foreach($verifica_estado as $est){
						$num2 = $est['NUMERO'];
					}

					if ($num2 == 0) {
						$val_tram = 1;
					}
					else {
						//$val_tram = 0;

						$dif_dias = $conexion->query("SELECT TOP (1) fecha_elaborado, entregado FROM tramites1 WHERE curp = '$curp' AND tipo_tramite = '$tipo_tramite' AND (status = 'firmado' OR status = 'REIMPRESION') ORDER BY fecha_elaborado DESC");

						foreach($dif_dias as $dia_dif){
							$fecha_ela = $dia_dif['fecha_elaborado'];
							$condicion = $dia_dif['entregado'];
						}

						$fecha1 = new DateTime($fecha_ela);
						$today = date("Y-m-d");  
						$fecha2= new DateTime($today);
						$diff = $fecha1->diff($fecha2);

						if (($condicion == "PAGADO" OR $condicion == "ENTREGADO") AND $diff->days >= 30) {
							$val_tram = 0;
						}
						elseif ($diff->days >= 366) {
							$val_tram = 0;
						}
						else {
							$val_tram = 1;
						}

					}

					
				}

					// Para la subida y nombramiento de la fotografia.

					/*$nombre_foto = $_FILES['foto']['name'];
					$archivo = $_FILES['foto']['tmp_name'];
					$ruta = "fotos";

					$ruta = $ruta . "/" . $nombre_foto;
					move_uploaded_file($archivo, $ruta);

					rename($ruta, 'fotos/'.$curp.'.jpg');*/

				if ($check == "SI") {

					//PARA VALIDAR SI YA SE SOLICITO ANTERIORMENTE UNA SOLICITUD CON CORRECCION
					$dif_dias_cor = $conexion->query("SELECT TOP (1) fecha FROM tramites1 WHERE curp = '$curp' AND tipo_tramite = '$tipo_tramite' AND correccion = 'SI' ORDER BY fecha DESC");

					foreach($dif_dias_cor as $dia_dif_cor){
						$fecha_ela_cor = $dia_dif_cor['fecha'];
					}

					if (isset($fecha_ela_cor)) {

						$fecha1 = new DateTime($fecha_ela_cor);
						$today = date("Y-m-d");  
						$fecha2= new DateTime($today);
						$diff_cor = $fecha1->diff($fecha2);

						if ($diff_cor->days >= 30) {
							$caso = 1;
						}
						else {
							$caso = 2;
						}
						
					}
					else {
						$caso = 1;
					}

					switch ($caso) {
						case 1:
				
							// Para asignar la solicitud a un compañero.

							$responsable = $conexion -> query("SELECT * FROM RESPONSABLES WHERE CLAVE = '$cct' AND NIVEL = 'PRI'");
							$respuesta = $responsable -> fetch();

							if ($respuesta !== false) {
									# code...

								$responsable = $conexion -> query("SELECT * FROM RESPONSABLES WHERE CLAVE = '$cct'");

								foreach($responsable as $fila){
									$usuario = rtrim($fila['RESPONSABLE']);
									$region = $fila['REGION'];
									$zona = $fila['ZONA'];
									$sector = $fila['SECTOR'];
								}

								// incrementar el folio.

								$folio="";
								$dato="";

								if ($region == 1) {
									
									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '1' ORDER BY folio DESC");

									foreach ($consulta as $dato) {
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-I-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-I-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

								} if ($region == 2) {
									
									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '2' ORDER BY folio DESC");

									foreach ($consulta as $dato) {
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-II-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-II-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

								} if ($region == 3) {
									
									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '3' ORDER BY folio DESC");

									foreach ($consulta as $dato) {
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-III-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-III-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

								} if ($region == 4) {
									
									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '4' ORDER BY folio DESC");

									foreach($consulta as $dato){
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-IV-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-IV-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

								}

								//insercion de datos si pertenece del 2000 en adelante (se puede asignar el responsable)

								if ($ciclo_terminacion == "2000-2001" or $ciclo_terminacion == "2001-2002" or $ciclo_terminacion == "2002-2003" or $ciclo_terminacion == "2003-2004" or $ciclo_terminacion == "2004-2005" or $ciclo_terminacion == "2005-2006" or $ciclo_terminacion == "2006-2007" or $ciclo_terminacion == "2007-2008" or $ciclo_terminacion == "2008-2009" or $ciclo_terminacion == "2009-2010" or $ciclo_terminacion == "2010-2011" or $ciclo_terminacion == "2011-2012" or $ciclo_terminacion == "2012-2013" or $ciclo_terminacion == "2013-2014" or $ciclo_terminacion == "2014-2015" or $ciclo_terminacion == "2015-2016" or $ciclo_terminacion == "2016-2017" or $ciclo_terminacion == "2017-2018" or $ciclo_terminacion == "2018-2019" or $ciclo_terminacion == "2019-2020" or $ciclo_terminacion == "2020-2021" or $ciclo_terminacion == "2021-2022" or $ciclo_terminacion == "2022-2023" or $ciclo_terminacion == "2023-2024" or $ciclo_terminacion == "2024-2025") {

									
									$statement = $conexion->prepare('INSERT INTO tramites1 (folio, nombre_alumno, a_paterno, a_materno, telefono, email, curp, cct, nombre_esc, dom_esc, turno, ciclo_terminacion, tipo_tramite, usuario, foto, zona, sector, fecha, status, region, correccion, core) VALUES (:folio, :nombre_alumno, :a_paterno, :a_materno, :telefono, :email, :curp, :cct, :nombre_esc, :dom_esc, :turno, :ciclo_terminacion, :tipo_tramite, :usuario, :foto, :zona, :sector, :fecha, :status, :region, :correccion, :core)');

									$statement->execute(array(":folio"=>$folio, ":nombre_alumno"=>$nombre_alumno, ":a_paterno"=>$a_paterno, ":a_materno"=>$a_materno, ":telefono"=>$tel, ":email"=>$email, ":curp"=>$curp, ":cct"=>$cct, ":nombre_esc"=>$nombre_esc, ":dom_esc"=>$dom_esc, ":turno"=>$turno, ":ciclo_terminacion"=>$ciclo_terminacion, ":tipo_tramite"=>$tipo_tramite, ":usuario"=>$usuario, ":foto"=>$foto, ":zona"=>$zona, ":sector"=>$sector, ":fecha"=>$fecha, ":status"=>$status, ":region"=>$region, ":correccion"=>$check, ":core"=>$core));
									$resultado = $statement -> fetch();

									//echo $resultado;

								} else {

									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '4' ORDER BY folio DESC");

									foreach($consulta as $dato){
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-IV-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-IV-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

									$region = "4";
									$zona = "";
									$sector = "";

									//insercion de datos si es de antes del 2000 (el responsable se asigna de forma manual)

									$statement = $conexion->prepare('INSERT INTO tramites1 (folio, nombre_alumno, a_paterno, a_materno, telefono, email, curp, cct, nombre_esc, dom_esc, turno, ciclo_terminacion, tipo_tramite, foto, zona, sector, fecha, status, region, correccion, core) VALUES (:folio, :nombre_alumno, :a_paterno, :a_materno, :telefono, :email, :curp, :cct, :nombre_esc, :dom_esc, :turno, :ciclo_terminacion, :tipo_tramite, :foto, :zona, :sector, :fecha, :status, :region, :correccion, :core)');

									$statement->execute(array(":folio"=>$folio, ":nombre_alumno"=>$nombre_alumno, ":a_paterno"=>$a_paterno, ":a_materno"=>$a_materno, ":telefono"=>$tel, ":email"=>$email, ":curp"=>$curp, ":cct"=>$cct, ":nombre_esc"=>$nombre_esc, ":dom_esc"=>$dom_esc, ":turno"=>$turno, ":ciclo_terminacion"=>$ciclo_terminacion, ":tipo_tramite"=>$tipo_tramite, ":foto"=>$foto, ":zona"=>$zona, ":sector"=>$sector, ":fecha"=>$fecha, ":status"=>'SOLICITADO SIN RESPONSABLE', ":region"=>$region, ":correccion"=>$check, ":core"=>$core));
									$resultado = $statement -> fetch();

								}

								$consulta = $conexion -> query("SELECT * FROM tramites1 WHERE (folio = '$folio' AND curp = '$curp')");

									foreach ($consulta as $dato) {
										$usuario = $dato['usuario'];
									}

								// jalar date a pdf.

							/*	$tiempo = $conexion -> query("SELECT * FROM tramites WHERE folio = '$folio'");

								foreach($tiempo as $filota){
									$date = $filota['fecha'];
								}*/

								//llenado de pdf.


							} else {
								$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '4' ORDER BY folio DESC");

									foreach($consulta as $dato){
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-IV-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-IV-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

									$region = "4";
									$zona = "";
									$sector = "";

									//insercion de datos si es de antes del 2000 (el responsable se asigna de forma manual)

									$statement = $conexion->prepare('INSERT INTO tramites1 (folio, nombre_alumno, a_paterno, a_materno, telefono, email, curp, cct, nombre_esc, dom_esc, turno, ciclo_terminacion, tipo_tramite, foto, zona, sector, fecha, status, region, correccion, core) VALUES (:folio, :nombre_alumno, :a_paterno, :a_materno, :telefono, :email, :curp, :cct, :nombre_esc, :dom_esc, :turno, :ciclo_terminacion, :tipo_tramite, :foto, :zona, :sector, :fecha, :status, :region, :correccion, :core)');

									$statement->execute(array(":folio"=>$folio, ":nombre_alumno"=>$nombre_alumno, ":a_paterno"=>$a_paterno, ":a_materno"=>$a_materno, ":telefono"=>$tel, ":email"=>$email, ":curp"=>$curp, ":cct"=>$cct, ":nombre_esc"=>$nombre_esc, ":dom_esc"=>$dom_esc, ":turno"=>$turno, ":ciclo_terminacion"=>$ciclo_terminacion, ":tipo_tramite"=>$tipo_tramite, ":foto"=>$foto, ":zona"=>$zona, ":sector"=>$sector, ":fecha"=>$fecha, ":status"=>'SOLICITADO SIN RESPONSABLE', ":region"=>$region, ":correccion"=>$check, ":core"=>$core));
									$resultado = $statement -> fetch();

								

								// jalar date a pdf.

							/*	$tiempo = $conexion -> query("SELECT * FROM tramites WHERE folio = '$folio'");

								foreach($tiempo as $filota){
									$date = $filota['fecha'];
								}*/

								//llenado de pdf.

								
							}

							$val_tram = 0;

							$mensaje = "La solicitud requiere de correción, favor de verificar el estatus de su solicitud";

							break;
						
						case 2:

							$val_tram = 1;

							$extrae = $conexion->query("SELECT TOP (1) folio FROM tramites1 WHERE curp = '$curp' AND tipo_tramite = '$tipo_tramite' ORDER BY folio DESC");

							foreach($extrae as $fol){
								$fold = $fol['folio'];
							}

							$mensaje = "Ya existe un trámite en proceso con los datos ingresados, el folio asignado es: <b>".$fold."</b>, consulta el estatus del trámite en la opción <b>'Estatus del Trámite'</b> con el folio asignado a tu solicitud.";
							
							break;
					}

				}
				if ($check == "NO") {

					$year_ini = substr($ciclo_terminacion, 0, 4);

					$dupli = $conexion->query("SELECT * FROM SCE039_DUPLI WHERE ce_inicic = '$year_ini' AND clavecct = '$cct' AND al_curp = '$curp'");
					$cuenta = $dupli->rowCount();

					if ($cuenta != 0 AND $val_tram == 0) {

						$val_tram = 2;

						//TOMAMOS ULTIMO FOLIO PARA ASIGNAR FOLIO A SOLICITUD
						$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '4' ORDER BY folio DESC");

						foreach($consulta as $dato){
							
						}

						if ($dato['folio'] == "") {
							$folio="2018-IV-00001";
						}

						$year_tram = substr($dato['folio'], 0, 4);

						if ($year_tram != $year) {
							$folio=$year."-IV-00001";
						}else{
							$folio = $dato['folio'];
							$folio++;
						}

						$region = "4";
						$zona = "";
						$sector = "";

						//insercion de datos a tramites1
						$statement = $conexion->prepare('INSERT INTO tramites1 (folio, nombre_alumno, a_paterno, a_materno, telefono, email, curp, cct, nombre_esc, dom_esc, turno, ciclo_terminacion, tipo_tramite, usuario, foto, zona, sector, fecha, fecha_elaborado, status, region, core) VALUES (:folio, :nombre_alumno, :a_paterno, :a_materno, :telefono, :email, :curp, :cct, :nombre_esc, :dom_esc, :turno, :ciclo_terminacion, :tipo_tramite, :usuario, :foto, :zona, :sector, :fecha, :fecha_elaborado, :status, :region, :core)');

						$statement->execute(array(":folio"=>$folio, ":nombre_alumno"=>$nombre_alumno, ":a_paterno"=>$a_paterno, ":a_materno"=>$a_materno, ":telefono"=>$tel, ":email"=>$email, ":curp"=>$curp, ":cct"=>$cct, ":nombre_esc"=>$nombre_esc, ":dom_esc"=>$dom_esc, ":turno"=>$turno, ":ciclo_terminacion"=>$ciclo_terminacion, ":tipo_tramite"=>$tipo_tramite, ":usuario"=>'SISCER', ":foto"=>$foto, ":zona"=>$zona, ":sector"=>$sector, ":fecha"=>$fecha, ":fecha_elaborado"=>$fecha_elaborado, ":status"=>'REIMPRESION', ":region"=>$region, ":core"=>$core));
						$resultado = $statement -> fetch();


						$mensaje = "La solicitud ya ha sido generada, favor de proceder con el pago del tramite.";

					}
					else {

						if ($val_tram == 0) {

							// Para asignar la solicitud a un compañero.

							$responsable = $conexion -> query("SELECT * FROM RESPONSABLES WHERE CLAVE = '$cct' AND NIVEL = 'PRI'");
							$respuesta = $responsable -> fetch();

							if ($respuesta !== false) {
									# code...

								$responsable = $conexion -> query("SELECT * FROM RESPONSABLES WHERE CLAVE = '$cct'");

								foreach($responsable as $fila){
									$usuario = rtrim($fila['RESPONSABLE']);
									$region = $fila['REGION'];
									$zona = $fila['ZONA'];
									$sector = $fila['SECTOR'];
								}

								// incrementar el folio.

								$folio="";
								$dato="";

								if ($region == 1) {
									
									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '1' ORDER BY folio DESC");

									foreach ($consulta as $dato) {
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-I-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-I-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

								} if ($region == 2) {
									
									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '2' ORDER BY folio DESC");

									foreach ($consulta as $dato) {
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-II-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-II-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

								} if ($region == 3) {
									
									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '3' ORDER BY folio DESC");

									foreach ($consulta as $dato) {
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-III-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-III-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

								} if ($region == 4) {
									
									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '4' ORDER BY folio DESC");

									foreach($consulta as $dato){
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-IV-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-IV-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

								}

								//insercion de datos si pertenece del 2000 en adelante (se puede asignar el responsable)

								if ($ciclo_terminacion == "2000-2001" or $ciclo_terminacion == "2001-2002" or $ciclo_terminacion == "2002-2003" or $ciclo_terminacion == "2003-2004" or $ciclo_terminacion == "2004-2005" or $ciclo_terminacion == "2005-2006" or $ciclo_terminacion == "2006-2007" or $ciclo_terminacion == "2007-2008" or $ciclo_terminacion == "2008-2009" or $ciclo_terminacion == "2009-2010" or $ciclo_terminacion == "2010-2011" or $ciclo_terminacion == "2011-2012" or $ciclo_terminacion == "2012-2013" or $ciclo_terminacion == "2013-2014" or $ciclo_terminacion == "2014-2015" or $ciclo_terminacion == "2015-2016" or $ciclo_terminacion == "2016-2017" or $ciclo_terminacion == "2017-2018" or $ciclo_terminacion == "2018-2019" or $ciclo_terminacion == "2019-2020" or $ciclo_terminacion == "2020-2021" or $ciclo_terminacion == "2021-2022" or $ciclo_terminacion == "2022-2023" or $ciclo_terminacion == "2023-2024" or $ciclo_terminacion == "2024-2025") {

									
									$statement = $conexion->prepare('INSERT INTO tramites1 (folio, nombre_alumno, a_paterno, a_materno, telefono, email, curp, cct, nombre_esc, dom_esc, turno, ciclo_terminacion, tipo_tramite, usuario, foto, zona, sector, fecha, status, region, correccion, core) VALUES (:folio, :nombre_alumno, :a_paterno, :a_materno, :telefono, :email, :curp, :cct, :nombre_esc, :dom_esc, :turno, :ciclo_terminacion, :tipo_tramite, :usuario, :foto, :zona, :sector, :fecha, :status, :region, :correccion, :core)');

									$statement->execute(array(":folio"=>$folio, ":nombre_alumno"=>$nombre_alumno, ":a_paterno"=>$a_paterno, ":a_materno"=>$a_materno, ":telefono"=>$tel, ":email"=>$email, ":curp"=>$curp, ":cct"=>$cct, ":nombre_esc"=>$nombre_esc, ":dom_esc"=>$dom_esc, ":turno"=>$turno, ":ciclo_terminacion"=>$ciclo_terminacion, ":tipo_tramite"=>$tipo_tramite, ":usuario"=>$usuario, ":foto"=>$foto, ":zona"=>$zona, ":sector"=>$sector, ":fecha"=>$fecha, ":status"=>$status, ":region"=>$region, ":correccion"=>$check, ":core"=>$core));
									$resultado = $statement -> fetch();

								} else {

									$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '4' ORDER BY folio DESC");

									foreach($consulta as $dato){
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-IV-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-IV-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

									$region = "4";
									$zona = "";
									$sector = "";

									//insercion de datos si es de antes del 2000 (el responsable se asigna de forma manual)

									$statement = $conexion->prepare('INSERT INTO tramites1 (folio, nombre_alumno, a_paterno, a_materno, telefono, email, curp, cct, nombre_esc, dom_esc, turno, ciclo_terminacion, tipo_tramite, foto, zona, sector, fecha, status, region, correccion, core) VALUES (:folio, :nombre_alumno, :a_paterno, :a_materno, :telefono, :email, :curp, :cct, :nombre_esc, :dom_esc, :turno, :ciclo_terminacion, :tipo_tramite, :foto, :zona, :sector, :fecha, :status, :region, :correccion, :core)');

									$statement->execute(array(":folio"=>$folio, ":nombre_alumno"=>$nombre_alumno, ":a_paterno"=>$a_paterno, ":a_materno"=>$a_materno, ":telefono"=>$tel, ":email"=>$email, ":curp"=>$curp, ":cct"=>$cct, ":nombre_esc"=>$nombre_esc, ":dom_esc"=>$dom_esc, ":turno"=>$turno, ":ciclo_terminacion"=>$ciclo_terminacion, ":tipo_tramite"=>$tipo_tramite, ":foto"=>$foto, ":zona"=>$zona, ":sector"=>$sector, ":fecha"=>$fecha, ":status"=>'SOLICITADO SIN RESPONSABLE', ":region"=>$region, ":correccion"=>$check, ":core"=>$core));
									$resultado = $statement -> fetch();

								}

								$consulta = $conexion -> query("SELECT * FROM tramites1 WHERE (folio = '$folio' AND curp = '$curp')");

									foreach ($consulta as $dato) {
										$usuario = $dato['usuario'];
										$identificador = $dato['id'];
									}

								//Si el documento es de un ciclo electronico generamos el certificado del documento
								if ($ciclo_terminacion == "2014-2015" or $ciclo_terminacion == "2015-2016" or $ciclo_terminacion == "2016-2017" or $ciclo_terminacion == "2017-2018" or $ciclo_terminacion == "2018-2019" or $ciclo_terminacion == "2019-2020" or $ciclo_terminacion == "2020-2021" or $ciclo_terminacion == "2021-2022" or $ciclo_terminacion == "2022-2023" or $ciclo_terminacion == "2023-2024" or $ciclo_terminacion == "2024-2025") {
									
									if ($ciclo_terminacion == '2014-2015') {

										$escolar = $conexion->query("SELECT * FROM SCE039_1415 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];

											if ($nivel_educ == "Preescolar") {
												$f_expedicion = "2015-07-01";
											}
											else {
												$f_expedicion = $cert['cr_fecha'];
											}
											
											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2015-2016') {

										$escolar = $conexion->query("SELECT * FROM SCE039_1516 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];

											if ($nivel_educ == "Preescolar") {
												$f_expedicion = "2016-07-01";
											}
											else {
												$f_expedicion = $cert['cr_fecha'];
											}

											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2016-2017') {

										$escolar = $conexion->query("SELECT * FROM SCE039_1617 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];
											
											if ($nivel_educ == "Preescolar") {
												$f_expedicion = "2017-07-01";
											}
											else {
												$f_expedicion = $cert['cr_fecha'];
											}

											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2017-2018') {

										$escolar = $conexion->query("SELECT * FROM SCE039_1718 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];
											
											if ($nivel_educ == "Preescolar") {
												$f_expedicion = "2018-07-01";
											}
											else {
												$f_expedicion = $cert['cr_fecha'];
											}

											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2018-2019') {

										$escolar = $conexion->query("SELECT * FROM SCE039_1819 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];
											$f_expedicion = $cert['cr_fecha'];
											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2019-2020') {

										$escolar = $conexion->query("SELECT * FROM SCE039_1920 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];
											$f_expedicion = $cert['cr_fecha'];
											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2020-2021') {

										$escolar = $conexion->query("SELECT * FROM SCE039_2021 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];
											$f_expedicion = $cert['cr_fecha'];
											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2021-2022') {

										$escolar = $conexion->query("SELECT * FROM SCE039_2122 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];
											$f_expedicion = $cert['cr_fecha'];
											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2022-2023') {

										$escolar = $conexion->query("SELECT * FROM SCE039_2223 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];
											$f_expedicion = $cert['cr_fecha'];
											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2023-2024') {

										$escolar = $conexion->query("SELECT * FROM SCE039_2324 WHERE (al_curp = '$curp' AND cr_descrip = 'FIRMADO')");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];
											$f_expedicion = $cert['cr_fecha'];
											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									elseif ($ciclo_terminacion == '2024-2025') {

										$escolar = $conexion->query("SELECT * FROM SCE039_2425 WHERE (al_curp = '$curp' AND IdEstatus = 4)");

										$totalFilas = $escolar->rowCount();  

										foreach($escolar as $cert){

											if ($totalFilas !== 0) {

											$promedio = $cert['cr_prom'];
											$prom_letra = rtrim($cert['cr_promLetr']);
											$grado = $cert['eg_grado'];
											$grupo = $cert['eg_grupo'];
											$a_paterno = rtrim($cert['al_appat']);
											$a_materno = rtrim($cert['al_apmat']);
											$nombre_alumno = rtrim($cert['al_nombre']);
											$cct = rtrim($cert['clavecct']);
											$nombre_esc = rtrim($cert['nombrect']);
											$turno = $cert['turno'];
											$cr_id = $cert['cr_id'];
											$cr_folioRodac = $cert['cr_folioRodac'];
											$f_expedicion = $cert['cr_fecha'];
											$al_id = $cert['al_id'];

											$f_expedicion = date("Y-m-d", strtotime($f_expedicion)); 


											}

										}
									}

									//Validamos que se encuentren los datos del estudiante
									if (isset($promedio)) {

										$respuesta1 = "Si se encontro el documento";

										//pasamos las variables a la funcion.
										$expedicion = "Querétaro";
										$municipio = "Querétaro";
										$nivel_esc = "Primaria";
										$letra = "";
										$observaciones = "";
										//$identificador = "";//aqui tenemos que mandar el id del registro que se guarde en base de datos
										

										$fecha_actual = date("Y-m-d");
										$hora_actual = date("G:i:s");

										//convertimos hora y fecha a formato DateTime

										$d = new DateTime($fecha_actual."T".$hora_actual);
										$e = $d->format('Y-m-d\TH:i:s');


										//generar idMunicipio
										if ($municipio == "Querétaro") {
											$idMunicipio = "014";
										}
										if ($municipio == "San Juan del Río") {
											$idMunicipio = "016";
										}
										if ($municipio == "Cadereyta de Montes") {
											$idMunicipio = "004";
										}
										if ($municipio == "Jalpan de Serra") {
											$idMunicipio = "009";
										}

										// generar idTipoCertificacion
										if ($nivel_esc == "Preescolar") {
											$idTipoCertificacion = 4;
											// variable que ocupamos para agregarlo al nombre del XML
											$n_escolar = "PRE";
										}
										if ($nivel_esc == "Primaria") {
											$idTipoCertificacion = 1;
											// variable que ocupamos para agregarlo al nombre del XML
											$n_escolar = "PRI";
										}
										if ($nivel_esc == "Secundaria") {
											$idTipoCertificacion = 2;
											// variable que ocupamos para agregarlo al nombre del XML
											$n_escolar = "SEC";
										}

										if ($n_escolar != 'PRE') {

											$promedio = $promedio;
											$prom_letra = $prom_letra;

										}
										else {

											$promedio = "C";
											$prom_letra = "Certificado";

										}

										if ($promedio == '10.0') {
											$promedio = 10;
											$prom_letra = "DIEZ";
										}

										/* --- GENERACION DE TIMBRADO FEDERAL, SE PREPARARÁ MEDIANTE API --- */

								}


							} else {
								$consulta = $conexion -> query("SELECT TOP 1 * FROM tramites1 WHERE region = '4' ORDER BY folio DESC");

									foreach($consulta as $dato){
									
									}

									if ($dato['folio'] == "") {
										$folio="2018-IV-00001";
									}

									$year_tram = substr($dato['folio'], 0, 4);

									if ($year_tram != $year) {
										$folio=$year."-IV-00001";
									}else{
										$folio = $dato['folio'];
										$folio++;
									}

									$region = "4";
									$zona = "";
									$sector = "";

									//insercion de datos si es de antes del 2000 (el responsable se asigna de forma manual)

									$statement = $conexion->prepare('INSERT INTO tramites1 (folio, nombre_alumno, a_paterno, a_materno, telefono, email, curp, cct, nombre_esc, dom_esc, turno, ciclo_terminacion, tipo_tramite, foto, zona, sector, fecha, status, region, correccion, core) VALUES (:folio, :nombre_alumno, :a_paterno, :a_materno, :telefono, :email, :curp, :cct, :nombre_esc, :dom_esc, :turno, :ciclo_terminacion, :tipo_tramite, :foto, :zona, :sector, :fecha, :status, :region, :correccion, :core)');

									$statement->execute(array(":folio"=>$folio, ":nombre_alumno"=>$nombre_alumno, ":a_paterno"=>$a_paterno, ":a_materno"=>$a_materno, ":telefono"=>$tel, ":email"=>$email, ":curp"=>$curp, ":cct"=>$cct, ":nombre_esc"=>$nombre_esc, ":dom_esc"=>$dom_esc, ":turno"=>$turno, ":ciclo_terminacion"=>$ciclo_terminacion, ":tipo_tramite"=>$tipo_tramite, ":foto"=>$foto, ":zona"=>$zona, ":sector"=>$sector, ":fecha"=>$fecha, ":status"=>'SOLICITADO SIN RESPONSABLE', ":region"=>$region, ":correccion"=>$check, ":core"=>$core));
									$resultado = $statement -> fetch();

								

								// jalar date a pdf.

							/*	$tiempo = $conexion -> query("SELECT * FROM tramites WHERE folio = '$folio'");

								foreach($tiempo as $filota){
									$date = $filota['fecha'];
								}*/

								//llenado de pdf.

								
							}

							$mensaje = "La solicitud esta en proceso de validación y elaboración, favor de consultar el estatus de su trámite.";

						}
						if ($val_tram == 1) {

							$extrae = $conexion->query("SELECT TOP (1) folio FROM tramites1 WHERE curp = '$curp' AND tipo_tramite = '$tipo_tramite' ORDER BY folio DESC");

							foreach($extrae as $fol){
								$fold = $fol['folio'];
							}
							
							$mensaje = "Ya existe un trámite en proceso con los datos ingresados, el folio asignado es: <b>".$fold."</b>, consulta el estatus del trámite en la opción <b>'Estatus del Trámite'</b> con el folio asignado a tu solicitud.";

						}

					}

				}

			}

		}
		else {

			if ($estado_cct == 22) {
				$val_tram = 8;
			}
			else {
				$val_tram = 7;
			}

		}
	}
	else{
		$val_tram = 9;
		$mensaje = "La CURP que ingresa no cuenta con los 18 dígitos, favor de realizar nuevamente su tramite con la corrección.";

	}
	//VERIFICA ALUMNOS CERTIFICADOS EN ULTIMO CICLO (APLICA SOLO PARA LOS PRIMEROS 2 MESES POSTERIORES A LA CERTIFICACION)
	/*}else {

		$val_tram = 5;

	}*/

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
        <img src="assets/img/brand/USEBEQN.png" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
                <img alt="Image placeholder" width="180" src="./assets/img/brand/USEBEQN.png">
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
                <img src="./assets/img/brand/USEBEQN.png">
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
        <a class="h2 mb-0 text-gray text-uppercase d-none d-lg-inline-block" href="panel.php">
          <!--<img src="assets/img/brand/USEBEQ2.png" width="50" class="navbar-brand-img" alt="...">-->
          &nbsp;SISCER
        </a>
        <!-- Form -->
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="">
                  <img alt="Image placeholder" width="180" src="./assets/img/brand/USEBEQN.png">
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
                  <h3 class="mb-0">Duplicado de Certificados en Linea</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">
                    
                  </div>

                  <div class="row">

                  	<?php if ($val_tram == 1) { ?>

                  		<div class="row col-12 text-center">
							<label><?php echo $mensaje ?></label>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="duplicados.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>	

					<?php } if ($val_tram == 5) { ?>

                  		<div class="row col-12 justify-content-center">
							<h4 align="center" class="">El alumno (a) egresó de PRIMARIA en el ciclo escolar 2022 - 2023 por lo tanto para consulta y descarga de sus documentos de acreditación ingrese a: <a href="http://portal.usebeq.edu.mx">portal.usebeq.edu.mx</a></h4>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="duplicados.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } if ($val_tram == 6) { ?>

                  		<div class="row col-12 justify-content-center">
							<h4 align="center" class="">El alumno (a) se encuentra inscrito en PRIMARIA, para consulta y descarga de boletas de evaluación ingrese a: <a href="http://portal.usebeq.edu.mx">portal.usebeq.edu.mx</a></h4>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="duplicados.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } if ($val_tram == 0) { ?>

	                  	<div class="row col-12 justify-content-center">
							<label><?php echo $mensaje ?></label>
						</div>	

						<div class="row col-12 justify-content-center">
							<label><b>Folio: <?php echo $folio ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Nombre de solicitante: <?php echo $nombre_alumno." ".$a_paterno." ".$a_materno ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Trámite realizado: <?php echo $tipo_tramite ?></b></label>
							<br><br>
						</div>		

						<div class="col-lg-12 form-group text-center">

						<form action="imprime_folio.php" method="post" enctype=" ">
	                    <input type="hidden" name="folio" value="<?php echo $folio ?>">
						<input type="hidden" name="curp" value="<?php echo $curp ?>">
	                    <button type="submit" class="btn btn-info">Imprimir Solicitud</button>
						</form>

						</div>

					<?php } if ($val_tram == 2) { ?>

	                  	<div class="row col-12 justify-content-center">
							<label><?php echo $mensaje ?></label>
						</div>	

						<div class="row col-12 justify-content-center">
							<label><b>Folio: <?php echo $folio ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Nombre de solicitante: <?php echo $nombre_alumno." ".$a_paterno." ".$a_materno ?></b></label>
						</div>

						<div class="row col-12 justify-content-center">
							<label><b>Trámite realizado: <?php echo $tipo_tramite ?></b></label>
							<br><br>
						</div>		

	                  	<div class="col-lg-6 form-group text-lg-right text-md-center text-center">

	                  	<form action="imprime_folio.php" method="post" enctype=" ">
							<input type="hidden" name="folio" value="<?php echo $folio ?>">
						  	<input type="hidden" name="curp" value="<?php echo $curp ?>">
							<button type="submit" class="btn btn-info">Imprimir Solicitud</button>
		                   
						</form>

						</div>

						<div class="col-lg-6 form-group text-lg-left text-md-center text-center">

						<form action="https://reger.usebeq.edu.mx/PortalServicios/externalGuest.jsp" method="post">
	                  		<button type="submit" class="btn btn-info">Pago en Linea</button>
		                  	<input type="hidden" name="system" value="SISCER">
							<input type="hidden" name="systemToken" value="6DFC9F2EE4829768">
							<input type="hidden" name="externalProcessID" value="<?php echo $folio ?>">
							<input type="hidden" name="tid" value="30">
							<input type="hidden" name="nombre" value="<?php echo $nombre_alumno ?>">
							<input type="hidden" name="primerApellido" value="<?php echo $a_paterno ?>">
							<input type="hidden" name="segundoApellido" value="<?php echo $a_materno ?>">
							<input type="hidden" name="correo" value="<?php echo $email ?>">
							<input type="hidden" name="comentarios" value="PASE DE CAJA DESDE SISCER">
							<input type="hidden" name="successPage" value="http://portal.usebeq.edu.mx:8080/portal/portal/duplicados.php?al_id=<?php echo $al_id ?>&id=<?php echo $id ?>">
							<input type="hidden" name="errorPage" value="http://portal.usebeq.edu.mx:8080/portal/portal/duplicados.php?al_id=<?php echo $al_id ?>&id=<?php echo $id ?>">
							<input type="hidden" name="ventanilla" value="N">
							<input type="hidden" name="usuarioREGER" value="portal">
						</form>

						</div>
						
					<?php } if ($val_tram == 7) {  ?>

						<div class="row col-12 justify-content-center">
							<h4 align="center" class="">La clave de la escuela ingresada no corresponde a un centro educativo del estado de Querétaro, para solicitar un duplicado de certificado favor de ponerse en contacto con la dependencia correspondiente en el estado donde finalizo sus estudios.</h4>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="duplicados.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } if ($val_tram == 8) { ?>

						<div class="row col-12 justify-content-center">
							<h4 align="center" class="">La clave de la escuela ingresada no corresponde a PRIMARIA, favor de seleccionar el nivel correcto del trámite a realizar en el menú de solicitud de duplicados de certificado.</a></h4>
							<br>
						</div>

						<div class="col-lg-12 form-group text-center">

						<form action="duplicados.php" method="post" enctype=" ">
							<button type="submit" class="btn btn-info">Aceptar</button>
						</form>

						</div>

					<?php } if ($val_tram == 9) { ?>
							<div class="row col-12 justify-content-center">
								<label><?php echo $mensaje ?></label>
								<br>
							</div>

							<div class="col-lg-12 form-group text-center">

							<form action="duplicados.php" method="post" enctype=" ">
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
              &copy; 2024 <a href="https://www.usebeq.edu.mx/PaginaWEB/" class="font-weight-bold ml-1" target="_blank">USEBEQ</a>
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

  $verifica_dupli = null;
  $responsable = null;
  $consulta = null;
  $statement = null;
  $extrae = null;
  $dupli = null;
  $conexion = null;

?>