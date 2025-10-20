<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
</head>
<body>

	<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="panel.php">
        <img src="assets/img/brand/USEBEQN.png" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="./assets/img/theme/user.png">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Bienvenido</h6>
            </div>
            <a href="perfil.php" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>Mí perfil</span>
            </a>
            <!--<a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Ajustes</span>
            </a>-->

            <div class="dropdown-divider"></div>
            <a href="sesion.php" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Cerrar Sesión</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="panel.php">
                PPF
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
        
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item"  class="active">
          <a class=" nav-link active " href="panel.php"> <i class="ni ni-tv-2 text-primary"></i> Panel
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="perfil.php">
              <i class="ni ni-single-02 text-yellow"></i> Mí perfil
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">USEBEQ</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="https://www.usebeq.edu.mx/PaginaWEB/" target="_blank">
              <i class="ni ni-spaceship"></i> Pagina oficial
            </a>
            <a class="nav-link" href="https://www.usebeq.edu.mx/PaginaWeb/Home/MiCorreoInstitucional" target="_blank">
              <i class="ni ni-email-83"></i> Mi correo institucional
            </a>
            <a class="nav-link" href="https://said.usebeq.edu.mx/" target="_blank">
              <i class="ni ni-ruler-pencil"></i> Preinscripciones
            </a>
            <a class="nav-link" href="aviso.php" target="_blank">
              <i class="ni ni-lock-circle-open"></i> Aviso de privacidad
            </a>
            <a class="nav-link" href="https://www.usebeq.edu.mx/PaginaWEB/encuestas/evaluacionServicioSGC" target="_blank">
              <i class="fas fa-clipboard-check"></i> Evaluación del servicio
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="panel.php">Portal para Padres de Familia</a>
        <!-- Form -->
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="./assets/img/theme/user.png">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold"><?php echo $correo; ?></span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Bienvenido</h6>
              </div>
              <a href="perfil.php" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>Mí perfil</span>
              </a>
              <!--<a href="./examples/profile.html" class="dropdown-item">
                <i class="ni ni-settings-gear-65"></i>
                <span>Ajustes</span>
              </a>-->
              
              <div class="dropdown-divider"></div>
              <a href="sesion.php" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Cerrar Sesión</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
	
</body>
</html>