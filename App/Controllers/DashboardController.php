<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class DashboardController extends Action
{
	public function dashboard()
	{
		//valida login verifica se o usuário está logado
		$this->validaLogin();
		$musica = Container::getModel('Musica');
		//getTotalGenero retorna um array com a quantidade de músicas por genêro
		$this->view->totalPorGenero = $musica->getTotalGenero();;

		$this->render('dashboard','layouts/layoutDashboard');
	}
	
	public function upload()
	{
		$this->validaLogin();

		$genero  = Container::getModel('Genero');
		
		$generos = $genero->getGenero();

		$this->view->generos = $generos;
		$this->render('upload','layouts/layoutDashboard');
	}

	public function processaUpload()
	{	
		//pega os dados do form
		$nome_musica = isset($_POST['nome_musica']) ? $_POST['nome_musica'] : null;
		$autor		 = isset($_POST['nome_autor']) ? $_POST['nome_autor'] : null;
		$tmp_name 	 = isset($_FILES['arquivo']['tmp_name']) ? $_FILES['arquivo']['tmp_name'] : null;

		//verifica se está vazio
		if ( !empty($nome_musica) && !empty($autor) && !empty($tmp_name)) {
			
			//função trim retira os espaços no inicio e no final da string
			trim($nome_musica);
			trim($autor);
		
			//armazena a extensão do arquivo
			$extensao = strtolower(substr($_FILES['arquivo']['name'], -4));
			$nome_arquivo = $nome_musica.'-'.$autor.$extensao;
			//atributo diretorio retona o diretorio apartir do id do genêro

			
			$genero = Container::getModel('genero');
			$genero->__set('id', $_POST['genero']);

			$dadosGenero = $genero->getPorId();

			$diretorio = $dadosGenero['diretorio'];

			

			if($extensao == '.mp3') {
				//faz o upload do arquivo
				move_uploaded_file($tmp_name, $diretorio.$nome_arquivo);

				$musica = Container::getModel('Musica');

				session_start();
				$musica->__set('id_adm', $_SESSION['id']);
				$musica->__set('id_genero', $_POST['genero']);
				$musica->__set('musica', $nome_musica);
				$musica->__set('autor', $autor);
				$musica->__set('arquivo', $nome_arquivo);
				//salva os dados no banco de dados
				$musica->salvar();

			}
		}
	}

	public function minhasMusicas()
	{
		$this->validaLogin();
		
		$musica = Container::getModel('Musica');
		//session id, contém o id do usário logado
		$musica->__set('id_adm', $_SESSION['id']);
		//retorna as músicas envidas pelo adm que está logado

		//paginação
		$quantidadePorPagina = 10;
        $paginaAtual 		 = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $inicio				 = ($quantidadePorPagina * $paginaAtual) - $quantidadePorPagina;
		$totalRegistros 	 = $musica->totalMusicas();
		$totalPaginacao 	 = ceil($totalRegistros['total'] / $quantidadePorPagina);

		$musica->__set('quantidadePorPagina', $quantidadePorPagina);
		$musica->__set('paginaAtual', $paginaAtual);
		$musica->__set('inicio', $inicio);

		if($paginaAtual >= $totalPaginacao){
			$paginaPosterior = false;
		}else{
			$paginaPosterior = $paginaAtual + 1;
		}

		if($paginaAtual <= 1){
			$paginaAnterior = false;
		}else{
			$paginaAnterior = $paginaAtual - 1 ;
		}

		//Pesquisa por nome
		if(isset($_GET['musica']) && $_GET['musica'] != null){
			
			$musica->__set('nome', $_GET['musica']);
			$musicas  =  $musica->getPorNome();
			$pesquisa = true;
			$this->view->nome = $_GET['musica'];
			
		}else{
			$musicas  = $musica->getPorAdm();
			$pesquisa = false;
		}
		
		//variaveis que vão para view
		$this->view->musicas 		 = $musicas;
		$this->view->totalPaginacao	 = $totalPaginacao;
		$this->view->paginaPosterior = $paginaPosterior;
		$this->view->paginaAnterior	 = $paginaAnterior;
		$this->view->paginaAtual 	 = $paginaAtual;
		$this->view->pesquisa 		 = $pesquisa;
		
		$this->render('minhasMusicas','layouts/layoutDashboard');
	}

	public function cadastro()
	{
		$this->validaLogin();
		$this->validaNivelAcesso();

		$nome  		 = isset($_POST['nome']) ? $_POST['nome'] : null;
		$email 		 = isset($_POST['email']) ? $_POST['email'] : null;
		$senha 		 = isset($_POST['senha']) ? $_POST['senha'] : null;
		$nivelAcesso = isset($_POST['nivel-acesso']) ? $_POST['nivel-acesso'] : null;

		if($nome && $email && $senha && $nivelAcesso){
            //verifica se as variaveis estão vazias
            if(empty($nome) && empty($email) && empty($senha) && empty($nivelAcesso)){
                header('Location: /cadastro?inputvazio=true');
				return true;
            }

            //variavel hash recebe o hash da senha do usuário
            $hash = password_hash($senha, PASSWORD_BCRYPT);
            $cadastro = Container::getModel('admin');
            $cadastro->setNome($nome);
            $cadastro->setEmail($email);
			$cadastro->setSenha($hash);
			$cadastro->setNivelAcesso($nivelAcesso);
			
            //cadastra os dados
            $cadastro->cadastra();

            //se o email for valido (não existir no banco)
            if ($cadastro->getEmailValido()) {
                header('Location: /cadastro?emailvalido=true');
            }else{
                header('Location: /cadastro?emailvalido=false');
            }
		}
		
		$this->render('cadastro','layouts/layoutDashboard');
	}

	public function admins()
	{
		
		$this->validaLogin();
		$this->validaNivelAcesso();
		$admin = Container::getModel('admin');
		
		//retorna as músicas envidas pelo adm que está logado
		$this->view->admins = $admin->getAdmin();

		$this->render('admins','layouts/layoutDashboard');
		
	}

	public function removeMusica()
	{
		$this->validaLogin();

		$id_musica = isset($_GET['id_musica']) ? $_GET['id_musica'] : null;

		if(!empty($id_musica)){
			
			$musica = Container::getModel('Musica');
			$musica->__set('id', $id_musica);
			//remove do banco de dados
			$musica->removeMusica();

			$diretorio = $this->diretorio($_GET['genero']);
			//remove o arquivo de áudio
			unlink($diretorio.$_GET['arquivo']);	
			header('Location: /minhas-musicas');

		}
		
	}

	public function removeAdm()
	{
		$this->validaLogin();

		$id_adm = isset($_GET['id_adm']) ? $_GET['id_adm'] : null;

		if(!empty($id_adm)){
			
			$adm = Container::getModel('admin');
			$adm->setId($id_adm);
			//remove do banco de dados
			$adm->removeAdm();

			header('Location: /admins');

		}
	}

	public function editar()
	{
		$this->validaLogin();

		$id = isset($_GET['id']) ? $_GET['id'] : null;

		if(!empty($id)) {

			$musica = Container::getModel('Musica');
			$musica->__set('id', $id);
			//retorna os dados da música por id
			$this->view->dados = $musica->getPorId();	

			$this->render('editar','layouts/layoutDashboard');

		}else {
			header('Location: minhas-musicas');
		}
	}

	public function atualiza()
	{
		$this->validaLogin();

		$id = isset($_POST['id']) ? $_POST['id'] : null;
		$nome_musica = isset($_POST['nome_musica']) ? $_POST['nome_musica'] : null;
		$autor = isset($_POST['nome_autor']) ? $_POST['nome_autor'] : null;
		
		//verifica se as variáveis não estão vazias
		if( !empty($id) && !empty($nome_musica) && !empty($autor)) {

			$musica = Container::getModel('Musica');
			$musica->__set('id', $id);
			$musica->__set('musica', $nome_musica);
			$musica->__set('autor', $autor);
			//atualiza os dados nome e autor da música
			$musica->atualiza();
			header('Location: minhas-musicas');
		}
	}

	public function validaLogin()
	{
		session_start();
		if(!$_SESSION['logado']){
            header('Location: /admin');
            return true;
        }
	}

	public function validaNivelAcesso()
	{
		if($_SESSION['nivelAcesso'] == 1){
			echo '<script> 
					alert("Sua conta é limitada, não tem acesso a esse recurso,
					é restrito apenas a conta de nível total do sistema");
					
					window.location.href = "/dashboard";
				</script>';
			return true;
		}
	}

	// public function diretorio($id_genero)
	// {
	// 	//encontra o diretório apartir do id do genêro
	// 	switch ($id_genero) {
	// 		case 1: 
	// 			$diretorio = "musicas/eletronica/";
	// 			break;
	// 		case 2: 
	// 			$diretorio = "musicas/rap/";
	// 			break;
	// 		case 3: 
	// 			$diretorio = "musicas/evangelica/";
	// 			break;
	// 		case 4: 
	// 			$diretorio = "musicas/paraEstudar/";
	// 			break;
	// 		case 5: 
	// 			$diretorio = "musicas/reggae/";
	// 			break;
	// 		case 6: 
	// 			$diretorio = "musicas/paraProgramar/";
	// 			break;	
	// 		case 7: 
	// 			$diretorio = "musicas/anime/";
	// 			break;
	// 		case 8: 
	// 			$diretorio = "musicas/forro/";
	// 			break;					
	// 	}
	// 	return $diretorio;
	// }

	public function genero(){

		$this->validaLogin();
		$genero  = Container::getModel('Genero');

		//paginação
		$quantidadePorPagina = 10;
        $paginaAtual 		 = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $inicio				 = ($quantidadePorPagina * $paginaAtual) - $quantidadePorPagina;
		$totalRegistros 	 = $genero->totalGeneros();
		$totalPaginacao 	 = ceil($totalRegistros['total'] / $quantidadePorPagina);

		$genero->__set('quantidadePorPagina', $quantidadePorPagina);
		$genero->__set('paginaAtual', $paginaAtual);
		$genero->__set('inicio', $inicio);

		if($paginaAtual >= $totalPaginacao){
			$paginaPosterior = false;
		}else{
			$paginaPosterior = $paginaAtual + 1;
		}

		if($paginaAtual <= 1){
			$paginaAnterior = false;
		}else{
			$paginaAnterior = $paginaAtual - 1 ;
		}
		
		//Pesquisa por nome
		if(isset($_GET['genero']) && $_GET['genero'] != null){
			
			$genero->__set('genero', $_GET['genero']);
			$generos  =  $genero->getPorGenero();
			$pesquisa = true;
			$this->view->pesquisaGenero = $_GET['genero'];
			
		}else{
			$generos  = $genero->getGeneroPaginacao();
			$pesquisa = false;
		}

		$this->view->generos		 = $generos;
		$this->view->pesquisa 		 = $pesquisa;
		$this->view->totalPaginacao	 = $totalPaginacao;
		$this->view->paginaPosterior = $paginaPosterior;
		$this->view->paginaAnterior	 = $paginaAnterior;
		$this->view->paginaAtual 	 = $paginaAtual;

		$this->render('generos','layouts/layoutDashboard');
	}

	public function criaGenero(){
		$this->validaLogin();
		$this->render('cadastroGeneros','layouts/layoutDashboard');
	}

	public function cadastroGenero(){

		$this->validaLogin();
		$genero  = Container::getModel('Genero');

		$nomeGenero   = isset($_POST['genero']) ? $_POST['genero'] : null;
		$descricao 	  = isset($_POST['descricao']) ? $_POST['descricao'] : null;


		if ( !empty($nomeGenero) && !empty($descricao)) {

			//torna uma string minúscula
			$nomeGenero = mb_strtolower($nomeGenero);

			$diretorio = 'musicas/'.$nomeGenero.'/';

			$genero->__set('genero', $nomeGenero);
			$genero->__set('diretorio', $diretorio);
			$genero->__set('descricao', $descricao);
			//salva os dados no banco de dados
			$genero->salvar();

			//gera uma pasta com o nome da musica dentro da pasta musicas
			mkdir('musicas/'.$nomeGenero.'/', 0777, true);

			header('Location: generos');

		}

		header('Location: generos');
		
	}

	public function editarGenero(){

		$this->validaLogin();

		$id = isset($_GET['id']) ? $_GET['id'] : null;

		if(!empty($id)) {

			$genero = Container::getModel('genero');
			$genero->__set('id', $id);
			
			$this->view->dadosGenero = $genero->getPorId();	

			$this->render('editarGenero','layouts/layoutDashboard');

		}else {
			header('Location: generos');
		}
	}

	public function atualizarGenero(){

		$this->validaLogin();

		$id          = isset($_POST['id']) ? $_POST['id'] : null;
		$descricao   = isset($_POST['descricao']) ? $_POST['descricao'] : null;

		if( !empty($id) && !empty($descricao)) {

			$genero = Container::getModel('genero');
			$genero->__set('id', $id);
			$genero->__set('descricao', $descricao);
			$genero->atualiza();

			header('Location: generos');

		}

	}

	public function removerGenero(){

		$this->validaLogin();

		$id = isset($_GET['id']) ? $_GET['id'] : null;

		if(!empty($id)){
			
			$genero = Container::getModel('genero');
			$genero->__set('id', $id);
			//remove do banco de dados
			$genero->removeGenero();	
			header('Location: /generos');

		}
	}	
}
