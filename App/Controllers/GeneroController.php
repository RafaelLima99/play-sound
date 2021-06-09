<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class GeneroController extends Action
{
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

    public function validaLogin()
	{
		session_start();
		if(!$_SESSION['logado']){
            header('Location: /admin');
            return true;
        }
	}

}