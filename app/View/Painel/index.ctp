<?php

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;

App::uses('Debugger', 'Utility');

//javascript da pagina
echo $this->Html->script('painel.js', array('inline' => false));
echo $this->fetch('script');

?>

<?php
    $usuario = $this->Session->read('usuario');    

    if($cidade[0]["Cidade"]['nomeCidade'] != null && $cidade[0]["Cidade"]['nomeCidade'] != '')
    	$cidade = $cidade[0]["Cidade"]['nomeCidade'];
    else
    	$cidade = '';
?>

<section id="dadosUsuario">
	<?php echo $this->Session->flash(); ?>
	<div class="escuro"><div id="titulo_dado_pessoal"><strong>Nome: </strong></div><?php echo $usuario['nomeCompleto']; ?></div>
	<div class="claro"><div id="titulo_dado_pessoal"><strong>Login: </strong></div><?php echo $usuario['login']; ?></div>
	<div class="escuro"><div id="titulo_dado_pessoal"><strong>Cidade: </strong></div><?php echo $cidade; ?></div>
	<div class="claro"><div id="titulo_dado_pessoal"><strong>E-mail: </strong></div><?php echo $usuario['email']; ?></div>
	<div class="escuro"><div id="titulo_dado_pessoal"><strong>Descri&ccedil;&atilde;o: </strong></div><?php echo $usuario['descricao']; ?></div>

	<div class="claro"><div id="titulo_dado_pessoal"><strong>Pesquisa: </strong></div><?php echo $this->Form->input('pesquisa',array('style'=>'width:150px;height:25px;', 'label'=>'', 'placeholder'=>'login...')); ?></div>
	
	<hr />	
	<div id="div_tumbnail">
		<?php
            foreach ($participantes as $key => $value) {
                echo $this->Html->link(
                    $this->Html->image('upload/'.$value, array('style'=>'border: 1px solid gray;display: inline-block; width:65px; height:45px;', 'title' => $key, 'alt' => $key, 'border' => '0', 'id' => 'img_thumb')), '/participantes/perfil_participante/'.$key,
                        array('target' => '_blank', 'escape' => false, 'id'=>'link_thumb')
                );
            }
        ?>            
	</div>
</section>
