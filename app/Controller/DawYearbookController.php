<?php

App::uses('AppController', 'Controller');


class DawYearbookController extends AppController {

	public $uses = array();
	public $components = array('Cookie');

	public function index() {
		
		$this->loadModel('Participante');
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}

		//verifica se existe cookie para o login
		$login_cookie = $this->Cookie->read('login');
		$senha_cookie = $this->Cookie->read('senha');

		$participantes = $this->Participante->find('list', array(
	        'fields' => array('Participante.login', 'Participante.arquivoFoto'),
	        'limit' => 10
	    ));

		$title_for_layout = 'Year Book !';

		$this->set(compact('page', 'subpage', 'title_for_layout', 'login_cookie', 'senha_cookie', 'participantes'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
}
