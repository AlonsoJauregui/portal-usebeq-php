$('#entrada').on('change', function(){
	var tramite = $('#entrada').val();
	var al_id = $('#al_id').val();
	var id = $('#id').val();
	var origen = $('#origen').val();
	$.ajax({
		url:'llenado_form.php',
		type: 'POST',
		data: {'tramite': tramite, 'al_id': al_id, 'id': id, 'origen': origen}
	})
	.done(function(respuesta) {
		$('#dato').html(respuesta);
	})
	.fail(function() {
		console.log("error");
	})
});