<?php session_start();

  require("../conexion.php");

  if (isset($_SESSION['correo'])) {
   
  }
  else{
    header('Location: ../login/login.php');
  }

  $curp = strtoupper(trim($_POST['curp']));
  $apellido = mb_strtoupper(trim($_POST['apellido']));
  $cct = strtoupper(trim($_POST['cct']));
  //$grado = trim($_POST['grado']);
  $grupo = strtoupper(trim($_POST['grupo']));
  //$folio = trim($_POST['folio']);
  $correo = $_POST['correo'];
  $parentesco = $_POST['parentesco'];

  function eliminar_tildes($cadena){

    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    //$cadena = utf8_encode($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    return $cadena;
}

  $apellido = eliminar_tildes($apellido);

  //obtenemos el id del folio y verificamos si este existe

  /*$cad = substr($folio, -7, 7);
  $cad2 = substr($cad, -6, 6);
  $cad_ex = substr($cad, 0, 1);

  if ($cad_ex == 0) {
  	$id = $cad2;
  }
  else {
  	$id = $cad;
  }*/

  $verifica = $conexion->query("SELECT al_id FROM pp_alumnos WHERE al_curp = '$curp'");
  $cuenta = $verifica->rowCount();

  if ($cuenta == 0) {

  	//Consulta considerando el grupo
  	/*$consulta = $conexion->query("SELECT dbo.SCE004.al_curp, dbo.SCE004.al_appat, dbo.SCE004.al_apmat, dbo.SCE004.al_nombre, dbo.SCE004.al_id, dbo.SCE002.eg_grado, dbo.SCE002.clavecct, dbo.SCE002.eg_grupo
								FROM dbo.SCE002 INNER JOIN
                         			dbo.SCE006 ON dbo.SCE002.eg_id = dbo.SCE006.eg_id INNER JOIN
                         			dbo.SCE004 ON dbo.SCE006.al_id = dbo.SCE004.al_id
								WHERE dbo.SCE004.al_curp = '$curp' AND dbo.SCE004.al_appat = '$apellido' AND dbo.SCE002.eg_grado = '$grado' AND dbo.SCE002.clavecct = '$cct' AND dbo.SCE002.eg_grupo = '$grupo' AND (dbo.SCE004.al_estatus = 'I')
								GROUP BY dbo.SCE004.al_curp, dbo.SCE004.al_appat, dbo.SCE004.al_apmat, dbo.SCE004.al_nombre, dbo.SCE004.al_id, dbo.SCE002.eg_grado, dbo.SCE002.clavecct, dbo.SCE002.eg_grupo");*/

  	$consulta = $conexion->query("SELECT dbo.SCE004.al_curp, dbo.SCE004.al_appat, dbo.SCE004.al_apmat, dbo.SCE004.al_nombre, dbo.SCE004.al_id, dbo.SCE002.eg_grado, dbo.SCE002.clavecct, dbo.SCE002.eg_grupo
								FROM dbo.SCE002 INNER JOIN
                         			dbo.SCE006 ON dbo.SCE002.eg_id = dbo.SCE006.eg_id INNER JOIN
                         			dbo.SCE004 ON dbo.SCE006.al_id = dbo.SCE004.al_id
								WHERE dbo.SCE004.al_curp = '$curp' AND dbo.SCE004.al_appat = '$apellido' AND dbo.SCE002.clavecct = '$cct' AND dbo.SCE002.eg_grupo = '$grupo' AND (dbo.SCE004.al_estatus = 'I' OR dbo.SCE004.al_estatus = 'A' OR dbo.SCE004.al_estatus = 'E' OR dbo.SCE004.al_estatus = 'B')
								GROUP BY dbo.SCE004.al_curp, dbo.SCE004.al_appat, dbo.SCE004.al_apmat, dbo.SCE004.al_nombre, dbo.SCE004.al_id, dbo.SCE002.eg_grado, dbo.SCE002.clavecct, dbo.SCE002.eg_grupo");

	  $conteo = $consulta->rowCount();

	  if ($conteo != 0) {
	  	$mensaje = "Estudiante agregado correctamente.";

	  	foreach ($consulta as $fila) {
	  		$al_apmat = $fila['al_apmat'];
	  		$al_nombre = $fila['al_nombre'];
	  		$al_cct = $fila['clavecct'];
	  		$al_grado = $fila['eg_grado'];
	  		$al_grupo = $fila['eg_grupo'];
	  		$id = $fila['al_id'];
	  	}

	  	//validaremos a los hermanos

		  $month = date("m");
		  $year = date("Y");

		  if ($month == "01" OR $month == "02" OR $month == "03" OR $month == "04" OR $month == "05" OR $month == "06" OR $month == "07") {
		    $year-1;
		  }

		  $alum = $conexion->query("SELECT al_id, al_appat, al_apmat, al_nombre, al_curp FROM pp_alumnos WHERE (padre = '$correo' OR madre = '$correo' OR tutor = '$correo')");

		  while ($res = $alum -> fetch()) {

		  	$al_id_compara = $res['al_id'];
		  	$appat_compara = $res['al_appat'];
		  	$apmat_compara = $res['al_apmat'];
		  	$al_nombre_compara = $res['al_nombre'];
		  	$al_curp_compara = $res['al_curp'];

		  	$al_comp = $conexion->query("SELECT dbo.SCE004.al_curp, dbo.SCE004.al_appat, dbo.SCE004.al_apmat, dbo.SCE004.al_nombre, dbo.SCE004.al_id, dbo.SCE004.al_fecnac, dbo.SCE006.eg_id, dbo.SCE002.eg_grado, dbo.SCE002.eg_grupo, dbo.SCE002.clavecct, 
		                         dbo.SCE002.nombrect
										FROM dbo.SCE002 INNER JOIN
		                         			dbo.SCE006 ON dbo.SCE002.eg_id = dbo.SCE006.eg_id INNER JOIN
		                         			dbo.SCE004 ON dbo.SCE006.al_id = dbo.SCE004.al_id
										WHERE (dbo.SCE004.al_id = '$al_id_compara') AND (dbo.SCE002.ce_inicic = '$year')");

		  	foreach ($al_comp as $comp) {
		  		$al_cct_compara = $comp['clavecct'];
		  		$al_grado_compara = $comp['eg_grado'];
		  		$al_grupo_compara = $comp['eg_grupo'];
		  	}

		  	if ($apellido == $appat_compara AND $al_apmat == $apmat_compara) {
		  		
		  		$ycurp = substr($curp, 4, 2);
		  		$ycurp_compara = substr($al_curp_compara, 4, 2);

		  		if ($ycurp < $ycurp_compara) {

		  			$search = $conexion->query("SELECT h_id FROM pp_hermanos WHERE al_id = '$id' AND her_id = '$al_id_compara'");
		  			$numero = $search->rowCount();

		  			if ($numero == 0) {
		  				
		  				$lanza = $conexion->prepare('INSERT INTO pp_hermanos (al_id, al_curp, al_nombre, al_appat, al_apmat, al_cct, al_grado, al_grupo, her_curp, her_nombre, her_appat, her_apmat, her_cct, her_grado, her_grupo, her_id) VALUES (:al_id, :al_curp, :al_nombre, :al_appat, :al_apmat, :al_cct, :al_grado, :al_grupo, :her_curp, :her_nombre, :her_appat, :her_apmat, :her_cct, :her_grado, :her_grupo, :her_id)');

						$lanza->execute(array(":al_id"=>$id, ":al_curp"=>$curp, ":al_nombre"=>$al_nombre, ":al_appat"=>$apellido, ":al_apmat"=>$al_apmat, ":al_cct"=>$al_cct, ":al_grado"=>$al_grado, ":al_grupo"=>$al_grupo, ":her_curp"=>$al_curp_compara, ":her_nombre"=>$al_nombre_compara, ":her_appat"=>$appat_compara, ":her_apmat"=>$apmat_compara, ":her_cct"=>$al_cct_compara, ":her_grado"=>$al_grado_compara, ":her_grupo"=>$al_grupo_compara, ":her_id"=>$al_id_compara));

		  			}
		  			
		  		}
		  		if ($ycurp_compara < $ycurp) {

		  			$search = $conexion->query("SELECT h_id FROM pp_hermanos WHERE al_id = '$al_id_compara' AND her_id = '$id'");
		  			$numero = $search->rowCount();

		  			if ($numero == 0) {
		  				
		  				$lanza = $conexion->prepare('INSERT INTO pp_hermanos (al_id, al_curp, al_nombre, al_appat, al_apmat, al_cct, al_grado, al_grupo, her_curp, her_nombre, her_appat, her_apmat, her_cct, her_grado, her_grupo, her_id) VALUES (:al_id, :al_curp, :al_nombre, :al_appat, :al_apmat, :al_cct, :al_grado, :al_grupo, :her_curp, :her_nombre, :her_appat, :her_apmat, :her_cct, :her_grado, :her_grupo, :her_id)');

						$lanza->execute(array(":al_id"=>$al_id_compara, ":al_curp"=>$al_curp_compara, ":al_nombre"=>$al_nombre_compara, ":al_appat"=>$appat_compara, ":al_apmat"=>$apmat_compara, ":al_cct"=>$al_cct_compara, ":al_grado"=>$al_grado_compara, ":al_grupo"=>$al_grupo_compara, ":her_curp"=>$curp, ":her_nombre"=>$al_nombre, ":her_appat"=>$apellido, ":her_apmat"=>$al_apmat, ":her_cct"=>$al_cct, ":her_grado"=>$al_grado, ":her_grupo"=>$al_grupo, ":her_id"=>$id));

		  			}

		  		}


		  	}



		  }
		//termina validacion de hermanos

	  	$fecha = date("d-m-Y");

	  	if ($parentesco == "PADRE") {
	  		
	  		$agrega = $conexion->prepare('INSERT INTO pp_alumnos (al_curp, al_appat, al_apmat, al_nombre, al_id, fecha_alta, estatus, padre) VALUES (:al_curp, :al_appat, :al_apmat, :al_nombre, :al_id, :fecha_alta, :estatus, :padre)');

			$agrega->execute(array(":al_curp"=>$curp, ":al_appat"=>$apellido, ":al_apmat"=>$al_apmat, ":al_nombre"=>$al_nombre, ":al_id"=>$id, ":fecha_alta"=>$fecha, ":estatus"=>'A', ":padre"=>$correo));

	  	}
	  	if ($parentesco == "MADRE") {
	  		
	  		$agrega = $conexion->prepare('INSERT INTO pp_alumnos (al_curp, al_appat, al_apmat, al_nombre, al_id, fecha_alta, estatus, madre) VALUES (:al_curp, :al_appat, :al_apmat, :al_nombre, :al_id, :fecha_alta, :estatus, :madre)');

			$agrega->execute(array(":al_curp"=>$curp, ":al_appat"=>$apellido, ":al_apmat"=>$al_apmat, ":al_nombre"=>$al_nombre, ":al_id"=>$id, ":fecha_alta"=>$fecha, ":estatus"=>'A', ":madre"=>$correo));

	  	}
	  	if ($parentesco == "TUTOR") {
	  		
	  		$agrega = $conexion->prepare('INSERT INTO pp_alumnos (al_curp, al_appat, al_apmat, al_nombre, al_id, fecha_alta, estatus, tutor) VALUES (:al_curp, :al_appat, :al_apmat, :al_nombre, :al_id, :fecha_alta, :estatus, :tutor)');

			$agrega->execute(array(":al_curp"=>$curp, ":al_appat"=>$apellido, ":al_apmat"=>$al_apmat, ":al_nombre"=>$al_nombre, ":al_id"=>$id, ":fecha_alta"=>$fecha, ":estatus"=>'A', ":tutor"=>$correo));

	  	}

	  	

	  }
	  else {
	  	$mensaje = "No se encuentra al estudiante.<br>Intente nuevamente.";
	  }
  	
  }
  if ($cuenta != 0) {
   	
   	$consulta = $conexion->query("SELECT dbo.SCE004.al_curp, dbo.SCE004.al_appat, dbo.SCE004.al_apmat, dbo.SCE004.al_nombre, dbo.SCE004.al_id, dbo.SCE002.eg_grado, dbo.SCE002.clavecct, dbo.SCE002.eg_grupo
								FROM dbo.SCE002 INNER JOIN
                         			dbo.SCE006 ON dbo.SCE002.eg_id = dbo.SCE006.eg_id INNER JOIN
                         			dbo.SCE004 ON dbo.SCE006.al_id = dbo.SCE004.al_id
								WHERE dbo.SCE004.al_curp = '$curp' AND dbo.SCE004.al_appat = '$apellido' AND dbo.SCE002.clavecct = '$cct' AND dbo.SCE002.eg_grupo = '$grupo' AND (dbo.SCE004.al_estatus = 'I' OR dbo.SCE004.al_estatus = 'A' OR dbo.SCE004.al_estatus = 'E' OR dbo.SCE004.al_estatus = 'B')
								GROUP BY dbo.SCE004.al_curp, dbo.SCE004.al_appat, dbo.SCE004.al_apmat, dbo.SCE004.al_nombre, dbo.SCE004.al_id, dbo.SCE002.eg_grado, dbo.SCE002.clavecct, dbo.SCE002.eg_grupo");

	  $conteo = $consulta->rowCount();

	  if ($conteo != 0) {
	  	$mensaje = "Estudiante agregado correctamente.";

	  	$verifica1 = $conexion->query("SELECT id_sis, padre, madre, tutor FROM pp_alumnos WHERE al_curp = '$curp'");

	  	foreach ($verifica1 as $dat) {
	  		$id_sis = $dat['id_sis'];
	  		$padre = $dat['padre'];
	  		$madre = $dat['madre'];
	  		$tutor = $dat['tutor'];
	  	}

	  	//validaremos a los hermanos

		  $month = date("m");
		  $year = date("Y");

		  if ($month == "01" OR $month == "02" OR $month == "03" OR $month == "04" OR $month == "05" OR $month == "06" OR $month == "07") {
		    $year-1;
		  }

		  echo $year;

		  $alum = $conexion->query("SELECT al_id, al_appat, al_apmat, al_nombre, al_curp FROM pp_alumnos WHERE (padre = '$correo' OR madre = '$correo' OR tutor = '$correo')");

		  while ($res = $alum -> fetch()) {

		  	$al_id_compara = $res['al_id'];
		  	$appat_compara = $res['al_appat'];
		  	$apmat_compara = $res['al_apmat'];
		  	$al_nombre_compara = $res['al_nombre'];
		  	$al_curp_compara = $res['al_curp'];

		  	$al_comp = $conexion->query("SELECT dbo.SCE004.al_curp, dbo.SCE004.al_appat, dbo.SCE004.al_apmat, dbo.SCE004.al_nombre, dbo.SCE004.al_id, dbo.SCE004.al_fecnac, dbo.SCE006.eg_id, dbo.SCE002.eg_grado, dbo.SCE002.eg_grupo, dbo.SCE002.clavecct, 
		                         dbo.SCE002.nombrect
										FROM dbo.SCE002 INNER JOIN
		                         			dbo.SCE006 ON dbo.SCE002.eg_id = dbo.SCE006.eg_id INNER JOIN
		                         			dbo.SCE004 ON dbo.SCE006.al_id = dbo.SCE004.al_id
										WHERE (dbo.SCE004.al_id = '$al_id_compara') AND (dbo.SCE002.ce_inicic = '$year')");

		  	foreach ($al_comp as $comp) {
		  		$al_apmat = $comp['al_apmat'];
		  		$al_cct_compara = $comp['clavecct'];
		  		$al_grado_compara = $comp['eg_grado'];
		  		$al_grupo_compara = $comp['eg_grupo'];
		  	}

		  	if ($apellido == $appat_compara AND $al_apmat == $apmat_compara) {
		  		
		  		$ycurp = substr($curp, 4, 2);
		  		$ycurp_compara = substr($al_curp_compara, 4, 2);

		  		if ($ycurp < $ycurp_compara) {

		  			$search = $conexion->query("SELECT h_id FROM pp_hermanos WHERE al_id = '$id' AND her_id = '$al_id_compara'");
		  			$numero = $search->rowCount();

		  			if ($numero == 0) {
		  				
		  				$lanza = $conexion->prepare('INSERT INTO pp_hermanos (al_id, al_curp, al_nombre, al_appat, al_apmat, al_cct, al_grado, al_grupo, her_curp, her_nombre, her_appat, her_apmat, her_cct, her_grado, her_grupo, her_id) VALUES (:al_id, :al_curp, :al_nombre, :al_appat, :al_apmat, :al_cct, :al_grado, :al_grupo, :her_curp, :her_nombre, :her_appat, :her_apmat, :her_cct, :her_grado, :her_grupo, :her_id)');

						$lanza->execute(array(":al_id"=>$id, ":al_curp"=>$curp, ":al_nombre"=>$al_nombre, ":al_appat"=>$apellido, ":al_apmat"=>$al_apmat, ":al_cct"=>$al_cct, ":al_grado"=>$al_grado, ":al_grupo"=>$al_grupo, ":her_curp"=>$al_curp_compara, ":her_nombre"=>$al_nombre_compara, ":her_appat"=>$appat_compara, ":her_apmat"=>$apmat_compara, ":her_cct"=>$al_cct_compara, ":her_grado"=>$al_grado_compara, ":her_grupo"=>$al_grupo_compara, ":her_id"=>$al_id_compara));

		  			}
		  			
		  		}
		  		if ($ycurp_compara < $ycurp) {

		  			$search = $conexion->query("SELECT h_id FROM pp_hermanos WHERE al_id = '$al_id_compara' AND her_id = '$id'");
		  			$numero = $search->rowCount();

		  			if ($numero == 0) {
		  				
		  				$lanza = $conexion->prepare('INSERT INTO pp_hermanos (al_id, al_curp, al_nombre, al_appat, al_apmat, al_cct, al_grado, al_grupo, her_curp, her_nombre, her_appat, her_apmat, her_cct, her_grado, her_grupo, her_id) VALUES (:al_id, :al_curp, :al_nombre, :al_appat, :al_apmat, :al_cct, :al_grado, :al_grupo, :her_curp, :her_nombre, :her_appat, :her_apmat, :her_cct, :her_grado, :her_grupo, :her_id)');

						$lanza->execute(array(":al_id"=>$al_id_compara, ":al_curp"=>$al_curp_compara, ":al_nombre"=>$al_nombre_compara, ":al_appat"=>$appat_compara, ":al_apmat"=>$apmat_compara, ":al_cct"=>$al_cct_compara, ":al_grado"=>$al_grado_compara, ":al_grupo"=>$al_grupo_compara, ":her_curp"=>$curp, ":her_nombre"=>$al_nombre, ":her_appat"=>$apellido, ":her_apmat"=>$al_apmat, ":her_cct"=>$al_cct, ":her_grado"=>$al_grado, ":her_grupo"=>$al_grupo, ":her_id"=>$id));

		  			}

		  		}


		  	}



		  }
		//termina validacion de hermanos

	  	if ($parentesco == "PADRE") {
	  		
	  		if ($padre == NULL) {
	  			
	  			$agrega = $conexion->query("UPDATE pp_alumnos SET padre = '$correo' WHERE id_sis = '$id_sis'");

	  		}
	  		else {
	  			$mensaje = "El parentesco seleccionado ya ha sido vinculado al estudiante con una cuenta anteriormente. Por favor verifica el vínculo que has seleccionado o intenta con un parentesco diferente, en caso de necesitar apoyo puedes escribir a: epena@usebeq.edu.mx";
	  		}

	  	}
	  	if ($parentesco == "MADRE") {
	  		
	  		if ($madre == NULL) {
	  			
	  			$agrega = $conexion->query("UPDATE pp_alumnos SET madre = '$correo' WHERE id_sis = '$id_sis'");

	  		}
	  		else {
	  			$mensaje = "El parentesco seleccionado ya ha sido vinculado al estudiante con una cuenta anteriormente. Por favor verifica el vínculo que has seleccionado o intenta con un parentesco diferente, en caso de necesitar apoyo puedes escribir a: epena@usebeq.edu.mx";
	  		}

	  	}
	  	if ($parentesco == "TUTOR") {
	  		
	  		if ($tutor == NULL) {
	  			
	  			$agrega = $conexion->query("UPDATE pp_alumnos SET tutor = '$correo' WHERE id_sis = '$id_sis'");

	  		}
	  		else {
	  			$mensaje = "El parentesco seleccionado ya ha sido vinculado al estudiante con una cuenta anteriormente. Por favor verifica el vínculo que has seleccionado o intenta con un parentesco diferente, en caso de necesitar apoyo puedes escribir a: epena@usebeq.edu.mx";
	  		}

	  	}

	  	

	  }
	  else {
	  	$mensaje = "No se encuentra al estudiante.<br>Intente nuevamente.";
	  }

  }

  

  //echo $mensaje;

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Datos
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
  
  <?php include("nav.php"); ?>

    <!-- Header -->
    <div class="header pb-9 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(./assets/img/theme/fondo.png); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-success opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--9">
      <div class="row">

        <div class="col-xl-12 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0"><?php echo $mensaje ?></h3>
                </div>
                <div class="col-4 text-right">
                  <a href="panel.php" class="btn btn-success">Aceptar</a>
                </div>
              </div>
            </div>
          </div>
        </div>

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

</html>}
<?php

  $verifica = null;
  $consulta = null;
  $alum = null;
  $al_comp = null;
  $search = null;
  $lanza = null;
  $agrega = null;
  $conexion = null;

?>