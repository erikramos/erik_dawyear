<?php


App::uses('AppController', 'Controller');


class PainelController extends AppController {


	public $uses = array();	

	public function index() {		

		$this->loadModel('Participante');
		$this->loadModel('Cidade');

		$usuario = $this->Session->read('usuario');

		$participantes = $this->Participante->find('list', array(
	        'fields' => array('Participante.login', 'Participante.arquivoFoto'),
	        'limit' => 20
	    ));

	    $usuario = $this->Participante->find('all', array(
	        'fields' => array('Participante.arquivoFoto','Participante.login','Participante.nomeCompleto','Participante.email','Participante.cidade','Participante.descricao'),
	        'conditions' => array('Participante.login =' => $usuario['login']),
	    ));

	    $cidade = $this->Cidade->find('all', array(
	        'fields' => array('Cidade.*'),
	        'conditions' => array('Cidade.idCidade =' => $usuario[0]['Participante']['cidade']),
	    ));

		$this->layout='site';
		$this->set(compact('usuario', 'participantes', 'cidade'));
	}

	public function pesquisa($login){

		$this->loadModel('Participante');

		$participantes = $this->Participante->find('all', array(
	        'fields' => array('Participante.login', 'Participante.arquivoFoto'),
	        'conditions' => array('Participante.login LIKE' => '%'.$login.'%')
	    ));		

		$this->layout='site';
	 	$this->set(compact('participantes'));   
	}
}


