<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

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
		echo $this->Html->css('cake.generic');

		echo $this->Html->script('jquery_2.1.1.js', array('inline' => false));
		echo $this->Html->script('login.js', array('inline' => false));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<section id="header">
			<?php echo $this->Html->link(
				$this->Html->image('header_img.jpg', array('alt' => $descricaoTurma, 'border' => '0', 'id' => 'img_cabecalho')),
					'http://www.pucminas.br/virtual/',
					array('target' => '_blank', 'escape' => false, 'id'=>'link_cabecalho')
				);
			?>	
		</section>
		<section id="content">
			<?php echo $this->fetch('content'); ?>
		</section>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>	
</html>
