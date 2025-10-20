$('#entrada').on('change', function(){
	var tramite = $('#entrada').val();
	var cct = $('#cct').val();
	$.ajax({
		url:'llenado_constancia.php',
		type: 'POST',
		data: {'tramite': tramite, 'cct': cct}
	})
	.done(function(respuesta) {
		$('#dato').html(respuesta);
	})
	.fail(function() {
		console.log("error");
	})
});