<?php

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;

App::uses('Debugger', 'Utility');        

//javascript da pagina
echo $this->Html->script('cadastro.js', array('inline' => false));
echo $this->fetch('script');

?>

<div class="form_cadastro">
<?php echo $this->Form->create('participante',array('action'=>'editaParticipante', 'enctype' => 'multipart/form-data')); ?>
    <fieldset>
        <legend>Editar</legend>
        <?php 

            echo $this->Session->flash();

        	echo $this->Form->input('login',array('label'=>'', 'placeholder'=>'Login', 'value'=>$dados['participante'][0]['Participante']['login']));
        	echo $this->Form->input('senha',array('label'=>'', 'placeholder'=>'Senha'));
        	echo $this->Form->input('nomeCompleto',array('label'=>'', 'placeholder'=>'Nome completo', 'value'=>$dados['participante'][0]['Participante']['nomeCompleto']));

            echo $this->Form->input('estado',array('label'=>'', 'options'=>$dados['estados'],'empty'=>'Selecione um estado'));
            echo $this->Form->input('cidade',array('label'=>'', 'options'=>$dados['cidades'],'empty'=>'Selecione uma cidade'));

        	echo $this->Form->input('email',array('label'=>'', 'type'=>'email','placeholder'=>'E-mail', 'value'=>$dados['participante'][0]['Participante']['email']));
        	echo $this->Form->input('arquivoFoto',array('label'=>'', 'placeholder'=>'Foto', 'type' => 'file'));
			echo $this->Form->input('descricao',array('label'=>'', 'placeholder'=>'Descrição', 'value'=>$dados['participante'][0]['Participante']['descricao']));

        	?><hr><?php
        	echo $this->Form->end(__('Salvar'));
    	?>
    </fieldset>
</div>
