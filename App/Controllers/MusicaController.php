<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class MusicaController extends Action
{
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

    public function removeMusica()
	{
		$this->validaLogin();

		$id_musica = isset($_GET['id_musica']) ? $_GET['id_musica'] : null;

		if(!empty($id_musica)){
			
			$musica = Container::getModel('Musica');
			$musica->__set('id', $id_musica);
			//remove do banco de dados
			$musica->removeMusica();
        
			//remove o arquivo de áudio
			$genero = Container::getModel('genero');
			$genero->__set('id', $_POST['genero']);

			$dadosGenero = $genero->getPorId();

			$diretorio = $dadosGenero['diretorio'];
			$dadosGenero = $genero->getPorId();

			$diretorio = $dadosGenero['diretorio'];
			unlink($diretorio.$_GET['arquivo']);	
			header('Location: /minhas-musicas');

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

	public function dashboard()
	{
		//valida login verifica se o usuário está logado
		$this->validaLogin();
		$musica = Container::getModel('Musica');
		//getTotalGenero retorna um array com a quantidade de músicas por genêro
		$this->view->totalPorGenero = $musica->getTotalGenero();;

		$this->render('dashboard','layouts/layoutDashboard');
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