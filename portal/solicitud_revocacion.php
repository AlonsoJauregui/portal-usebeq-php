<?php 

  if (isset($_GET['al_id'])) {
    
    $al_id = $_GET['al_id'];
    $id = $_GET['id'];

  }
  else {

    $al_id = "NO";
    $id = "NO";

  }

 

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Revocación
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

  <script src="../js/popper.min.js"></script>
	<script src="../js/jquery-3.2.1.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/jquery-1.2.6.min.js"></script> 
  <script language="JavaScript" type="text/javascript" src="/js/jquery-ui-personalized-1.5.2.packed.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/sprinkle.js"></script> 
  <script>
  //  $('#staticBackdrop').modal('show'); // abrir
  $(document).ready(function()
  {
      $("#staticBackdrop").modal("show");
  });


    function checkSubmit() {
        document.getElementById("btsubmit").value = "Enviando Solicitud...";
        document.getElementById("btsubmit").disabled = true;
        return true;
    }

</script>
</head>

<body class="">

<!--inicia barra de navegacion -->
  

  <div class="main-content">
     <!-- Modal -->
		<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow-y: hidden;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h2 class="modal-title" id="staticBackdropLabel">Estimado padre, madre de familia o tutor:</h2>
		        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          Cerrar
		        </button> -->
		      </div>
		      <div class="modal-body">
          Antes de solicitar la revocación de grado considera que es un trámite irreversible, por lo que el estudiante durante su trayecto académico se encontrará en un grado no correspondiente a su edad, antes de continuar puedes consultar con la escuela las medidas de seguimiento o fortalecimiento aplicables al menor a fin de continuar su educación de manera regular. Una vez enviada la información no es posible cancelar la solicitud, al dar clic en aceptar indicas que estás enterado y aceptas los términos indicados.

             
		      </div>
		      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ACEPTAR</button>
		      </div>
		    </div>
		  </div>
		</div>

  <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h1 mb-0 text-gray text-uppercase d-none d-lg-inline-block" href="panel.php">
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
                   <h2 class="mb-0"><b>Solicitud de revocación de grado en línea.</b></h2> 
                  <h2 class="text-info" ><b>Periodo extraordinario de registro del 12 al 15 de agosto.</b></h2>
                  <h2 align="center" class="" hidden> Fecha límite 26 de Agosto del presente año.<h2>
                    
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-0">
                  <div class="row justify-content-center">
                    <div class="col-lg-10">
                      <div class="form-group">
                      <h2 align="center" class="" hidden> La Revocación de Grado para el Ciclo Escolar 2023-2024.<h2>
                      <form action='estatus_revocacion.php' method='POST'>
                      <!-- <hr class='my-4' /> -->
                      <div class='row' hidden>
                        <div class='row col-12 justify-content-center espacios'>
                          <div class='col-lg-4 form-group'>
                            <label class='form-control-label'>Folio:</label>
                            <input class='form-control form-control-alternative' type='text' name='folioest' id='folioest' placeholder='Ingresa el folio' maxlength='18' onkeyup='mayus(this)' required>
                          </div>
                        </div>
                  
                        <div class='col-lg-12 form-group text-center'>
                          <button type='submit' id='btsubmit' class='btn btn-info'>Consultar</button>
                        </div>
                      </div>
                    </form>
                    <div class="row col-12 justify-content-center">
                      <!-- <br> -->

                      <h4  align="center" class="" hidden><b class="text-danger">Por motivo del receso laboral de fin de ciclo, se hace de su conocimiento que las solicitudes ingresadas por este medio entre el 18 de julio y el 5 de agosto de 2024 serán atendidas a partir del 6 de agosto de 2024.</b></h4>
                      <!-- <br> -->

                      <h4 align="center" class=""><b> Requisitos para realizar la solicitud, imágenes o PDF menor a 2 MB:</b><br>
                      1. CURP.<br>2. Acta de Nacimiento del estudiante. <br>3. Identificación del padre, madre o tutor legal por ambos lados. 
                      <br>4. Anexo 8 debidamente elaborado, letra legible y de molde.<br> 
                      <br><b class="text-danger">Nota: La revocación de grado solo aplica para estudiantes acreditados en el Ciclo Escolar 2024-2025, además la identificación debe corresponder a la persona que firma el Anexo 8.</b></h4>
                      <br>
                      <div class='col-lg-12 form-group text-center'>
                        <a href = './docs/Anexo_8.PDF' download = "Anexo_8.PDF" class='btn btn-info'>Imprimir Anexo 8</a>
			                  <input type='submit' id='btsubmit'  value='Imprimir Anexo 8' hidden/>
		                  </div><br>
                      
                    </div>
                    <div class="row col-12 justify-content-center">
                   
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Operación a realizar</label>
                        <select class="form-control form-control-alternative" name="entrada" id="entrada">
                          <option value="0" disabled selected>Seleccione una opción</option>
                          <!--<option value="revocacion"> 1. Solicitar Revocación</option>-->
                          <option value="estatusRevocacion"> 2. Estatus Revocación</option>
                          
                        </select>
                      </div>
                    </div>
                        <input type="hidden" name="al_id" id="al_id" value="<?php echo $al_id ?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                   </div>

                  <div id="dato">
          
                  </div>

                  </div> 
                  </div>
                 
                 

                  <div class="row col-12 justify-content-center" >
                    <h4 align="center" class="">Si tienes alguna duda puedes comunicarte de Lunes - Viernes de 8hrs - 15hrs, teléfono<br> <b>442 238 6000</b> las extensiones: 
                    <br><b> Preescolar:</b> 1328
                    <br><b> Primaria:</b> 1321
                    <br><b> Secundaria:</b> 1324
                    <br><b> Educación Especial:</b> 1329
                    <br><b> Registro y Certificación:</b> 1325</h4>
                      
                  </div>

                  
                </div> 
            </div>
          </div>
        </div>
      </div>

       <!-- Modal -->
				<!-- <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Estimado padre, madre de familia o tutor:</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                La revocación de grado es un trámite irreversible bajo ninguna circunstancia, por favor consulta con la escuela las opciones disponibles para tu hija o hijo; una vez procesada, no hay posibilidad de cancelar la solicitud lo que implica que durante el resto de su trayecto académico, el menor se encuentre en un grado que no corresponde a su edad física de acuerdo a los criterios aplicables al requisito de edad mínima para ingreso a educación básica.
                
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
    
    
        </div> -->
        </div>
      <!--Incluimos el footer-->
      <?php include("pie.php") ?>
    </div>
 

  <!--   Core   -->
  <script src="./assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="./assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="./assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script src="./assets/js/formulariosrev.js"></script>
  <!-- <script src="./js/principal.js"></script> -->
   

  <script type="text/javascript">
        function mayus(e) {
        e.value = e.value.toUpperCase();
        }


        var inputs = "input[maxlength], textarea[maxlength]";
        $(document).on('keyup', "[maxlength]", function (e) {
          var este = $(this),
            maxlength = este.attr('maxlength'),
            maxlengthint = parseInt(maxlength),
            textoActual = este.val(),
            currentCharacters = este.val().length;
            remainingCharacters = maxlengthint - currentCharacters,
            espan = este.prev('label').find('span');      
            // Detectamos si es IE9 y si hemos llegado al final, convertir el -1 en 0 - bug ie9 porq. no coge directamente el atributo 'maxlength' de HTML5
            if (document.addEventListener && !window.requestAnimationFrame) {
              if (remainingCharacters <= -1) {
                remainingCharacters = 0;            
              }
            }
            espan.html(remainingCharacters);
            // if (!!maxlength) {
            //   var texto = este.val(); 
            //   if (texto.length >= maxlength) {
            //     este.removeClass().addClass("borderojo");
            //     este.val(text.substring(0, maxlength));
            //     e.preventDefault();
            //   }
            //   else if (texto.length < maxlength) {
            //     este.removeClass().addClass("bordegris");
            //   } 
            // } 
          });
        function validate(evt) {
          var theEvent = evt || window.event;

          // Handle paste
          if (theEvent.type === 'paste') {
              key = event.clipboardData.getData('text/plain');
          } else {
          // Handle key press
              var key = theEvent.keyCode || theEvent.which;
              key = String.fromCharCode(key);
          }
          var regex = /[0-9]|\./;
          if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
          }       
        }


    </script> 
</body>

</html>
