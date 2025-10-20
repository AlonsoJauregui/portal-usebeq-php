<?php session_start();

  require("../conexion.php");

  if (isset($_SESSION['correo'])) {
   
  }
  else{
    header('Location: ../login/login.php');
  }

  $correo = $_SESSION['correo'];

  $datos = $conexion->query("SELECT * FROM PP_usuarios WHERE u_correo = '$correo'");

  foreach ($datos as $dato) {
    $user = $dato['usuario'];
    $id = $dato['u_id'];
    $tel = $dato['u_tel'];
    $nombre = $dato['u_nombre'];
    $appat = $dato['u_appat'];
    $apmat = $dato['u_apmat'];
    $domicilio = $dato['domicilio'];
    $sexo = $dato['sexo'];
  }

  if (is_null($tel) AND is_null($nombre) AND is_null($appat) AND is_null($apmat) AND is_null($domicilio) AND is_null($sexo)) {
    $flag = 1;
  }
  else {
    $flag = 0;
  }

  $alum = $conexion->query("SELECT al_id FROM pp_alumnos WHERE (padre = '$correo' OR madre = '$correo' OR tutor = '$correo')");

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
  <link href="./assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link href="/assets/fontawesome.min.css" rel="stylesheet">

  <style type="text/css" media="screen">
    a { -webkit-tap-highlight-color: rgba(0,0,0,0); }
  </style>

  <!-- scripts necesarios para que salgan ventanas emergentes (ventanas modales) -->
  <script src="../js/popper.min.js"></script>
  <script src="../js/jquery-3.2.1.min.js"></script>

  <!-- <script>
    $('#dato').on('Onclick', function(){
    var categoria = $('#categoria').val();
  //  alert(categoria)
    $.ajax({
      url:'respesta.php',
      type: 'POST',
      data: {'dato': dato}
    })
  });
  </script> -->

  <?php if ($flag == 1) { ?>
  <script>
    $(document).ready(function()
        {
          $("#modal").modal("show");
        });
  </script>
  <?php } ?>

</head>

