<?php

	$materias = $conexion->query("SELECT * FROM SCE005 WHERE al_id = '$al_id' AND ce_inicic = '$year'");

	$materias1 = $conexion->query("EXEC sce2018.[dbo].[spr_GetCalificaciones] @AL_ID = '$al_id', @ciclo = '$year'");

	$bandera1 = 0;
	$bandera2 = 2;

	while ($result = $materias -> fetch()) {

		$tm_clave1 = $result['tm_clave'];
		$ma_descrip_pro = $result['ma_descripcion'];
		$ca_calif1pro = $result['ca_calif1'];
		$ca_prompro = $result['ca_prom'];

		if ($tm_clave1 == 'EDT') {
			$ma_descrip_sec = $ma_descrip_pro;
			$ca_calif_sec = $ca_calif1pro;
			//$ca_prom_sec = $ca_prom_sec;
			$ca_prom_sec = $ca_prompro;
		}

		if ($ca_calif1pro == 1) {
			$bandera1 = 1;
		}

		if ($ca_calif1pro == 2) {
			$bandera2 = 1;
		}

	}

	$autonomias = $conexion->query("SELECT cm_descrip, cc_nivel1, cc_nivel2, cc_nivel3 FROM sce044 WHERE al_id = '$al_id' AND ce_inicic = '$year'");

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>complemento</title>
</head>
<body>

	//Aqui debe de ir el codigo de la consulta completa

	<!-- Dark table -->
			      <div class="row mt-5">
			        <div class="col">
			          <div class="card bg-default shadow">
			            <div class="card-header bg-transparent border-0">
			              <h3 class="text-white mb-0">Evaluaciones Ciclo escolar: <?php echo $year."-".$year2 ?></h3>
			            </div>
			            <div class="table-responsive">
			              <table class="table align-items-center table-dark table-flush">
			                <thead class="thead-dark">
			                  <tr>
			                    <th scope="col"></th>
			                    <th colspan="3" align="center" style="text-align: center;">Periodos de Evaluación</th>
			                    <th scope="col"></th>
			                  </tr>
			                  <tr>
			                    <th scope="col">Materia</th>
			                    <th scope="col">1er</th>
			                    <th scope="col">2do</th>
			                    <th scope="col">3er</th>
			                    <th scope="col">Promedio</th>
			                  </tr>
			                </thead>
			                <tbody>

			                	<?php while ($resulta = $materias1 -> fetch()) {

									$tm_clave1 = $resulta['tm_Clave'];
									$ma_descrip_pro = $resulta['ma_descripcion'];
									$ca_calif1pro = $resulta['ca_calif1'];
									$ca_calif2pro = $resulta['ca_calif2'];
									$ca_calif3pro = $resulta['ca_calif3'];
									$ca_prompro = $resulta['ca_prom'];
									$coment = $resulta['comen1'];
									$coment2 = $resulta['comen2'];
									$coment3 = $resulta['comen3'];

									if ($tm_clave1 == 'EDT') {
										$ma_descrip_sec = $ma_descrip_pro;
										$ca_calif_sec = $ca_calif1pro;
										$ca_prom_sec = $ca_prom_sec;
									}

									if ($nivel == 'PREESCOLAR') {
										$ca_calif1pro = $coment;
										$ca_calif2pro = $coment2;
										$ca_calif3pro = $coment3;
									}

									if ($ca_calif1pro == 1) {
										$bandera1 = 1;
										$ca_calif1pro = "-";
									}

									if ($ca_calif1pro == 2) {
										$bandera2 = 1;
										$ca_calif1pro = "- -";
									}

									if ($ca_calif2pro == 1) {
										$bandera1 = 1;
										$ca_calif2pro = "-";
									}

									if ($ca_calif2pro == 2) {
										$bandera2 = 1;
										$ca_calif2pro = "- -";
									}

									if (strpos($ma_descrip_pro, 'INGLÉS') !== false AND ($ca_calif1pro == 0 OR $ca_calif1pro == "")) {
										$ca_calif1pro = "";
										$ca_calif2pro = "";
										$ca_prompro = "S/N";
									}

								?>
			                	<tr>
			                    <th scope="row">
			                      <div class="media align-items-center">
			                        <div class="media-body">
			                          <span class="mb-0 text-sm"><?php echo $ma_descrip_pro; ?></span>
			                        </div>
			                      </div>
			                    </th>
			                    <td>
			                      <?php echo $ca_calif1pro; ?>
			                    </td>
			                    <td>
			                      <?php //echo $ca_calif2pro; ?>
			                    </td>
			                    <td>
			                      <?php //echo $ca_calif3pro; ?>
			                    </td>
			                    <td>
			                      <?php //echo bcdiv($ca_prompro, '1', 1); ?>
			                      <?php if ($ca_prompro == "S/N") { } else { echo number_format($ca_prompro,1); } ?>
			                    </td>
			                  </tr>
			              	  <?php } ?>

			                </tbody>
			              </table>
			            </div>
			          </div>
			        </div>
			      </div>

	<!-- Dark table -->
      <div class="row mt-5">
        <div class="col">
          <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
              <h3 class="text-white mb-0">Componentes curriculares</h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-dark table-flush">
                <thead class="thead-dark">
			      <tr>
			      	<th scope="col"></th>
			        <th colspan="3" align="center" style="text-align: center;">Periodos de Evaluación</th>
			      </tr>
			      <tr>
			        <th scope="col">CAMPOS</th>
			        <th scope="col">1er</th>
			        <th scope="col">2do</th>
			        <th scope="col">3er</th>
			      </tr>
			    </thead>
                <tbody>
                  <?php while ($result2 = $autonomias -> fetch()) { 

                  	$ma_descripcion = $result2['cm_descrip'];
                  	//$nivel_au = $result2['nivel'];
                  	$desnivel = $result2['cc_nivel1'];
                  	$desnivel2 = $result2['cc_nivel2'];
                  	$desnivel3 = $result2['cc_nivel3'];

                  	if ($desnivel != NULL) {
                  	

                  ?>
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="mb-0 text-sm"><?php echo $ma_descripcion; ?></span>
                        </div>
                      </div>
                    </th>
                    <td>
                      <?php echo rtrim($desnivel); ?>
                    </td>
                    <td>
                      <?php //echo rtrim($desnivel2); ?>
                    </td>
                    <td>
                      <?php //echo rtrim($desnivel3); ?>
                    </td>
                  </tr>
                  <?php } } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

				<!-- Dark table -->
			      <div class="row mt-4">
			        <div class="col">
			          <div class="card bg-default shadow">
			            <div class="card-header bg-transparent border-0">
			              <h3 class="text-white mb-0">Observaciones:</h3>
			            </div>
			            <div class="table-responsive">
			              <table class="table align-items-center table-dark table-flush">
			                <tbody>
			                <?php if ($bandera1 == 1) { ?>
			                  <tr>
			                    <th scope="row">
			                        <div class="media-body">
			                          <span class="mb-0 text-sm"> - &nbsp;&nbsp;&nbsp; Información insuficiente, al registrar una comunicación y participación intermitente.</span>
			                        </div>
			                    </th>
			                  </tr>
			                <?php } if ($bandera2 == 1) { ?>
			                  <tr>
			                    <th scope="row">
			                        <div class="media-body">
			                          <span class="mb-0 text-sm"> - - &nbsp;&nbsp;&nbsp; Sin información, al registrar una comunicación prácticamente inexistente.</span>
			                        </div>
			                    </th>
			                  </tr>
			                <?php } ?>
			                </tbody>
			              </table>
			            </div>
			          </div>
			        </div>
			      </div>
	
</body>
</html>
<?php

	$uno = null;
	$dos = null;
	$tres = null;
	$cuatro = null;
	$cinco = null;
	$seis = null;
	$siete = null;
	$ocho = null;
	$nueve = null;

?>