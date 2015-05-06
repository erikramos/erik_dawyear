

//função executada ao carregar o DOM da pagina
$(document).ready(function () {

	$('#participanteEstado').change(function (){		

		$.ajax({
	        type: 'POST',	        
	        url: 'ajaxBuscarCidades',
	        dataType: 'json',
	        async: false,
	        data: {
	            id: $(this).val()
	        },
	        success: function(json){	        	

	        	var options = "";
	            $.each(json, function(key, value){
	               options += '<option value="' + key + '">' + value + '</option>';
	            });

	            $("#participanteCidade").html(options);
	        	$('#participanteCidade').css('display','block');
	        }
	    });
	});
});