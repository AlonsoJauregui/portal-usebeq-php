$(buscar_datos());

function buscar_datos(consulta) {
	$.ajax({
		url:'historial.php',
		type: 'POST',
		dataType: 'html',
		data: {consulta: consulta},
	})
	.done(function(respuesta) {
		$("#res").html(respuesta);
	})
	.fail(function() {
		console.log("error");
	})
}

$(document).on('keyup', '#caja_busqueda', function(){
	var valor = $(this).val();
	if (valor != "") {
		buscar_datos(valor);
	} else {
		buscar_datos();
	}
});

$(busqueda());


function busqueda(valor) {
	$.ajax({
		url:'llenado_fotos.php',
		type: 'POST',
		dataType: 'html',
		data: {valor: valor},
	})
	.done(function(respuesta) {
		$("#datos").html(respuesta);
	})
	.fail(function() {
		console.log("error");
	})
}

$(document).on('keyup', '#caja', function(){
	var valor = $(this).val();
	if (valor != "") {
		buscar_datos(valor);
	} else {
		buscar_datos();
	}
});



/*$('#caja').on('keyup', function(){
	var valor = $('#caja').val();
//	alert(motivo)
	$.ajax({
		url:'llenado_fotos.php',
		type: 'POST',
		data: {valor: valor}
	})
	.done(function(respuesta) {
		$("#datos").html(respuesta);
	})
	.fail(function() {
		console.log("error");
	})
});*/