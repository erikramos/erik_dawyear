

//função executada ao carregar o DOM da pagina
$(document).ready(function () { 

	$('#participanteLogin').focus();

	$('#pesquisa').change(function(){

		location.href="pesquisa/" + $('#pesquisa').val();
	});
});