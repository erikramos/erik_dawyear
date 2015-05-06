<?php

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;

App::uses('Debugger', 'Utility');

?>

<section id="dadosUsuario">
	<?php echo $this->Session->flash(); ?>
	
	<?php
        foreach ($participantes as $key => $value) {
            echo $this->Html->link(
                $this->Html->image('upload/'.$value['Participante']['arquivoFoto'], array('style'=>'border: 1px solid gray;display: inline-block; width:170px; height:190px;', 'title' => $value['Participante']['login'], 'alt' => $value['Participante']['login'], 'border' => '0', 'id' => 'img_thumb')), '/participantes/perfil_participante/'.$value['Participante']['login'],
                    array('target' => '_blank', 'escape' => false, 'id'=>'link_thumb')
            );
        }
    ?>
</section>
