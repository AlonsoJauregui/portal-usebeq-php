<?php

	include("../conexion.php");
	$flag = 0;
	$flag1 = 0;
	$leyenda = 'Se detectó que su solicitud corresponde a un documento que no se emite desde este servicio, favor de ingresar a: portal.usebeq.edu.mx para consulta y descarga de documentos de acreditación correspondientes al ciclo escolar 2019-2020.';

	$consulta = $conexion->query("SELECT * FROM tramites1 WHERE status = 'SOLICITADO'");

	while ($res = $consulta -> fetch()) {

		$id = $res['id'];
		$curp = $res['curp'];
		$cct = $res['cct'];
		$tramite = $res['tipo_tramite'];

		if ($tramite == 'CERTIFICADO DE PREESCOLAR') {
			$nivel = 'PRE';
		}
		if ($tramite == 'CERTIFICADO DE PRIMARIA') {
			$nivel = 'PRI';
		}
		if ($tramite == 'CERTIFICADO DE SECUNDARIA') {
			$nivel = 'SEC';
		}

		$si_existe = $conexion->query("SELECT dbo.SCE002.nivel FROM dbo.SCE002 INNER JOIN dbo.SCE006 ON dbo.SCE002.eg_id = dbo.SCE006.eg_id INNER JOIN dbo.SCE004 ON dbo.SCE006.al_id = dbo.SCE004.al_id WHERE (dbo.SCE004.al_curp = '$curp') AND (dbo.SCE002.clavecct = '$cct') AND (dbo.SCE004.al_estatus = 'I' OR dbo.SCE004.al_estatus = 'A')");

		foreach($si_existe as $dat1){
			$nivel_busca = $dat1['nivel'];
		}

		if (isset($nivel_busca)) {

			if ($nivel_busca == $nivel) {
				
				echo $curp." con cct: ".$cct." solicito: ".$tramite." y actualmente se encuentra inscrito en: ".$nivel_busca.", no aplica el duplicado.<br>";

				$cambia = $conexion->query("UPDATE tramites1 SET observaciones = '$leyenda', foto = 'SISCER', status = 'SOLICITADO CON ERROR' WHERE id = '$id' AND curp = '$curp'");

				++$flag;

			}
			else {

				echo $curp." con cct: ".$cct." solicito: ".$tramite." y actualmente se encuentra inscrito en: ".$nivel_busca.", si aplica su documento.<br>";

				++$flag1;

			}

		}
		else {

			echo "No aplica.<br>";

		}

	}

	echo "Total de documentos con error: ".$flag."<br>";
	echo "Total de documentos que si aplican: ".$flag1;

?>