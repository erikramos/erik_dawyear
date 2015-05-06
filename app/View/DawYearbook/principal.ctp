<?php

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;

App::uses('Debugger', 'Utility');

//carrega o javascript da pagina
echo $this->Html->script('painel.js', array('inline' => false));
echo $this->fetch('script');
?>

<div class="form_login">
<?php echo $this->Form->create('participante',array('action'=>'login')); ?>
    <fieldset>
        <legend>Login</legend>
        <?php 

            echo $this->Session->flash();            

            if($login_cookie != '' && $login_cookie != null) $login = $login_cookie; else $login = '';
            if($senha_cookie != '' && $senha_cookie != null) $senha = $senha_cookie; else $senha = '';

        	echo $this->Form->input('login',array('label'=>'', 'placeholder'=>'login', 'value'=>$login));
        	echo $this->Form->input('senha',array('label'=>'', 'type'=>'password', 'placeholder'=>'senha', 'value'=>$senha));
        	echo $this->Form->input('salvar_senha', array('type'=>'checkbox'));
        	echo $this->Html->link('Cadastrar-se !', '/participantes/cadastrar', array('escape' => false));
            echo '<br>';
            echo $this->Html->link('Apagar dados !', '/participantes/apagar_dados', array('escape' => false));
        	echo $this->Form->end(__('Logar'));        	
    	?>
    	<hr />
    	<div id="div_tumbnail">
    		<?php                
                foreach ($participantes as $key => $value) {
                    echo $this->Html->link(
                        $this->Html->image('upload/'.$value, array('style'=>'display: inline-block; width:45px; height:35px;', 'title' => $key, 'alt' => $key, 'border' => '0', 'id' => 'img_thumb')), '/participantes/perfil_participante/'.$key,
                            array('target' => '_blank', 'escape' => false, 'id'=>'link_thumb')
                    );
                }
            ?>            
    	</div>
    </fieldset>
</div>