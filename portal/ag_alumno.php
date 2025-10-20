<?php session_start();

  require("../conexion.php");

  if (isset($_SESSION['correo'])) {
   
  }
  else{
    header('Location: ../login/login.php');
  }

  $errores = '';
  $estatus = '';

  $correo = $_SESSION['correo'];

  $consulta = $conexion->query("SELECT u_nombre FROM PP_usuarios WHERE u_correo = '$correo'");

  foreach($consulta as $fila){
    $nombre = $fila['u_nombre'];
  }

  if($nombre == NULL OR $nombre == '') {
    $muestra = $correo;
  }
  else {
    $muestra = $nombre;
  }


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Panel - Portal Padres
  </title>
  <!-- Favicon -->
  <link href="./assets/img/brand/favicon.ico" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="./assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="./assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link href="/assets/fontawesome.min.css" rel="stylesheet">

  <style type="text/css" media="screen">
    a { -webkit-tap-highlight-color: rgba(0,0,0,0); }
  </style>

  <script>
    $('#dato').on('Onclick', function(){
    var categoria = $('#categoria').val();
  //  alert(categoria)
    $.ajax({
      url:'respesta.php',
      type: 'POST',
      data: {'dato': dato}
    })
  });
  </script>

</head>

<body class="">
  
  <?php include("nav.php"); ?>

    <!-- Header -->
    <div class="header pb-9 d-flex align-items-center" style="min-height: 600px; background-image: url(assets/img/theme/educacion.jpeg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <h1 class="display-2 text-white">Hola <?php echo $muestra ?></h1>
            <p class="text-white mt-0 mb-5">Ingresa los datos del alumno para poder enlazarlo a tu panel de control, esto te permitirá consultar su perfil académico.</p>
          </div>
        </div>
      </div>
    </div>
            
            <form action="agrega_alumno.php" method="post">
    <!-- Page content -->
    <div class="container-fluid mt--9">
      <div class="row">
              
        <div class="col-xl-12 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-7">
                  <h3 class="mb-0">Datos del Estudiante</h3>
                </div>
                <div class="col-5 text-right">
                  <input type="submit" class="btn btn-sm btn-primary" value="Agregar Estudiante">
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-4">
                  <div class="row">

                    <div class="row col-12 justify-content-center">

                      <!--<h4 align="center" class=""><b class="text-danger">A partir del 3 de agosto, todos los alumnos que egresaron de Preescolar o Primaria y ya están inscritos en el siguiente nivel educativo, es necesario realizar su registro con la información del nuevo plantel escolar (Clave de escuela y letra del grupo asignado).</b></h4>-->

                      <h4 align="justify" class=""><b class="text-danger">Por favor seguir las siguientes recomendaciones para lograr la vinculación del estudiante:<br>
                      * Ingresar el primer apellido del estudiante sin acentos.<br>
                      * La clave de la escuela está compuesta por dos números, tres letras, cuatro números y una letra (22xxx0000x).<br>
                      * En el campo GRUPO se debe de capturar la letra del grupo en el cual se encuentra inscrito el estudiante.</b></h4>
                      <br>
                    </div>

                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="">CURP</label>
                        <input type="text" id="curp" name="curp" class="form-control form-control-alternative" placeholder="XXXX000000XXXXXXX0" maxlength="18">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="">Primer Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="form-control form-control-alternative" placeholder="Primer Apellido">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="">Clave Escuela</label>
                        <input type="text" id="cct" name="cct" class="form-control form-control-alternative" placeholder="CCT" maxlength="10">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <!--<div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="">Grado</label>
                        <input type="number" id="grado" name="grado" class="form-control form-control-alternative" placeholder="Grado" min="1" max="6" step="1">
                      </div>
                    </div>-->
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="">Grupo</label>
                        <select name="grupo" id="grupo" class="form-control form-control-alternative">
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="C">C</option>
                          <option value="D">D</option>
                          <option value="E">E</option>
                          <option value="F">F</option>
                          <option value="G">G</option>
                          <option value="H">H</option>
                          <option value="I">I</option>
                          <option value="J">J</option>
                          <option value="K">K</option>
                          <option value="L">L</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <!--<label class="form-control-label" for="">Folio de la boleta</label>
                       	<button type="button" class="btn btn-sm btn-info" data-container="body" data-toggle="popover" data-placement="top" data-content="Es el folio que aparece en la parte inferior izquierda de la boleta de evaluaciones.">
                          ?
                        </button>
                        <div id="dato">
                          
                        </div>-->
                        <!--<input type="text" id="folio" name="folio" class="form-control form-control-alternative" placeholder="Folio">-->
                        <label class="form-control-label" for="">Parentesco</label>
                        <select name="parentesco" id="parentesco" class="form-control form-control-alternative">
                          <option value="PADRE">Padre de Familia</option>
                          <option value="MADRE">Madre de Familia</option>
                          <option value="TUTOR">Tutor</option>
                        </select>
                        <input type="hidden" id="correo" name="correo" value="<?php echo $correo ?>">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
      
      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2019 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">USEBEQ</a>
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
  <script src="./assets/js/plugins/chart.js/dist/Chart.min.js"></script>
  <script src="./assets/js/plugins/chart.js/dist/Chart.extension.js"></script>
  <!--   Argon JS   -->
  <script src="./assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>

  <!--<script>

    $(buscar_datos());

    function buscar_datos(consulta) {
      var curp = $('#curp').val();
      var apellido = $('#apellido').val();
      $.ajax({
        url:'folio.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta: consulta, curp: curp, apellido: apellido},
      })
      .done(function(respuesta) {
        $("#dato").html(respuesta);
      })
      .fail(function() {
        console.log("error");
      })
    }

    $(document).on('keyup', '#cct', function(){
      var valor = $(this).val();
      if (valor != "") {
        buscar_datos(valor);
        console.log(valor);
      } else {
        buscar_datos();
    //    console.log('error');
      }
    });
  </script>-->

</body>

</html>
<?php

  $consulta = null;
  $conexion = null;

?>