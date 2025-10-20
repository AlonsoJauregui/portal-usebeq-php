$('#entrada').on('change', function(){
	var tramite = $('#entrada').val();
	$.ajax({
		url:'llenado_form.php',
		type: 'POST',
		data: {'tramite': tramite}
	})
	.done(function(respuesta) {
		$('#dato').html(respuesta);
	})
	.fail(function() {
		console.log("error");
	})
});