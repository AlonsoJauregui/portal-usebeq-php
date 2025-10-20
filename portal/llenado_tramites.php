<?php

require("../conexion.php");
//header("Content-Type: text/html;charset=utf-8");

$al_id = $_POST['al_id'];
$id = $_POST['id'];
$tramite = $_POST['tramite'];
$llenado = "";
$hoy = date("d-m-Y");

if ($al_id == "NO") {
	$al_curp = "";
	$al_nombre = "";
	$al_appat = "";
	$al_apmat = "";
	$correo = "";
	$tel = "";
}
else {

	$consulta = $conexion->query("SELECT * FROM pp_alumnos WHERE al_id = '$al_id'");

	foreach ($consulta as $dat) {
		$al_curp = $dat['al_curp'];
		$al_nombre = $dat['al_nombre'];
		$al_appat = $dat['al_appat'];
		$al_apmat = $dat['al_apmat'];
	}

	$user = $conexion->query("SELECT * FROM PP_usuarios WHERE u_id = '$id'");

	foreach ($user as $dato) {
		$correo = $dato['u_correo'];
		$tel = $dato['u_tel'];
	}

}

if ($tramite == 'tramite') {
	$llenado = "<form action='verifica_tramite.php' method='POST' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>
						<div class='row col-12 justify-content-center espacios'>
							<div class='col-lg-4 form-group'>
								<label class='form-control-label'>Folio de solicitud:</label>
								<input class='form-control form-control-alternative' type='text' name='folio' id='folio' placeholder='Folio' maxlength='15' required>
							</div>
						</div>
			
						<div class='col-lg-12 form-group text-center'>
							<button type='submit' id='btsubmit' class='btn btn-info'>Consultar</button>
						</div>
					</div>
				</form>";

				
}if ($tramite == 'revalidacion') {
	$llenado = "<form action='tramite_reg.php' method='POST' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>

						<h4 align='justify' class=''><b class='text-danger'>La Revalidación de Estudios es para alumnos que concluyeron el nivel de Primaria y/o Secundaria en el extranjero, (sólo se revalidan los niveles concluidos, no grados intermedios y es requisito que el alumno haya viajado o sea proveniente del extranjero, no se valida la educación a distancia de nivel básico).</b></h4><br>

						<div class='row col-12 justify-content-center espacios'>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Nombre del alumno:</label>
							<input class='form-control form-control-alternative' type='text' name='nombre' id='nombre' placeholder='Nombre(s)' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='apat' id='apat' placeholder='Primer Apellido' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='amat' id='amat' placeholder='Segundo Apellido' required>
						</div>
						<div class='col-lg-5 form-group'>
							<label class='form-control-label'>Domicilio Particular:</label>
							<input class='form-control form-control-alternative' type='text' name='domicilio' id='domicilio' placeholder='Domicilio particular' maxlength='100' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Nacionalidad:</label>
							<input class='form-control form-control-alternative' type='text' name='nacionalidad' id='nacionalidad' placeholder='Nacionalidad' maxlength='45' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Pais/Estado donde curso sus estudios:</label>
							<input class='form-control form-control-alternative' type='text' name='pais' id='pais' placeholder='Pais' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>Sexo:</label>
							<select class='form-control form-control-alternative' name='sexo' id='sexo' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='M'>Masculino</option>
								<option value='F'>Femenino</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Deseo ingresar a la escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='cct' id='cct' placeholder='Clave escuela (10 Dígitos)'  required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Deseo revalidar estudios de:</label>
							<select class='form-control form-control-alternative' name='nivel' id='nivel' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='PRI'>Primaria</option>
								<option value='SEC'>Secundaria</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Correo Electronico:</label>
							<input class='form-control form-control-alternative' type='email' name='email' id='email' placeholder='nombre@example.com' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>Teléfono:</label>
							<input class='form-control form-control-alternative' type='number' name='tel' id='tel' placeholder='Teléfono a 10 dígitos' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Quien solicita el trámite:</label>
							<select class='form-control form-control-alternative' name='realiza' id='realiza' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='PADRE'>Padre de Familia</option>
								<option value='MADRE'>Madre de Familia</option>
								<option value='TUTOR'>Tutor</option>
								<option value='ALUMNO'>Alumno</option>
							</select>
						</div>
						<div class='row col-12 justify-content-center'>

	                      <h3 align='center' class=''><b class='text-danger'>Información Importante</b></h3>

	                    </div>
	                    <div class='row col-12 justify-content-center'>

	                      <h4 align='center' class=''><b class='text-danger'>Los requisitos para Revalidación de estudios de Educación Secundaria son los siguientes:</b></h4><br>

	                    </div>

	                    <h4 align='justify' class=''><b>1.-          Acta de Nacimiento.<br>
							2.-          Certificado de Primaria.<br>
							3.-          Boletas oficiales de 1 y 2 grado.<br>
							4.- El documento oficial que acredite los estudios realizados en el extranjero, el cual deberá contener los datos de la escuela, del alumno, las materias que cursó y sus calificaciones y deberá presentarse el original con sellos y firmas de la institución que lo avala. El grado debe estar cursado y acreditado en su totalidad.<br>
							5.-       Traducción en caso de ser necesaria.<br></b></h4><br>

						<div class='row col-12 justify-content-center'>

	                      <h4 align='center' class=''><b class='text-danger'>Para Revalidación de estudios de Educación Primaria Puntos 1,4 y 5.</b></h4><br>

	                      <h4 align='center' class=''><b class='text-danger'>Por favor cargar los documentos en un solo archivo en formato PDF en el orden enumerado.</b></h4><br>

	                    </div>

						<div class='col-lg-12 form-group'>
							<label class='form-control-label'>Documentos: (formato .PDF)*</label>
							<input class='' type='file' name='identificacion' id='identificacion' accept='application/pdf' required>
							<input type='hidden' name='tipo' id='tipo' value='REVALIDACION DE ESTUDIOS'>
						</div>
						<div class='col-lg-12 form-group text-center'>
							<input type='submit' id='btsubmit' class='btn btn-info' value='Generar Solicitud' />
						</div>
					</div>
				</form>";

				
}if ($tramite == 'legalizacion') {
	$llenado = "<form action='tramite_reg.php' method='POST' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>

						<!--<h4 align='justify' class=''><b class='text-danger'>La Revalidación de Estudios es para alumnos que concluyeron el nivel de Primaria y/o Secundaria en el extranjero, (sólo se revalidan los niveles concluidos, no grados intermedios y es requisito que el alumno haya viajado o sea proveniente del extranjero, no se valida la educación a distancia de nivel básico).</b></h4><br>-->

						<div class='row col-12 justify-content-center espacios'>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Nombre del alumno:</label>
							<input class='form-control form-control-alternative' type='text' name='nombre' id='nombre' placeholder='Nombre(s)' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='apat' id='apat' placeholder='Primer Apellido' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='amat' id='amat' placeholder='Segundo Apellido' required>
						</div>
						<div class='col-lg-5 form-group'>
							<label class='form-control-label'>Domicilio Particular:</label>
							<input class='form-control form-control-alternative' type='text' name='domicilio' id='domicilio' placeholder='Domicilio particular' maxlength='100' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Documento a Legalizar:</label>
							<select class='form-control form-control-alternative' name='doc' id='doc' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='CERTIFICADO'>Certificado</option>
								<option value='BOLETA'>Boleta</option>
								<option value='INFORME'>Informe de Calificaciones</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Clave escuela de documento:</label>
							<input class='form-control form-control-alternative' type='text' name='cct' id='cct' placeholder='Clave escuela (10 Dígitos)'  required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Correo Electronico:</label>
							<input class='form-control form-control-alternative' type='email' name='email' id='email' placeholder='nombre@example.com' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>Teléfono:</label>
							<input class='form-control form-control-alternative' type='number' name='tel' id='tel' placeholder='Teléfono a 10 dígitos' required>
						</div>
						
						<div class='row col-12 justify-content-center'>

	                      <h3 align='center' class=''><b class='text-danger'>Información Importante</b></h3>

	                    </div>

	                    <h4 align='justify' class=''><b class=''>Por favor cargar el documento a legalizar en formato PDF, una vez generado el trámite y validado el pago, deberá presentarse en las oficinas de USEBEQ con el documento original para agregar el dictamen de legalización debidamente firmado y sellado.</b></h4><br>

						<div class='col-lg-12 form-group'>
							<label class='form-control-label'>Documentos: (formato .PDF)*</label>
							<input class='' type='file' name='identificacion' id='identificacion' accept='application/pdf' required>
							<input type='hidden' name='tipo' id='tipo' value='LEGALIZACION DE FIRMA'>
						</div>
						<div class='col-lg-12 form-group text-center'>
							<input type='submit' id='btsubmit' class='btn btn-info' value='Generar Solicitud' />
						</div>
					</div>
				</form>";
}if ($tramite == 'examen') {
	$llenado = "<form action='tramite_reg.php' method='POST' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>

						<!--<h4 align='justify' class=''><b class='text-danger'>La Revalidación de Estudios es para alumnos que concluyeron el nivel de Primaria y/o Secundaria en el extranjero, (sólo se revalidan los niveles concluidos, no grados intermedios y es requisito que el alumno haya viajado o sea proveniente del extranjero, no se valida la educación a distancia de nivel básico).</b></h4><br>-->

						<div class='row col-12 justify-content-center espacios'>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Nombre del alumno:</label>
							<input class='form-control form-control-alternative' type='text' name='nombre' id='nombre' placeholder='Nombre(s)' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='apat' id='apat' placeholder='Primer Apellido' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='amat' id='amat' placeholder='Segundo Apellido' required>
						</div>
						<div class='col-lg-5 form-group'>
							<label class='form-control-label'>CURP del alumno:</label>
							<input class='form-control form-control-alternative' type='text' name='curp' id='curp' placeholder='CURP' maxlength='18' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Ultimo grado cursado:</label>
							<select class='form-control form-control-alternative' name='gra' id='gra' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='6'>Sexto Grado Primaria</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Correo Electronico:</label>
							<input class='form-control form-control-alternative' type='email' name='email' id='email' placeholder='nombre@example.com' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>Teléfono:</label>
							<input class='form-control form-control-alternative' type='number' name='tel' id='tel' placeholder='Teléfono a 10 dígitos' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Quien solicita el trámite:</label>
							<select class='form-control form-control-alternative' name='realiza' id='realiza' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='PADRE'>Padre de Familia</option>
								<option value='MADRE'>Madre de Familia</option>
								<option value='TUTOR'>Tutor</option>
								<option value='ALUMNO'>Alumno</option>
							</select>
						</div>
						<div class='row col-12 justify-content-center'>

	                      <h3 align='center' class=''><b class='text-danger'>Información Importante</b></h3>

	                    </div>

	                    <div class='row col-12 justify-content-center'>

	                      <h4 align='center' class=''><b class='text-danger'>Los requisitos para solicitar la Evaluación General de Conocimientos son los siguientes:</b></h4><br>

	                    </div>

	                    <h4 align='justify' class=''><b>1.-          Acta de Nacimiento.<br>
							2.-          CURP<br>
							3.-          Boleta oficial del ultimo grado cursado.<br>
							4.- 		Realizar un escrito dirigido al Lic. Carlos Samuel Leal Guerrero, Jefe del Departamento de Registro y Certificación, solicitando que el alumno presente la Evaluación General de Conocimientos. Agregar a este escrito los datos de contacto (Nombre, teléfono, correo electrónico).<br>
							5.-       Identificación oficial de los padres o tutores.<br></b></h4><br>

	                    <div class='row col-12 justify-content-center'>

	                      <h4 align='center' class=''><b class='text-danger'>Por favor cargar los documentos en un solo archivo en formato PDF en el orden enumerado.</b></h4><br>

	                    </div>

						<div class='col-lg-12 form-group'>
							<label class='form-control-label'>Documentos: (formato .PDF)*</label>
							<input class='' type='file' name='identificacion' id='identificacion' accept='application/pdf' required>
							<input type='hidden' name='tipo' id='tipo' value='EXAMEN GENERAL'>
						</div>
						<div class='col-lg-12 form-group text-center'>
							<input type='submit' id='btsubmit' class='btn btn-info' value='Generar Solicitud' />
						</div>
					</div>
				</form>";
}


echo $llenado;

$consulta = null;
$user = null;
$conexion = null;

?>