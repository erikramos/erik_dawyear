<?php

$mostra_menu = 1;
$nao_verificar = array('/index.php/participantes/cadastrar');

if(!in_array($this->here, $nao_verificar)){

	//verifica se o usuario possui uma sessao válida
	if(count($this->Session->read('usuario')) == 0){

		echo (utf8_encode('<div class="error-message">Login necess&aacute;rio ! '));	
		echo $this->Html->link('Clique aqui.', '/', array('escape' => false));
		echo ('</div>');
		die();
	}
}else{
	$mostra_menu = 0;
}

$descricaoTurma = 'Turma de Pós-graduação em Desenvolvimento de Sistemas Web !';
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>		
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('css_site');				
		echo $this->Html->script('jquery_2.1.1.js', array('inline' => false));		

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<section id="header">
			<?php 
				echo $this->Html->link(
						$this->Html->image('header_img.jpg', array('alt' => $descricaoTurma, 'border' => '0', 'id' => 'img_cabecalho')),
							'http://www.pucminas.br/virtual/',
							array('target' => '_blank', 'escape' => false, 'id'=>'link_cabecalho')
					);
			?>	
			<?php if($mostra_menu == 1){ ?>
				<div id="menu_superior">
					<ul id="menu">					
						<li><?php echo $this->Html->link('HOME', '/painel/', array('escape' => false)); ?></li>
						<li><?php echo $this->Html->link('EXCLUIR', '/participantes/excluir_perfil', array('escape' => false)); ?></li>
						<li><?php echo $this->Html->link('EDITAR', '/participantes/editar_perfil', array('escape' => false)); ?></li>
						<li><?php echo $this->Html->link('LOGOUT', '/participantes/logout', array('escape' => false)); ?></li>			
					</ul>
				</div>
			<?php } ?>
		</section>
		<section id="content">

			<?php echo $this->fetch('content'); ?>
		</section>
		<section id="footer">
			<?php 
				echo $this->Html->link(
						$this->Html->image('cake.power.gif', array('alt' => $cakeVersion, 'border' => '0')),
							'http://cakephp.org/',
							array('target' => '_blank', 'escape' => false)
					);
			?>
		</section>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>	
</html>
