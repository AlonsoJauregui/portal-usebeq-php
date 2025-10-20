<?php

require("../conexion.php");
//header("Content-Type: text/html;charset=utf-8");

$al_id = $_POST['al_id'];
$id = $_POST['id'];
$tramite = $_POST['tramite'];
$origen = $_POST['origen'];
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

if ($tramite == 'Duplicado Certificado de Preescolar') {
	$llenado = "<form action='cert_preescolar.php' method='POST' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>
						<div class='row col-12 justify-content-center espacios'>
								<label>Solicitud Duplicado Certificado de Preescolar</label>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>CURP:</label>
							<input class='form-control form-control-alternative' type='text' name='curp' id='curp' value='$al_curp' placeholder='CURP..' maxlength='18' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Nombre Alumno:</label>
							<input class='form-control form-control-alternative' type='text' name='alumno' id='alumno' placeholder='Nombre(s)' value='$al_nombre' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='a_paterno' id='a_paterno' value='$al_appat' placeholder='Primer Apellido' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='a_materno' id='a_materno' value='$al_apmat' placeholder='Segundo Apellido' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Clave Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='cct' id='cct' placeholder='Clave de la Escuela..' maxlength='10' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Nombre Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='escuela' id='escuela' placeholder='Escuela..' maxlength='45' required>
						</div>
						<div class='col-lg-5 form-group'>
							<label class='form-control-label'>Dom. Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='dom_esc' id='dom_esc' placeholder='Domicilio..' maxlength='70' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Turno:</label>
							<select class='form-control form-control-alternative' name='turno' id='turno' required>
								<option value=''>Selecciona una opción</option>
								<option value='MAT'>Matutino</option>
								<option value='VES'>Vespertino</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Ciclo de Terminación:</label>
							<select class='form-control form-control-alternative' name='terminacion' id='terminacion' required>
								<option value=''>Selecciona una opción</option>
								<option value='2024-2025'>2024-2025</option>
								<option value='2023-2024'>2023-2024</option>
								<option value='2022-2023'>2022-2023</option>
								<option value='2021-2022'>2021-2022</option>
								<option value='2020-2021'>2020-2021</option>
								<option value='2019-2020'>2019-2020</option>
								<option value='2018-2019'>2018-2019</option>
								<option value='2017-2018'>2017-2018</option>
								<option value='2016-2017'>2016-2017</option>
								<option value='2015-2016'>2015-2016</option>
								<option value='2014-2015'>2014-2015</option>
								<option value='2013-2014'>2013-2014</option>
								<option value='2012-2013'>2012-2013</option>
								<option value='2011-2012'>2011-2012</option>
								<option value='2010-2011'>2010-2011</option>
								<option value='2009-2010'>2009-2010</option>
								<option value='2008-2009'>2008-2009</option>
								<option value='2007-2008'>2007-2008</option>
								<option value='2006-2007'>2006-2007</option>
								<option value='2005-2006'>2005-2006</option>
								<option value='2004-2005'>2004-2005</option>
								<option value='2003-2004'>2003-2004</option>
								<option value='2002-2003'>2002-2003</option>
								<option value='2001-2002'>2001-2002</option>
								<option value='2000-2001'>2000-2001</option>
								<option value='1999-2000'>1999-2000</option>
								<option value='1998-1999'>1998-1999</option>
								<option value='1997-1998'>1997-1998</option>
								<option value='1996-1997'>1996-1997</option>
								<option value='1995-1996'>1995-1996</option>
								<option value='1994-1995'>1994-1995</option>
								<option value='1993-1994'>1993-1994</option>
								<option value='1992-1993'>1992-1993</option>
								<option value='1991-1992'>1991-1992</option>
								<option value='1990-1991'>1990-1991</option>
								<option value='1989-1990'>1989-1990</option>
								<option value='1988-1989'>1988-1989</option>
								<option value='1987-1988'>1987-1988</option>
								<option value='1986-1987'>1986-1987</option>
								<option value='1985-1986'>1985-1986</option>
								<option value='1984-1985'>1984-1985</option>
								<option value='1983-1984'>1983-1984</option>
								<option value='1982-1983'>1982-1983</option>
								<option value='1981-1982'>1981-1982</option>
								<option value='1980-1981'>1980-1981</option>
								<option value='1979-1980'>1979-1980</option>
								<option value='1978-1979'>1978-1979</option>
								<option value='1977-1978'>1977-1978</option>
								<option value='1976-1977'>1976-1977</option>
								<option value='1975-1976'>1975-1976</option>
								<option value='1974-1975'>1974-1975</option>
								<option value='1973-1974'>1973-1974</option>
								<option value='1972-1973'>1972-1973</option>
								<option value='1971-1972'>1971-1972</option>
								<option value='1970-1971'>1970-1971</option>
								<option value='1969-1970'>1969-1970</option>
								<option value='1968-1969'>1968-1969</option>
								<option value='1967-1968'>1967-1968</option>
								<option value='1966-1967'>1966-1967</option>
								<option value='1965-1966'>1965-1966</option>
								<option value='1964-1965'>1964-1965</option>
								<option value='1963-1964'>1963-1964</option>
								<option value='1962-1963'>1962-1963</option>
								<option value='1961-1962'>1961-1962</option>
								<option value='1960-1961'>1960-1961</option>
								<option value='1959-1960'>1959-1960</option>
								<option value='1958-1959'>1958-1959</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Correo Electronico:</label>
							<input class='form-control form-control-alternative' type='email' name='email' id='email' value='$correo' placeholder='nombre@example.com' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Tel.</label>
							<input class='form-control form-control-alternative' type='text' name='tel' id='tel' value='$tel' placeholder='Tel. Celular' maxlength='10' required>
							<input type='hidden' name='al_id' id='al_id' value='$al_id'>
							<input type='hidden' name='id' id='id' value='$id'>
							<input type='hidden' name='origen' id='origen' value='$origen'>
						</div>
						<div class='col-lg-3 form-group'>
		                    <div class='custom-control custom-control-alternative custom-checkbox'>
		                      <input class='custom-control-input' id='core' name='core' type='checkbox' value='SI'>
		                      <label class='custom-control-label' for='core'>
		                        <span class='text-muted'>¿Requiere corrección en CURP?</span>
		                      </label>
		                    </div>
		                </div>
						<div class='col-lg-12 form-group text-center'>
							<input type='submit' id='btsubmit' class='btn btn-info' value='Generar Solicitud' />
						</div>
					</div>
				</form>";
				
}if ($tramite == 'Duplicado Certificado de Primaria') {
	$llenado = "<form action='cert_primaria.php' method='post' enctype='' onsubmit='return checkSubmit();'>
					<br>
					<div class='row'>
						<div class='row col-12 justify-content-center espacios'>
								<label>Solicitud Duplicado Certificado de Primaria</label>
						</div>
						<br><br>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>CURP:</label>
							<input class='form-control form-control-alternative' type='text' name='curp' id='curp' value='$al_curp' placeholder='CURP..' maxlength='18' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Nombre Alumno:</label>
							<input class='form-control form-control-alternative' type='text' name='alumno' id='alumno' value='$al_nombre' placeholder='Nombre(s)' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='a_paterno' id='a_paterno' value='$al_appat' placeholder='Primer Apellido' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='a_materno' id='a_materno'value='$al_apmat' placeholder='Segundo Apellido' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Clave Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='cct' id='cct' placeholder='Clave de la Escuela..' maxlength='10' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Nombre Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='escuela' id='escuela' placeholder='Escuela..' maxlength='45' required>
						</div>
						<div class='col-lg-5 form-group'>
							<label class='form-control-label'>Dom. Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='dom_esc' id='dom_esc' placeholder='Domicilio..' maxlength='70' required>
							
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Turno:</label>
							<select class='form-control form-control-alternative' name='turno' id='turno' required>
								<option value=''>Selecciona una opción</option>
								<option value='MAT'>Matutino</option>
								<option value='VES'>Vespertino</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Ciclo de Terminación:</label>
							<select class='form-control form-control-alternative' name='terminacion' id='terminacion' required>
								<option value=''>Selecciona una opción</option>
								<option value='2024-2025'>2024-2025</option>
								<option value='2023-2024'>2023-2024</option>
								<option value='2022-2023'>2022-2023</option>
								<option value='2021-2022'>2021-2022</option>
								<option value='2020-2021'>2020-2021</option>
								<option value='2019-2020'>2019-2020</option>
								<option value='2018-2019'>2018-2019</option>
								<option value='2017-2018'>2017-2018</option>
								<option value='2016-2017'>2016-2017</option>
								<option value='2015-2016'>2015-2016</option>
								<option value='2014-2015'>2014-2015</option>
								<option value='2013-2014'>2013-2014</option>
								<option value='2012-2013'>2012-2013</option>
								<option value='2011-2012'>2011-2012</option>
								<option value='2010-2011'>2010-2011</option>
								<option value='2009-2010'>2009-2010</option>
								<option value='2008-2009'>2008-2009</option>
								<option value='2007-2008'>2007-2008</option>
								<option value='2006-2007'>2006-2007</option>
								<option value='2005-2006'>2005-2006</option>
								<option value='2004-2005'>2004-2005</option>
								<option value='2003-2004'>2003-2004</option>
								<option value='2002-2003'>2002-2003</option>
								<option value='2001-2002'>2001-2002</option>
								<option value='2000-2001'>2000-2001</option>
								<option value='1999-2000'>1999-2000</option>
								<option value='1998-1999'>1998-1999</option>
								<option value='1997-1998'>1997-1998</option>
								<option value='1996-1997'>1996-1997</option>
								<option value='1995-1996'>1995-1996</option>
								<option value='1994-1995'>1994-1995</option>
								<option value='1993-1994'>1993-1994</option>
								<option value='1992-1993'>1992-1993</option>
								<option value='1991-1992'>1991-1992</option>
								<option value='1990-1991'>1990-1991</option>
								<option value='1989-1990'>1989-1990</option>
								<option value='1988-1989'>1988-1989</option>
								<option value='1987-1988'>1987-1988</option>
								<option value='1986-1987'>1986-1987</option>
								<option value='1985-1986'>1985-1986</option>
								<option value='1984-1985'>1984-1985</option>
								<option value='1983-1984'>1983-1984</option>
								<option value='1982-1983'>1982-1983</option>
								<option value='1981-1982'>1981-1982</option>
								<option value='1980-1981'>1980-1981</option>
								<option value='1979-1980'>1979-1980</option>
								<option value='1978-1979'>1978-1979</option>
								<option value='1977-1978'>1977-1978</option>
								<option value='1976-1977'>1976-1977</option>
								<option value='1975-1976'>1975-1976</option>
								<option value='1974-1975'>1974-1975</option>
								<option value='1973-1974'>1973-1974</option>
								<option value='1972-1973'>1972-1973</option>
								<option value='1971-1972'>1971-1972</option>
								<option value='1970-1971'>1970-1971</option>
								<option value='1969-1970'>1969-1970</option>
								<option value='1968-1969'>1968-1969</option>
								<option value='1967-1968'>1967-1968</option>
								<option value='1966-1967'>1966-1967</option>
								<option value='1965-1966'>1965-1966</option>
								<option value='1964-1965'>1964-1965</option>
								<option value='1963-1964'>1963-1964</option>
								<option value='1962-1963'>1962-1963</option>
								<option value='1961-1962'>1961-1962</option>
								<option value='1960-1961'>1960-1961</option>
								<option value='1959-1960'>1959-1960</option>
								<option value='1958-1959'>1958-1959</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Correo Electronico:</label>
							<input class='form-control form-control-alternative' type='email' name='email' id='email' value='$correo' placeholder='nombre@example.com' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Tel.</label>
							<input class='form-control form-control-alternative' type='text' name='tel' id='tel' value='$tel' placeholder='Tel. Celular' maxlength='10' required>
							<input type='hidden' name='al_id' id='al_id' value='$al_id'>
							<input type='hidden' name='id' id='id' value='$id'>
							<input type='hidden' name='origen' id='origen' value='$origen'>
						</div>
						<div class='col-lg-3 form-group'>
		                    <div class='custom-control custom-control-alternative custom-checkbox'>
		                      <input class='custom-control-input' id='core' name='core' type='checkbox' value='SI'>
		                      <label class='custom-control-label' for='core'>
		                        <span class='text-muted'>¿Requiere corrección en CURP?</span>
		                      </label>
		                    </div>
		                </div>
						<div class='col-lg-12 form-group text-center'>
							<button type='submit' id='btsubmit' class='btn btn-info'>Generar Solicitud</button>
						</div>
					</div>
				</form>";
					
}if ($tramite ==  'Duplicado Certificado de Secundaria') {
	$llenado = "<form action='cert_secundaria.php' method='post' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
					<br>
					<div class='row'>
						<div class='row col-12 justify-content-center espacios'>
								<label>Solicitud Duplicado Certificado de Secundaria</label>
						</div>
						<br><br>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>CURP:</label>
							<input class='form-control form-control-alternative' type='text' name='curp' id='curp' value='$al_curp' placeholder='CURP..' maxlength='18' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Nombre Alumno:</label>
							<input class='form-control form-control-alternative' type='text' name='alumno' id='alumno' value='$al_nombre' placeholder='Nombre(s)' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='a_paterno' id='a_paterno' value='$al_appat' placeholder='Primer Apellido' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>&nbsp;</label>
							<input class='form-control form-control-alternative' type='text' name='a_materno' id='a_materno' value='$al_apmat' placeholder='Segundo Apellido' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Clave Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='cct' id='cct' placeholder='Clave de la Escuela..' maxlength='10' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Nombre Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='escuela' id='escuela' placeholder='Escuela..' maxlength='45' required>
						</div>
						<div class='col-lg-5 form-group'>
							<label class='form-control-label'>Dom. Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='dom_esc' id='dom_esc' placeholder='Domicilio..' maxlength='70' required>
							
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Turno:</label>
							<select class='form-control form-control-alternative' name='turno' id='turno' required>
								<option value=''>Selecciona una opción</option>
								<option value='MAT'>Matutino</option>
								<option value='VES'>Vespertino</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Ciclo de Terminación:</label>
							<select class='form-control form-control-alternative' name='terminacion' id='terminacion' required>
								<option value=''>Selecciona una opción</option>
								<option value='2024-2025'>2024-2025</option>
								<option value='2023-2024'>2023-2024</option>
								<option value='2022-2023'>2022-2023</option>
								<option value='2021-2022'>2021-2022</option>
								<option value='2020-2021'>2020-2021</option>
								<option value='2019-2020'>2019-2020</option>
								<option value='2018-2019'>2018-2019</option>
								<option value='2017-2018'>2017-2018</option>
								<option value='2016-2017'>2016-2017</option>
								<option value='2015-2016'>2015-2016</option>
								<option value='2014-2015'>2014-2015</option>
								<option value='2013-2014'>2013-2014</option>
								<option value='2012-2013'>2012-2013</option>
								<option value='2011-2012'>2011-2012</option>
								<option value='2010-2011'>2010-2011</option>
								<option value='2009-2010'>2009-2010</option>
								<option value='2008-2009'>2008-2009</option>
								<option value='2007-2008'>2007-2008</option>
								<option value='2006-2007'>2006-2007</option>
								<option value='2005-2006'>2005-2006</option>
								<option value='2004-2005'>2004-2005</option>
								<option value='2003-2004'>2003-2004</option>
								<option value='2002-2003'>2002-2003</option>
								<option value='2001-2002'>2001-2002</option>
								<option value='2000-2001'>2000-2001</option>
								<option value='1999-2000'>1999-2000</option>
								<option value='1998-1999'>1998-1999</option>
								<option value='1997-1998'>1997-1998</option>
								<option value='1996-1997'>1996-1997</option>
								<option value='1995-1996'>1995-1996</option>
								<option value='1994-1995'>1994-1995</option>
								<option value='1993-1994'>1993-1994</option>
								<option value='1992-1993'>1992-1993</option>
								<option value='1991-1992'>1991-1992</option>
								<option value='1990-1991'>1990-1991</option>
								<option value='1989-1990'>1989-1990</option>
								<option value='1988-1989'>1988-1989</option>
								<option value='1987-1988'>1987-1988</option>
								<option value='1986-1987'>1986-1987</option>
								<option value='1985-1986'>1985-1986</option>
								<option value='1984-1985'>1984-1985</option>
								<option value='1983-1984'>1983-1984</option>
								<option value='1982-1983'>1982-1983</option>
								<option value='1981-1982'>1981-1982</option>
								<option value='1980-1981'>1980-1981</option>
								<option value='1979-1980'>1979-1980</option>
								<option value='1978-1979'>1978-1979</option>
								<option value='1977-1978'>1977-1978</option>
								<option value='1976-1977'>1976-1977</option>
								<option value='1975-1976'>1975-1976</option>
								<option value='1974-1975'>1974-1975</option>
								<option value='1973-1974'>1973-1974</option>
								<option value='1972-1973'>1972-1973</option>
								<option value='1971-1972'>1971-1972</option>
								<option value='1970-1971'>1970-1971</option>
								<option value='1969-1970'>1969-1970</option>
								<option value='1968-1969'>1968-1969</option>
								<option value='1967-1968'>1967-1968</option>
								<option value='1966-1967'>1966-1967</option>
								<option value='1965-1966'>1965-1966</option>
								<option value='1964-1965'>1964-1965</option>
								<option value='1963-1964'>1963-1964</option>
								<option value='1962-1963'>1962-1963</option>
								<option value='1961-1962'>1961-1962</option>
								<option value='1960-1961'>1960-1961</option>
								<option value='1959-1960'>1959-1960</option>
								<option value='1958-1959'>1958-1959</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Tipo de Escuela:</label>
							<select class='form-control form-control-alternative' name='tipo_escuela' id='tipo_escuela' required>
								<option value=''>Selecciona una opción</option>
								<option value='GENERAL'>General</option>
								<option value='TECNICA'>Tecnica</option>
								<option value='PARTICULAR'>Particular</option>
								<option value='TELESECUNDARIA'>Telesecundaria</option>
								<option value='P/TRAB'>P/TRAB</option>
								<option value='NOCTURNA'>Nocturna</option>
							</select>
						</div>
					</div>
					<hr class='my-4' />
					<div class='row'>
						<br><br><br>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>¿Reprobó materias al término del ciclo escolar?</label>
							<select class='form-control form-control-alternative' name='reprobo_materias' id='reprobo_materias' required>
								<option value=''>Selecciona una opción</option>
								<option value='SI'>Si</option>
								<option value='NO'>No</option>
							</select>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Presento extraodinarios en:</label>
							<select class='form-control form-control-alternative' name='presento_extras' id='presento_extras'>
								<option value='0' disabled selected>Selecciona una opción</option>
								<option value='AGOSTO'>Agosto</option>
								<option value='SEPTIEMBRE'>Septiembre</option>
								<option value='FEBRERO'>Febrero</option>
							</select>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Año:</label>
							<input class='form-control form-control-alternative' type='text' name='year_extras' id='year_extras' placeholder='Año..'>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>¿Estudió los 3 años en la misma esc.?</label>
							<select class='form-control form-control-alternative' name='estudio_siempre' id='estudio_siempre' required>
								<option value=''>Selecciona una opción</option>
								<option value='SI'>Si</option>
								<option value='NO'>No</option>
							</select>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Nombre de la esc. anterior:</label>
							<input class='form-control form-control-alternative' type='text' name='nom_esc_ant' id='nom_esc_ant' placeholder='Escuela anterior..'>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Grados:</label>
							<select class='form-control form-control-alternative' type='text' name='grado_ant' id='grado_ant'>
								<option value=''>Selecciona una opción</option>
								<option value='1'>1er grado</option>
								<option value='2'>2do grado</option>
								<option value='1 y 2'>1ro y 2do grado</option>
							</select>
							<input type='hidden' name='fecha' id='fecha' value='$hoy'>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Correo Electronico:</label>
							<input class='form-control form-control-alternative' type='email' name='email' id='email' value='$correo' placeholder='nombre@example.com' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Teléfono</label>
							<input class='form-control form-control-alternative' type='text' name='tel' id='tel' value='$tel' placeholder='Tel. Celular' maxlength='10' required>
							<input type='hidden' name='al_id' id='al_id' value='$al_id'>
							<input type='hidden' name='id' id='id' value='$id'>
							<input type='hidden' name='origen' id='origen' value='$origen'>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>&nbsp;</label>
		                    <div class='custom-control custom-control-alternative custom-checkbox'>
		                      <input class='custom-control-input' id='core' name='core' type='checkbox' value='SI'>
		                      <label class='custom-control-label' for='core'>
		                        <span class='text-muted'>¿Requiere corrección en CURP?</span>
		                      </label>
		                    </div>
		                </div>
						<div class='col-lg-12 form-group text-center'>
							<button type='submit' id='btsubmit' class='btn btn-info'>Generar Solicitud</button>
						</div>
					</div>
				</form>";

}if ($tramite == 'Duplicado Boleta de Secundaria') {
	$llenado = "<form action='bol_secundaria.php' method='post' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
					<div class='row margen'>
						<div class='col-lg-12 form-group text-center'>
								<label>Solicitud Duplicado Boleta de Secundaria</label>
						</div>
						<div class='col-12 formulario'>
							<label class='col-3'>CURP:</label>
							<input class='col-3 form-control-sm' type='text' name='curp' id='curp' placeholder='CURP..' maxlength='18' required>
							<label class='col-1'>Tel.</label>
							<input class='col-3 form-control-sm' type='text' name='tel' id='tel' placeholder='Tel. Celular' maxlength='10' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Correo Electronico:</label>
							<input class='col-4 form-control-sm' type='text' name='email' id='email' placeholder='nombre@example.com' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Nombre Alumno:</label>
							<input class='col-3 form-control-sm' type='text' name='alumno' id='alumno' placeholder='Nombre(s)' required>
							<input class='col-2 form-control-sm' type='text' name='a_paterno' id='a_paterno' placeholder='Primer Apellido' required>
							<input class='col-2 form-control-sm' type='text' name='a_materno' id='a_materno' placeholder='Segundo Apellido' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Clave Escuela:</label>
							<input class='col-3 form-control-sm' type='text' name='cct' id='cct' placeholder='Clave de la Escuela..' maxlength='10' required>
							<label class='col-2'>Nom. Escuela:</label>
							<input class='col-3 form-control-sm' type='text' name='escuela' id='escuela' placeholder='Escuela..' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Dom. Escuela:</label>
							<input class='col-4 form-control-sm' type='text' name='dom_esc' id='dom_esc' placeholder='Domicilio..'>
							<label class='col-2'>Turno:</label>
							<select class='form-control-sm col-2' name='turno' id='turno' required>
								<option value='0' selected disabled>Turno..</option>
								<option value='MAT'>Matutino</option>
								<option value='VES'>Vespertino</option>
							</select>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Tipo de Escuela:</label>
							<select class='form-control-sm col-3' name='tipo_escuela' id='tipo_escuela' required>
								<option value='0' disabled selected>Selecciona una opción</option>
								<option value='GENERAL'>General</option>
								<option value='TECNICA'>Tecnica</option>
								<option value='PARTICULAR'>Particular</option>
								<option value='TELESECUNDARIA'>Telesecundaria</option>
								<option value='P/TRAB'>P/TRAB</option>
								<option value='NOCTURNA'>Nocturna</option>
							</select>
						</div>									
						<div class='col-12 espacios'>
							<label class='col-3'>Periodo Escolar:</label>
							<input class='col-2 form-control-sm' type='text' name='de' id='de' placeholder='Del Año' required>
							<input class='col-2 form-control-sm' type='text' name='a' id='a' placeholder='Al Año'>
							<label class='col-2'>Grado(s):</label>
							<input class='col-2 form-control-sm' type='text' name='grado' id='grado' placeholder='Grado(s)..' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Grupo:</label>
							<input class='col-2 form-control-sm' type='text' name='grupo' id='grupo' placeholder='Grupo.' required>
							<label class='col-3'>¿Reprobó Materias?</label>
							<select class='form-control-sm col-3' name='reprobo_materias' id='reprobo_materias' required>
								<option value='0' disabled selected>Selecciona una opción</option>
								<option value='SI'>Si</option>
								<option value='NO'>No</option>
							</select>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>¿Periodo que Presentó?</label>
							<select class='form-control-sm col-2' name='presento_extras_en' id='presento_extras_en'>
								<option value='0' disabled selected>Seleccionar opción</option>
								<option value='AGOSTO'>Agosto</option>
								<option value='SEPTIEMBRE'>Septiembre</option>
								<option value='FEBRERO'>Febrero</option>
							</select>
							<label class='col-2'>¿Cuales debe?</label>
							<input class='col-4 form-control-sm' type='text' name='cuales_debe' id='cuales_debe' placeholder='Materias que debe..'>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Selecciona tu Fotografía:</label>
							<input class='col-5 form-control-sm btn' type='file' name='foto' id='foto'>
							<input type='hidden' name='fecha' id='fecha' value='$hoy'>
						</div>
						<div class='col-12 text-center espacioF'>
							<button type='submit' id='btsubmit' class='btn btn-primary'>Enviar Solicitud</button>
						</div>
					</div>
				</form>";
}if ($tramite == 'Revalidación y Equivalencias') {
	$llenado = "<form action='rev_eq.php' method='post' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
					<div class='row margen'>
						<div class='row col-12 justify-content-center espacios'>
								<label>Solicitud Revalidación y Equivalencias</label>
						</div>
						<div class='row col-12 justify-content-center espacios'>
								<label><b>Datos Personales:</b></label>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Solicitud de dictamen de:</label>
							<select class='form-control-sm col-3' name='dictamen' id='dictamen' required>
								<option value='0' disabled selected>Seleccionar opción</option>
								<option value='REVALIDACION'>Revalidación</option>
								<option value='EQUIVALENCIA'>Equivalencia</option>
							</select>
						</div>
						<div class='col-12 formulario'>
							<label class='col-3'>CURP:</label>
							<input class='col-3 form-control-sm' type='text' name='curp' id='curp' placeholder='CURP..' maxlength='18'>
							<label class='col-1'>Tel.</label>
							<input class='col-3 form-control-sm' type='text' name='tel' id='tel' placeholder='Tel. Celular' maxlength='15' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Correo Electronico:</label>
							<input class='col-4 form-control-sm' type='text' name='email' id='email' placeholder='nombre@example.com' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-3'>Nombre Alumno:</label>
							<input class='col-3 form-control-sm' type='text' name='alumno' id='alumno' placeholder='Nombre(s)' required>
							<input class='col-2 form-control-sm' type='text' name='a_paterno' id='a_paterno' placeholder='Primer Apellido' required>
							<input class='col-2 form-control-sm' type='text' name='a_materno' id='a_materno' placeholder='Segundo Apellido' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-2'>Sexo:</label>
							<select class='form-control-sm col-3' name='sexo' id='sexo' required>
								<option value='0' disabled selected>Seleccionar opción</option>
								<option value='MASCULINO'>Masculino</option>
								<option value='FEMENINO'>Femenino</option>
							</select>
							<label class='col-2'>Domicilio:</label>
							<input class='col-4 form-control-sm' type='text' name='domicilio' id='domicilio' placeholder='Calle, num. y colonia..' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-2'>Nacionalidad:</label>
							<input class='col-3 form-control-sm' type='text' name='nacionalidad' id='nacionalidad' placeholder='Nacionalidad..' required>
							<label class='col-3'>Pais/Estado donde cursé mis estudios:</label>
							<input class='col-3 form-control-sm' type='text' name='pais_estado' id='pais_estado' placeholder='Pais/Estado' required>
						</div>
						<div class='row col-12 justify-content-center espacios'>
								<label><b>Deseo ingresar o estoy inscrito(a) en la Escuela:</b></label>
						</div>
						<div class='col-12 espacios'>
							<label class='col-2'>Escuela:</label>
							<input class='col-3 form-control-sm' type='text' name='escuela' id='escuela' placeholder='Nombre de la Escuela...' required>
							<label class='col-2'>En el grado:</label>
							<input class='col-3 form-control-sm' type='text' name='grado' id='grado' placeholder='Grado..' required>
						</div>
						<div class='col-12 espacios'>
							<label class='col-6'>Deseo revalidar o hacer equivalentes mis estudios de:</label>
							<select class='form-control-sm col-3' name='revalidar_de' id='revalidar_de' required>
								<option value='0' disabled selected>Seleccionar opción</option>
								<option value='PRIMARIA'>Primaria</option>
								<option value='SECUNDARIA'>Secundaria</option>
							</select>
							<input type='hidden' name='fecha' id='fecha' value='$hoy'>
						</div>
						<div class='col-12 text-center espacioF'>
							<button type='submit' id='btsubmit' class='btn btn-primary'>Enviar Solicitud</button>
						</div>
					</div>
				</form>";
}if ($tramite == 'Estatus') {
	$llenado = "<form action='verifica.php' method='POST' onsubmit='return checkSubmit();'>
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

				
}if ($tramite == 'Estado') {
	$llenado = "<form action='verifica_baja.php' method='POST' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>
						<div class='row col-12 justify-content-center espacios'>
							<div class='col-lg-4 form-group'>
								<label class='form-control-label'>CURP del alumno:</label>
								<input class='form-control form-control-alternative' type='text' name='curp' id='curp' placeholder='Curp' maxlength='18' required>
							</div>
						</div>
			
						<div class='col-lg-12 form-group text-center'>
							<button type='submit' id='btsubmit' class='btn btn-info'>Consultar</button>
						</div>
					</div>
				</form>";

				
}if ($tramite == 'Baja') {
	$llenado = "<form action='baja_reg.php' method='POST' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>
						<div class='row col-12 justify-content-center espacios'>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>CURP:</label>
							<input class='form-control form-control-alternative' type='text' name='curp' id='curp' placeholder='CURP..' maxlength='18' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Nombre completo del alumno:</label>
							<input class='form-control form-control-alternative' type='text' name='nombre' id='nombre' placeholder='Nombre del alumno' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Clave escuela donde se encuentra inscrito:</label>
							<input class='form-control form-control-alternative' type='text' name='cct' id='cct' placeholder='Clave de la Escuela..' maxlength='10' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Nombre Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='escuela' id='escuela' placeholder='Escuela..' maxlength='45' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>Grado:</label>
							<input class='form-control form-control-alternative' type='number' name='grado' id='grado' placeholder='Grado' required>
						</div>
						<div class='col-lg-2 form-group'>
							<label class='form-control-label'>Grupo:</label>
							<input class='form-control form-control-alternative' type='text' name='grupo' id='grupo' placeholder='Grupo' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Domicilio Escuela:</label>
							<input class='form-control form-control-alternative' type='text' name='dom_esc' id='dom_esc' placeholder='Domicilio' maxlength='70' required>
						</div>
						
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Correo Electronico:</label>
							<input class='form-control form-control-alternative' type='email' name='email' id='email' placeholder='nombre@example.com' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Telefono:</label>
							<input class='form-control form-control-alternative' type='text' name='tel' id='tel' placeholder='Número a 10 dígitos' maxlength='10' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Motivo de baja:</label>
							<select class='form-control form-control-alternative' name='motivo' id='motivo' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='Cambio de domicilio'>Cambio de domicilio</option>
								<option value='Cambio de estado'>Cambio de estado</option>
								<option value='Deseo que ingrese a otra escuela'>Deseo que ingrese a otra escuela</option>
							</select>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Quien solicita la baja:</label>
							<select class='form-control form-control-alternative' name='realiza' id='realiza' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='PADRE'>Padre de Familia</option>
								<option value='MADRE'>Madre de Familia</option>
								<option value='TUTOR'>Tutor</option>
							</select>
						</div>
						<div class='row col-12 justify-content-center'>

	                      <h4 align='center' class=''><b class='text-danger'>Los formatos permitidos para la carga de documentos son PNG, JPEG Y JPG, con un peso máximo de 2 MB.</b></h4>
	                    </div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Identificación del padre o tutor: (2 MB)*</label>
							<input class='' type='file' name='identificacion' id='identificacion' accept='image/*' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Acta de Nacimiento del alumno: (2 MB)*</label>
							<input class='' type='file' name='acta' id='acta' accept='image/*' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>CURP del alumno: (2 MB)*</label>
							<input class='' type='file' name='curpf' id='curpf' accept='image/*' required>
						</div>
						<div class='col-lg-12 form-group text-center'>
							<input type='submit' id='btsubmit' class='btn btn-info' value='Generar Solicitud' />
						</div>
					</div>
				</form>";

				
}
// SE AGREGA LA REVOCACIÓN 
if ($tramite == 'estatusRevocacion') {	
	$llenado = "<form action='estatus_revocacion.php' method='POST' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>
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
				</form>";

}if ($tramite == 'revocacion') {

	$llenado = "<form action='revocacion.php' method='POST' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
	<hr class='my-4' />
	<div class='row'>
		<div class='row col-12 justify-content-center espacios'>
		</div>
		<div class='col-lg-3 form-group' >
			<label class='form-control-label'>CURP del alumno:</label>
			<input class='form-control form-control-alternative' type='text' name='curp' id='curp' placeholder='CURP..' maxlength='18' onkeyup='mayus(this)' required>
		</div>		
		
		<div class='col-lg-3 form-group'>
			<label class='form-control-label'>Quien solicita la revocación:</label>
			<select class='form-control form-control-alternative' name='parentesco' id='parentesco' required>
				<option value='' disabled selected>Selecciona una opción</option>
				<option value='PADRE'>Padre de Familia</option>
				<option value='MADRE'>Madre de Familia</option>
				<option value='TUTOR'>Tutor Legal</option>
			</select>
		</div>
        <div class='col-lg-6 form-group'>
			<label class='form-control-label'>Nombre completo de quien solicita la revocación:</label>
			<input class='form-control form-control-alternative' type='text' name='nombre_padre' id='nombre_padre' placeholder='Nombre del responsable' required>
		</div>
		   
		<div class='col-lg-4 form-group' >
			<label class='form-control-label'>Tel. del padre o tutor:</label>
			<input class='form-control form-control-alternative' type='text' name='tel' id='tel' placeholder='Tel. Celular' maxlength='10' required>
		</div>
		<div class='col-lg-6 form-group' >
			<label class='form-control-label'>Correo electrónico del padre o tutor:</label>
			<input class='form-control form-control-alternative' type='email' name='email' id='email' placeholder='nombre@example.com' required>
		</div>
		<div class='col-lg-2 form-group' >
		</div>
		
		<div class='col-lg-11 form-group'>
    		<label class='form-control-label'><b>Motivo de la revocación (hasta 400 caracteres): </b><span></span></label>
   			<textarea class='col-md-11 form-control' id='motivo' name='motivo' rows='4' maxlength='400' required></textarea >
  		</div>    
		
		<div class='row col-12 justify-content-center'>
		  <h4 align='center' class=''><b class='text-danger'>Los formatos permitidos para la carga de documentos son PDF, PNG, JPEG Y JPG, con un peso máximo de 2 MB.</b></h4>
		</div>
		<div class='col-lg-4 form-group'>
			<label class='form-control-label'>Identificación del padre o tutor: (2 MB)*</label>
			<input class='' type='file' name='identificacion' id='identificacion' accept='application/pdf, image/*' required>
		</div>
		<div class='col-lg-4 form-group'>
			<label class='form-control-label'>Acta de Nacimiento del alumno: (2 MB)*</label>
			<input class='' type='file' name='actafile' id='actafile' accept='application/pdf, image/*' required>
		</div>
		
		<div class='col-lg-4 form-group'>
			<label class='form-control-label'> Anexo 8: (2 MB)*</label>
			<input class='' type='file' name='anexo8' id='anexo8' accept='application/pdf, image/*' required>
		</div>
		
		
		<div class='col-lg-12 form-group text-center'>
			<input type='submit' id='btsubmit' class='btn btn-info' value='Generar Solicitud' />
		</div>
	</div>
</form>";
}if ($tramite == 'estatus_vp') {
	$llenado = "<form action='verifica_baja.php' method='POST' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>
						<div class='row col-12 justify-content-center espacios'>
							<div class='col-lg-4 form-group'>
								<label class='form-control-label'>CURP del alumno:</label>
								<input class='form-control form-control-alternative' type='text' name='curp' id='curp' placeholder='Curp' maxlength='18' required>
							</div>
						</div>
			
						<div class='col-lg-12 form-group text-center'>
							<button type='submit' id='btsubmit' class='btn btn-info'>Consultar</button>
						</div>
					</div>
				</form>";

				
}if ($tramite == 'vp_ma') {
	$llenado = "<form action='vinculacion_registrop.php' method='POST' enctype='multipart/form-data' onsubmit='return checkSubmit();'>
					<hr class='my-4' />
					<div class='row'>
						<div class='row col-12 justify-content-center espacios'>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Tipo de vinculación</label>
							<select class='form-control form-control-alternative' name='tipo' id='tipo' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='CONSANGUINEO'>CONSANGUÍNEO</option>
								<option value='AFINIDAD'>AFINIDAD</option>
							</select>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>CURP Estudiante:</label>
							<input class='form-control form-control-alternative' type='text' name='curp' id='curp' placeholder='CURP..' maxlength='18' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>CURP Profesor:</label>
							<input class='form-control form-control-alternative' type='text' name='curpd' id='curpd' placeholder='CURP..' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>CCT Profesor:</label>
							<input class='form-control form-control-alternative' type='text' name='cct' id='cct' placeholder='Clave de la Escuela..' maxlength='10' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Turno:</label>
							<select class='form-control form-control-alternative' name='turno' id='turno' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='MAT'>MATUTINO</option>
								<option value='VES'>VESPERTINO</option>
							</select>
						</div>
										
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Correo Electrónico Institucional del Profesor:</label>
							<input class='form-control form-control-alternative' type='email' name='email' id='email' placeholder='nombre@example.com' required>
						</div>
						<div class='col-lg-3 form-group'>
							<label class='form-control-label'>Teléfono del Profesor:</label>
							<input class='form-control form-control-alternative' type='text' name='tel' id='tel' placeholder='Número a 10 dígitos' maxlength='10' required>
						</div>
						<div class='col-lg-4 form-group'>
							<label class='form-control-label'>Quien realiza la vinculación:</label>
							<select class='form-control form-control-alternative' name='responsable' id='responsable' required>
								<option value='' disabled selected>Selecciona una opción</option>
								<option value='Carlos Leal'>Carlos Leal</option>
								<option value='Rocío Reséndiz'>Rocío Reséndiz</option>
							</select>
						</div>
						
						<div class='row col-12 justify-content-center'>

	                      <h4 align='center' class=''><b class='text-danger'>Cargar en PDF con un peso máximo de 2 MB, INE del docente, Acta de Nacimiento del estudiante, si es el caso de una vinculación por afinidad adjuntar documento legal.</b></h4>
	                    </div>
						<div class='row col-12 justify-content-center'>
							<label class='form-control-label'>Documento PDF: (2 MB)*</label>
							<input class='' type='file' name='identificacion' id='identificacion' accept='application/pdf' required>
						</div>
						<div class='row col-12 justify-content-center espacios'>
						<label class='form-control-label'> </label>
						<label class='form-control-label'> </label>
						</div>
						<div class='row col-12 justify-content-center'>
							
						</div>
						<div class='row col-12 justify-content-center espacios'>
							<input type='submit' id='btsubmit' class='btn btn-info' value='Generar Solicitud'  />
						</div>
					</div>
				</form>";

				
}




echo $llenado;

$consulta = null;
$user = null;
$conexion = null;

?>