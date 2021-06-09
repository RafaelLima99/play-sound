<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class PlaylistController extends Action
{
    public function index(){
       
        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
		$id     = isset($_GET['id']) ? $_GET['id'] : null;
        
        if(!empty($genero) && empty(!$id)){

            $musica = Container::getModel('musica');
            $genero = Container::getModel('Genero');

            $genero->__set('id', $id);
            $dadosGenero = $genero->getPorId();

            if($dadosGenero == false){
                echo "Erro 404"; 
                die;
            }

            //paginação
            $musica->__set('id_genero', $id);

            $quantidadePorPagina = 10;
            $paginaAtual 		 = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
            $inicio				 = ($quantidadePorPagina * $paginaAtual) - $quantidadePorPagina;
            $totalRegistros 	 = $musica->getTotalMusica();
            $totalPaginacao 	 = ceil($totalRegistros / $quantidadePorPagina);

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

            if(isset($_GET['pesquisa']) && $_GET['pesquisa'] != null){
            
                $musica->__set('id_genero', $id);
                $musica->__set('nome', $_GET['pesquisa']);

                $this->view->idGenero       = $id;
                $this->view->genero         =  $dadosGenero['genero'];
                $this->view->pesquisa       = $pesquisa = true;
			    $this->view->pesquisaMusica = $_GET['pesquisa'];

                $this->view->titulo    = $dadosGenero['genero']; 
                $this->view->diretorio = $dadosGenero['diretorio'];

                $this->view->musicas = $musica->getPorNomeEId();
               
                $this->render('playlist', 'layouts/layoutPlaylist');

            }else{
                 //informações que são atibuidas a view playlist
                $this->view->idGenero  = $id;
                $this->view->genero    = $dadosGenero['genero'];
                $this->view->titulo    = $dadosGenero['genero']; 
                $this->view->descricao = $dadosGenero['descricao'];
                $this->view->diretorio = $dadosGenero['diretorio'];

                $this->view->totalPaginacao	 = $totalPaginacao;
		        $this->view->paginaPosterior = $paginaPosterior;
		        $this->view->paginaAnterior	 = $paginaAnterior;
		        $this->view->paginaAtual 	 = $paginaAtual;
    
                $musica->__set('id_genero', $dadosGenero['id']);
                
                $this->view->pesquisa = $pesquisa = false;

                //retorna o total de musicas por genêro
                $this->view->total = $musica->getTotalMusica();
                //retorna as musicas por genêro
                $this->view->musicas = $musica->getPorGenero();

                $this->render('playlist', 'layouts/layoutPlaylist');
            }
          
        }else{
            echo "Erro 404";
        } 
    }
} 
