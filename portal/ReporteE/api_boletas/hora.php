<?php

	$hora = date('d-m-Y H:i:s');
	echo "La hora del servidor es: ".$hora."<br>";

	// Suma 2 horas a la hora actual
	$nueva_hora = date("d-m-Y H:i:s", strtotime($hora . "+22 hours"));

	// Muestra la nueva hora
	echo "Hora actual con 22 horas sumadas: ".$nueva_hora."<br>";
	echo "*************** Se intenta validar la diferencia entre dos fechas ***************<br>";

	// Obtén la fecha y hora actual
	$fecha_actual = new DateTime();

	// Fecha almacenada en la variable (puedes cambiar esta fecha según tus necesidades)
	$fecha_almacenada = new DateTime("2023-11-21 00:30:00");

	// Calcula la diferencia en horas
	$diferencia = $fecha_actual->diff($fecha_almacenada);

	// Obtiene la diferencia total en horas
	$horas_diferencia = $diferencia->h + ($diferencia->days * 24);

	// Muestra la diferencia en horas
	echo "Diferencia en horas: " . $horas_diferencia . " horas<br>";

	if ($horas_diferencia >= 22) {
		echo "Ya es hora de renovar el token<br>";
	}
	else {
		echo "El token aun es valido :D<br>";
	}

?>