<?php


App::uses('AppController', 'Controller');

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class ParticipantesController extends AppController {


	public $uses = array();
	public $components = array('Cookie');		

	public function login() {

		if (!$this->request->is('post')) {
            
            $this->Session->setFlash(utf8_encode('Fa&ccedil;a o login !'));
			return $this->redirect('../');
        }		
		
		$login = htmlspecialchars($this->data['participante']['login']);
		$senha = htmlspecialchars($this->data['participante']['senha']);
		$manter_conectado = $this->data['participante']['salvar_senha'];

		$usuario = $this->Participante->find('all', array(
			 'contain' => array( //campos que vai buscar
			 	'login',
			 	'senha'
			 ),
			 'conditions' => array( //esse e o where
			 	'login' => $login
			 )
		));

		//verifica se encontrou o usuario
		if(count($usuario) > 0){

			if(md5($senha) == $usuario[0]['Participante']['senha']){

				//insere os dados do usuario na sessao para acesso durante a navegacao
				$this->Session->write('usuario', $usuario[0]['Participante']);

				//cria um cookie para o login do usuario
				$this->Cookie->write('login', $login, false, '7 Days');	

				//verifica se o usuario gostaria de permanecer conectado
				if($this->data['participante']['salvar_senha'] == 1)
					$this->Cookie->write('senha', $this->data['participante']['senha'], false, '7 Days');

				//redireciona para a pagina inicial
				return $this->redirect('../painel/');
			}else{
			
				$this->Session->setFlash(utf8_encode('Senha incorreta !'));
				return $this->redirect('../');				
			}
			
		}else{

			$this->Session->setFlash('Usuario inexistente !');
			return $this->redirect('../');
		}
	}

	public function logout() {
		
		//encerra todos os dados da sessão
		$this->Session->destroy();

		$this->Session->setFlash('Sessão encerrada !');
		return $this->redirect('/');
	}

	public function apagar_dados() {
		
		//encerra todos os dados da sessão
		$this->Cookie->write('login', '', false, '-1 Days');
		$this->Cookie->write('senha', '', false, '-1 Days');

		$this->Session->setFlash('Dados apagados !');
		return $this->redirect('/');
	}

	public function cadastrar() {

		$this->loadModel('Estado');
		$this->loadModel('Cidade');

		$estados = $this->Estado->find('list', array(
	        'fields' => array('Estado.idEstado', 'Estado.nomeEstado')	        
	    ));

	    $cidades = $this->Cidade->find('list', array(
	        'fields' => array('Cidade.idCidade', 'Cidade.nomeCidade')	        
	    ));

	    $dados['cidades'] = $cidades;
	    $dados['estados'] = $estados;

		//renderiza a pagina de cadastro
		$this->layout='site';
		$this->set('dados', $dados);
	}
	
	public function ajaxBuscarCidades(){

		$this->request->onlyAllow('ajax');
		$this->layout = 'ajax';		
		$this->autoRender = false;

		$this->loadModel('Cidade');
		$id = htmlspecialchars($this->data['id']);

		$cidades = $this->Cidade->find('list', array(
	        'fields' => array('Cidade.idCidade', 'Cidade.nomeCidade'),
	        'conditions' => array('Cidade.idEstado =' => $id),
	    ));

	    $resp = array();
	    $resp[0] = utf8_encode('Selecione uma cidade');
	    foreach ($cidades as $key => $value) {
	    	$resp[$key] = utf8_encode(htmlspecialchars($value));
	    }

		$this->header('Content-Type: application/json');
		echo json_encode($resp);
	}	

	public function perfil_participante($login){

		$this->loadModel('Participante');		
		$this->loadModel('Cidade');

		$participante = $this->Participante->find('all', array(
	        'fields' => array('Participante.arquivoFoto','Participante.login','Participante.nomeCompleto','Participante.email','Participante.cidade','Participante.descricao'),
	        'conditions' => array('Participante.login =' => $login),
	    ));

	    $cidade = $this->Cidade->find('all', array(
	        'fields' => array('Cidade.*'),
	        'conditions' => array('Cidade.idCidade =' => $participante[0]['Participante']['cidade']),
	    ));	    

	    $this->layout='site';
	    $this->set(compact('participante', 'cidade'));
	}

	public function excluir_perfil(){

		$usuario = $this->Session->read('usuario');

		if($this->Participante->deleteAll(array('Participante.login' => $usuario['login']), false)){

		   $this->Session->setFlash('Perfil deletado !');
		}else{
			$this->Session->setFlash('Erro ao deletar perfil!');
		}

		//encerra todos os dados da sessão
		$this->Cookie->write('login', '', false, '-1 Days');
		$this->Cookie->write('senha', '', false, '-1 Days');
		
		$this->layout='default';
	    $this->redirect('/');
	}

	public function editar_perfil (){

		$this->loadModel('Estado');
		$this->loadModel('Cidade');

		$usuario = $this->Session->read('usuario');

		$estados = $this->Estado->find('list', array(
	        'fields' => array('Estado.idEstado', 'Estado.nomeEstado')	        
	    ));

	    $cidades = $this->Cidade->find('list', array(
	        'fields' => array('Cidade.idCidade', 'Cidade.nomeCidade')	        
	    ));

	    $participante = $this->Participante->find('all', array(
	        'fields' => array('Participante.arquivoFoto','Participante.login','Participante.nomeCompleto','Participante.email','Participante.cidade','Participante.descricao'),
	        'conditions' => array('Participante.login =' => $usuario['login']),
	    ));

	    $dados['cidades'] = $cidades;
	    $dados['estados'] = $estados;
	    $dados['participante'] = $participante;

		//renderiza a pagina de cadastro
		$this->layout='site';
		$this->set('dados', $dados);
	}

	public function editaParticipante(){

		$usuario = $this->Session->read('usuario');

		//trata a imagem do upload
		$image = $this->data['participante']['arquivoFoto'];
		$imageName = $image['name'];
		$login_antigo = $this->request->data['participante']['login'];

		$full_image_path = WWW_ROOT . 'img/upload/' . $imageName;		

		if (move_uploaded_file($image['tmp_name'], $full_image_path)) {

            $this->request->data['participante']['arquivoFoto'] = $imageName;
            $this->request->data['participante']['senha'] = md5($this->request->data['participante']['senha']);

            foreach ($this->request->data['participante'] as $key => $value) {
            	
            	$this->request->data['participante'][$key] = '"'.$value.'"';
            }

            unset($this->request->data['participante']['estado']);

			if ($this->Participante->updateAll(
											$this->data['participante'],
											array('Participante.login =' => $usuario['login'])
										)){
	 
				$usuario = $this->Participante->find('all', array(
					 'contain' => array( //campos que vai buscar
					 	'login',
					 	'senha'
					 ),
					 'conditions' => array( //esse e o where
					 	'login' => $login_antigo
					 )
				));
			
				//insere os dados do usuario na sessao para acesso durante a navegacao
				$this->Session->write('usuario', $usuario[0]['Participante']);

				//Enviando uma mensagem ao usuário
				$this->Session->setFlash('Cadastro alterado com sucesso!');
			}else{
				
				$this->Session->setFlash('Erro na altera&ccedil;&atilde;o');				
			}
        } else {
            $this->Session->setFlash('Erro ao realizar upload');
        }		

        $this->redirect('/painel/');
	}

	public function adicionaParticipante(){

		//trata a imagem do upload
		$image = $this->data['participante']['arquivoFoto'];
		$imageName = $image['name'];

		$full_image_path = WWW_ROOT . 'img/upload/' . $imageName;		

		if (move_uploaded_file($image['tmp_name'], $full_image_path)) {

            $this->request->data['participante']['arquivoFoto'] = $imageName;
            $this->request->data['participante']['senha'] = md5($this->request->data['participante']['senha']);

			if ($this->Participante->save($this->request->data['participante'])){
	 
				//Enviando uma mensagem ao usuário
				$this->Session->setFlash('Usuario criado com sucesso!');
			}else{
				
				$this->Session->setFlash('Erro no cadastro');				
			}
        } else {
            $this->Session->setFlash('Erro ao realizar upload');
        }		

        $this->redirect('/');	
	}
}