<body class="">
  
  <?php include("nav.php"); ?>

  <!-- Modal -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4>Aún no está completado tu perfil, por favor actualiza tus datos.</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">En otro momento</button>
          <form action="perfil.php" method="post">
            <button type="submit" class="btn btn-primary">Actualizar datos</button>
            <input type="hidden" name="id" value="<?php echo $id ?>">
          </form>
        </div>
      </div>
    </div>
  </div>

    <!-- Header -->
    <div class="header bg-gradient-info pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">

            <?php while ($res = $alum -> fetch()) { 

              $al_id_compara = $res['al_id'];

              $niv_compara = $conexion->query("SELECT dbo.SCE006.eg_id, dbo.SCE002.nivel FROM dbo.SCE002 INNER JOIN dbo.SCE006 ON dbo.SCE002.eg_id = dbo.SCE006.eg_id WHERE (dbo.SCE006.al_id = '$al_id_compara')"); 

              foreach ($niv_compara as $key) {
                 $nivel_al = $key['nivel'];
              } 

              $certi = $conexion->query("SELECT cr_descrip FROM SCE039 WHERE al_id = '$al_id_compara'");
              $cuenta = $certi->rowCount();

              if ($cuenta != 0) {
                foreach ($certi as $cert) {
                   $cr = $cert['cr_descrip'];
                } 
              } else {
                $cr = "no";
              }

              $al_est = $conexion->query("SELECT al_estatus FROM SCE004 WHERE al_id = '$al_id_compara'");

              foreach ($al_est as $clave) {
                 $al_estatus = rtrim($clave['al_estatus']);
              } 

              if ($al_estatus == "I" OR $al_estatus == "A") {
                $agrega = $conexion->query("UPDATE pp_alumnos SET estatus = 'A' WHERE al_id = '$al_id_compara'");
              }
              if ($al_estatus == "B") {
                $agrega = $conexion->query("UPDATE pp_alumnos SET estatus = 'B' WHERE al_id = '$al_id_compara'");
              }
              if ($al_estatus == "E") {
                $agrega = $conexion->query("UPDATE pp_alumnos SET estatus = 'E' WHERE al_id = '$al_id_compara'");
              }

            ?>

            <div class="col-xl-3 col-lg-6 pb-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0"><?php echo $res['al_nombre']." ".$res['al_appat']." ".$res['al_apmat'] ?></h5>
                    </div>
                    <div class="col-auto">
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="<?php echo "#modal".$res['al_id'] ?>"><i class="ni ni-single-02"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="<?php echo "modal".$res['al_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Menú de opciones</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <h5 class="card-title text-uppercase text-muted mb-0"><?php echo $res['al_nombre']." ".$res['al_appat']." ".$res['al_apmat'] ?></h5>
                    <?php if ($al_estatus == "I" OR $al_estatus == "A") { ?>
                    <a href="calificaciones.php?al_id=<?php echo $res['al_id'] ?>"><i>• Calificaciones</i></a><br>
                    <a href="ReporteE/ReporteEv.php?al_id=<?php echo base64_encode($res['al_id']) ?>" target="_blank"><i>• Boleta de Evaluación</i></a><br>
                    <?php if ($cr == 'firmado') { ?>
                      <a href="http://portal.usebeq.edu.mx:8080/certificados2/1920/<?php echo $res['al_id'] ?>.pdf" target="_blank"><i>• Certificado Electrónico ciclo 2019-2020</i></a><br>
                    <?php } ?>
                    <!--<a href="baja_alumno.php?al_id=<?php echo $res['al_id'] ?>"><i>• Baja de Alumno</i></a><br>-->
                    <?php if ($nivel_al != "PREES") { ?>
                    <!--<a href="duplicados.php?al_id=<?php echo $res['al_id'] ?>&id=<?php echo $id ?>" target="_blank"><i>• Duplicado de Certificado</i></a><br>-->
                    <?php } } ?>

                    <?php if ($al_estatus == "E") { ?>
                      <h3 class="card-title text-uppercase text-muted mb-0">Alumno Egresado.</h3>
                    <?php if ($nivel_al != "PREES") { ?>
                    <!--<a href="duplicados.php?al_id=<?php echo $res['al_id'] ?>&id=<?php echo $id ?>" target="_blank"><i>• Duplicado de Certificado</i></a><br>-->
                    <?php if ($cr == 'firmado') { ?>
                      <a href="http://portal.usebeq.edu.mx:8080/certificados2/1920/<?php echo $res['al_id'] ?>.pdf" target="_blank"><i>• Certificado Electrónico ciclo 2019-2020</i></a><br>
                    <?php } ?>
                    <?php } } ?>

                    <?php if ($al_estatus == "B") { ?>
                      <h3 class="card-title text-uppercase text-muted mb-0">Alumno dado de Baja.</h3>
                    <?php if ($nivel_al != "PREES") { ?>
                    <!--<a href="duplicados.php?al_id=<?php echo $res['al_id'] ?>&id=<?php echo $id ?>" target="_blank"><i>• Duplicado de Certificado</i></a><br>-->
                    <?php if ($cr == 'firmado') { ?>
                      <a href="http://portal.usebeq.edu.mx:8080/certificados2/1920/<?php echo $res['al_id'] ?>.pdf" target="_blank"><i>• Certificado Electrónico ciclo 2019-2020</i></a><br>
                    <?php } ?>
                    <?php } } ?>
                    <!--<a href="dom_alumno.php?al_id=<?php //echo $res['al_id'] ?>"><i>• Verifica domicilio del Alumno</i></a><br>-->
                    <!-- <a href=""><i>• Validar relación de Hermanos</i></a><br>-->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>

            <?php } ?>

            <div class="col-xl-3 col-lg-6 pb-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h4 class="card-title text-uppercase text-muted mb-0"><b>Agregar Alumno</b></h4>
                    </div>
                    <div class="col-auto">
                      <form action="ag_alumno.php">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">

      <br>

      <div class="row justify-content-md-center">
        
        <!--<div class="col-xl-8 mb-5 mb-xl-0">

          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicatorxampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="img/ban1.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="img/ban2.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="img/ban3.png" class="d-block w-100" alt="...">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

        </div>-->

        <!-- AVISOS -->
        <div class="col-xl-10 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-12 text-center">
                  <h2 class="mb-0"><b>AVISOS</b></h2>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">

                    <div class="row col-12 justify-content-center">
                      <div class="alert alert-info" role="alert">

                        <h4 align="justify" class="">Los documentos de acreditación con firma electrónica (Boletas y Certificados) correspondientes al cierre del ciclo 2019-2020 estarán disponibles para descarga en cuanto la escuela concluya sus procesos de captura, revisión y certificación de alumnos, lo cual puede suceder entre el 12 y el 22 de Junio.</h4>

                      </div>
                    </div>
                    
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
</body>

</html>
<?php 

  $datos = null;
  $alum = null;

  $niv_compara = null;
  $certi = null;
  $al_est = null;
  $agrega = null;

  $conexion = null;

?>