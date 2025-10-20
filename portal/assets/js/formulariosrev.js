$('#entrada').on('change', function(){
	var tramite = $('#entrada').val();
	var al_id = $('#al_id').val();
	var id = $('#id').val();
	$.ajax({
		url:'llenado_formrev.php',
		type: 'POST',
		data: {'tramite': tramite, 'al_id': al_id, 'id': id}
	})
	.done(function(respuesta) {
		$('#dato').html(respuesta);
	})
	.fail(function() {
		console.log("error");
	})
});