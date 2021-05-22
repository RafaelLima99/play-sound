<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class PlaylistController extends Action
{
    // public function eletronica()
    // {
    //     //informações que são atibuidas a view playlist
    //     $this->view->titulo    = 'Eletrônica'; 
    //     $this->view->descricao = "Playlist com as mais variadas músicas eletrônicas";
    //     $this->view->diretorio = "musicas/eletronica/";

    //     $musica = Container::getModel('Musica');
    //     $musica->__set('id_genero', 1);

    //     //retorna o total de musicas por genêro
    //     $this->view->total = $musica->getTotalMusica();
    //     //retorna as musicas por genêro
    //     $this->view->musicas = $musica->getPorGenero();

    //     $this->render('playlist', 'layouts/layoutPlaylist');
    // }

    // public function rap()
    // {
    //     $this->view->titulo    = 'Rap'; 
    //     $this->view->descricao = "Playlist com as mais variadas músicas de rap";
    //     $this->view->diretorio = "musicas/rap/";

    //     $musica = Container::getModel('Musica');
    //     $musica->__set('id_genero', 2);

    //     $this->view->total   = $musica->getTotalMusica();
    //     $this->view->musicas = $musica->getPorGenero();

    //     $this->render('playlist', 'layouts/layoutPlaylist');
    // }

    // public function evangelica()
    // {
    //     $this->view->titulo    = 'Evangélica'; 
    //     $this->view->descricao = "Playlist com as mais variadas músicas evangélica";
    //     $this->view->diretorio = "musicas/evangelica/";

    //     $musica = Container::getModel('Musica');
    //     $musica->__set('id_genero', 3);

    //     $this->view->total   = $musica->getTotalMusica();
    //     $this->view->musicas = $musica->getPorGenero();

    //     $this->render('playlist', 'layouts/layoutPlaylist');
    // }

    // public function paraEstudar()
    // {
    //     $this->view->titulo    = 'Para Estudar'; 
    //     $this->view->descricao = "Playlist com as mais variadas músicas para estudar";
    //     $this->view->diretorio = "musicas/paraEstudar/";

    //     $musica = Container::getModel('Musica');
    //     $musica->__set('id_genero', 4);

    //     $this->view->total   = $musica->getTotalMusica();
    //     $this->view->musicas = $musica->getPorGenero();

    //     $this->render('playlist', 'layouts/layoutPlaylist');
    // }

    // public function reggae()
    // {
    //     $this->view->titulo    = 'Reggae'; 
    //     $this->view->descricao = "Playlist com as mais variadas músicas de reggae";
    //     $this->view->diretorio = "musicas/reggae/";

    //     $musica = Container::getModel('Musica');
    //     $musica->__set('id_genero', 5);

    //     $this->view->total   = $musica->getTotalMusica();
    //     $this->view->musicas = $musica->getPorGenero();

    //     $this->render('playlist', 'layouts/layoutPlaylist');
    // }

    // public function paraProgramar()
    // {
    //     $this->view->titulo    = 'Para Programar'; 
    //     $this->view->descricao = "Playlist com as mais variadas músicas para programar";
    //     $this->view->diretorio = "musicas/paraProgramar/";

    //     $musica = Container::getModel('Musica');
    //     $musica->__set('id_genero', 6);

    //     $this->view->total   = $musica->getTotalMusica();
    //     $this->view->musicas = $musica->getPorGenero();

    //     $this->render('playlist', 'layouts/layoutPlaylist');
    // }

    // public function anime()
    // {
    //     $this->view->titulo    = 'Anime'; 
    //     $this->view->descricao = "Playlist com as mais variadas músicas de anime";
    //     $this->view->diretorio = "musicas/anime/";

    //     $musica = Container::getModel('Musica');
    //     $musica->__set('id_genero', 7);

    //     $this->view->total   = $musica->getTotalMusica();
    //     $this->view->musicas = $musica->getPorGenero();

    //     $this->render('playlist', 'layouts/layoutPlaylist');
    // }

    // public function forro()
    // {
    //     $this->view->titulo    = 'Forró'; 
    //     $this->view->descricao = "Playlist com as mais variadas músicas de forró";
    //     $this->view->diretorio = "musicas/forro/";

    //     $musica = Container::getModel('Musica');
    //     $musica->__set('id_genero', 8);

    //     $this->view->total   = $musica->getTotalMusica();
    //     $this->view->musicas = $musica->getPorGenero();

    //     $this->render('playlist', 'layouts/layoutPlaylist');
    // }

    public function index(){

        $genero = isset($_GET['genero']) ? $_GET['genero'] : null;
		$id     = isset($_GET['id']) ? $_GET['id'] : null;
        
        if(!empty($genero) && empty(!$id)){

            $genero = Container::getModel('Genero');
            $genero->__set('id', $id);
            $dadosGenero = $genero->getPorId();

            if(isset($_GET['pesquisa']) && $_GET['pesquisa'] != null){

                $musica = Container::getModel('musica');

                $musica->__set('id_genero', $id);
                $musica->__set('nome', $_GET['pesquisa']);

                $this->view->idGenero = $id;
                $this->view->genero = $genero;
                $this->view->pesquisa = $pesquisa = true;
			    $this->view->pesquisaMusica = $_GET['pesquisa'];

                $this->view->titulo    = $dadosGenero['genero']; 
                $this->view->diretorio = $dadosGenero['diretorio'];

                $this->view->musicas = $musica->getPorNomeEId();
                // var_dump($this->view->musicas);die;
                $this->render('playlist', 'layouts/layoutPlaylist');

            }else{
                 //informações que são atibuidas a view playlist
                $this->view->titulo    = $dadosGenero['genero']; 
                $this->view->descricao = $dadosGenero['descricao'];
                $this->view->diretorio = $dadosGenero['diretorio'];
    
                $musica = Container::getModel('Musica');
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
