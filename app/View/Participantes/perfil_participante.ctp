<?php

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;

App::uses('Debugger', 'Utility');
?>

<?php
	
	//verifica se o usuario possui uma sessao válida
	if(count($this->Session->read('usuario')) == 0){

		echo (utf8_encode('<div class="error-message">Login necess&aacute;rio ! '));	
		echo $this->Html->link('Clique aqui.', '/', array('escape' => false));
		echo ('</div>');
		die();
	}    

    if($cidade[0]["Cidade"]['nomeCidade'] != null && $cidade[0]["Cidade"]['nomeCidade'] != '')
    	$cidade = $cidade[0]["Cidade"]['nomeCidade'];
    else
    	$cidade = '';
?>

<section id="dadosUsuario">
	<div class="escuro"><div id="titulo_dado_pessoal"><strong>Nome: </strong></div><?php echo $participante[0]["Participante"]['nomeCompleto']; ?></div>
	<div class="claro"><div id="titulo_dado_pessoal"><strong>Login: </strong></div><?php echo $participante[0]["Participante"]['login']; ?></div>
	<div class="escuro"><div id="titulo_dado_pessoal"><strong>Cidade: </strong></div><?php echo $cidade; ?></div>
	<div class="claro"><div id="titulo_dado_pessoal"><strong>E-mail: </strong></div><?php echo $participante[0]["Participante"]['email']; ?></div>
	<div class="escuro"><div id="titulo_dado_pessoal"><strong>Descri&ccedil;&atilde;o: </strong></div><?php echo $participante[0]["Participante"]['descricao']; ?></div>
	<hr />	
	<div id="img_perfil">
		<?php
			echo $this->Html->image(
				'upload/'.$participante[0]["Participante"]['arquivoFoto'], 
				array('style'=>'border: 1px solid gray;display: inline-block; width:170px; height:190px;',
				'border' => '0', 
				'id' => 'img_thumb_perfil'
			));
		?>
	</div>
</section>
