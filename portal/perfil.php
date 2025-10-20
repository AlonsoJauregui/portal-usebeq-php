<?php session_start();

  require("../conexion.php");

  if (isset($_SESSION['correo'])) {
   
  }
  else{
    header('Location: ../login/login.php');
  }

  $correo = $_SESSION['correo'];

  $user = $conexion->query("SELECT * FROM PP_usuarios WHERE u_correo = '$correo'");

  foreach ($user as $dato) {
    $usuario = $dato['usuario'];
    $tel = $dato['u_tel'];
    $nombre = $dato['u_nombre'];
    $appat = $dato['u_appat'];
    $apmat = $dato['u_apmat'];
    $domicilio = $dato['domicilio'];
    $cp = $dato['cp'];
    $municipio = $dato['municipio'];
    $sexo = $dato['sexo'];
  }

  if (is_null($nombre)) {
    $enca = $correo;
  }
  else {
    $enca = $nombre;
  }
  

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
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-12 col-md-10">
            <h1 class="display-2 text-white">Hola <?php echo $enca ?></h1>
            <br><br><br><br><br><br>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--9">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="./assets/img/theme/user.png" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
              <div class="d-flex justify-content-between">

              </div>
            </div>
            <div class="card-body pt-0 pt-md-4">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                    
                  </div>
                </div>
              </div>
              <div class="text-center">
                <?php if (is_null($usuario)) { ?>
                  <h3><?php echo $correo ?></h3>
                <?php } else { ?>
                  <h3><?php echo $usuario ?></h3>
                <?php } ?>
                <div class="h5 font-weight-300">
                  <?php if (is_null($nombre)) { ?>
                    <i class="ni location_pin mr-2"></i>Agrega tu nombre.
                  <?php } else { ?>
                    <i class="ni location_pin mr-2"></i><?php echo $nombre." ".$appat." ".$apmat ?>
                  <?php } ?>
                </div>
                <div class="h5 mt-4">
                  <?php if (is_null($domicilio)) { ?>
                    <i class="ni business_briefcase-24 mr-2"></i>Agrega tu domicilio.
                  <?php } else { ?>
                    <i class="ni business_briefcase-24 mr-2"></i><?php echo $domicilio ?>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-8 order-xl-1">
        <form action="actualiza_dom.php" method="post">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-6">
                  <h3 class="mb-0">Mi cuenta</h3>
                </div>
                <div class="col-6 text-right">
                  <button type="submit" class="btn btn-sm btn-primary">Actualizar Información</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form>
                <h6 class="heading-small text-muted mb-4">Información de Usuario</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Nombre de Usuario (Nickname)</label>
                        <input type="text" name="username" class="form-control form-control-alternative" placeholder="Username" value="<?php echo $usuario ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Correo Electronico</label>
                        <input type="email" name="email" class="form-control form-control-alternative" placeholder="mail@example.com" value="<?php echo $correo ?>" disabled>
                        <input type="hidden" name="email" class="form-control form-control-alternative" placeholder="mail@example.com" value="<?php echo $correo ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Nombre(s)</label>
                        <input type="text" name="nombre" class="form-control form-control-alternative" placeholder="Nombre(s)" value="<?php echo $nombre ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Primer Apellido</label>
                        <input type="text" name="appat" class="form-control form-control-alternative" placeholder="Primer Apellido" value="<?php echo $appat ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Segundo Apellido</label>
                        <input type="text" name="apmat" class="form-control form-control-alternative" placeholder="Segundo Apellido" value="<?php echo $apmat ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Sexo</label>
                        <?php if ($sexo == "M") { ?>
                        <select name="sexo" class="form-control form-control-alternative">
                          <option value="M" selected>Masculino</option>
                          <option value="F">Femenino</option>
                        </select>
                        <?php } if ($sexo == "F") { ?>
                        <select name="sexo" class="form-control form-control-alternative">
                          <option value="M">Masculino</option>
                          <option value="F" selected>Femenino</option>
                        </select>
                        <?php } if ($sexo == "") { ?>
                        <select name="sexo" class="form-control form-control-alternative">
                          <option value="" disabled>Seleccione una opción</option>
                          <option value="M">Masculino</option>
                          <option value="F">Femenino</option>
                        </select>
                        <?php } ?> 
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Información de Contacto</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control form-control-alternative" placeholder="Dirección" value="<?php echo $domicilio ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label">C.P.</label>
                        <input type="text" name="cp" class="form-control form-control-alternative" placeholder="C.P." value="<?php echo $cp ?>" required>
                      </div>
                    </div>

                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label">Municipio</label>
                        <select id="opciones" name="municipio" class="form-control form-control-alternative">
                          <option value="AMEALCO DE BONFIL">AMEALCO DE BONFIL</option>
                          <option value="ARROYO SECO">ARROYO SECO</option>
                          <option value="CADEREYTA DE MONTES">CADEREYTA DE MONTES</option>
                          <option value="COLÓN">COLÓN</option>
                          <option value="CORREGIDORA">CORREGIDORA</option>
                          <option value="EL MARQUÉS">EL MARQUÉS</option>
                          <option value="EZEQUIEL MONTES">EZEQUIEL MONTES</option>
                          <option value="HUIMILPAN">HUIMILPAN</option>
                          <option value="JALPAN DE SERRA">JALPAN DE SERRA</option>
                          <option value="LANDA DE MATAMOROS">LANDA DE MATAMOROS</option>
                          <option value="PEDRO ESCOBEDO">PEDRO ESCOBEDO</option>
                          <option value="PEÑAMILLER">PEÑAMILLER</option>
                          <option value="PINAL DE AMOLES">PINAL DE AMOLES</option>
                          <option value="QUERÉTARO">QUERÉTARO</option>
                          <option value="SAN JOAQUÍN">SAN JOAQUÍN</option>
                          <option value="SAN JUAN DEL RÍO">SAN JUAN DEL RÍO</option>
                          <option value="TEQUISQUIAPAN">TEQUISQUIAPAN</option>
                          <option value="TOLIMÁN">TOLIMÁN</option>
                        </select>
                      </div>
                    </div>

                    <script>
                      document.ready = document.getElementById("opciones").value = '<?php echo "$municipio" ?>';
                    </script>
  
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label">Teléfono</label>
                        <input type="text" name="tel" class="form-control form-control-alternative" placeholder="0000000000" value="<?php echo $tel ?>" required>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
              </form>
            </div>
          </div>
        </form>
        </div>

      </div>
      <!--Incluimos el footer-->
      <?php include("pie.php") ?>
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

  $user = null;
  $conexion = null;

?>