<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap
{
	protected function initRoutes()
	{
		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['admin'] = array(
			'route' => '/admin',
			'controller' => 'IndexController',
			'action' => 'admin'
		);

		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'LoginController',
			'action' => 'login'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'LoginController',
			'action' => 'sair'
		);

		$routes['dashboard'] = array(
			'route' => '/dashboard',
			'controller' => 'MusicaController',
			'action' => 'dashboard'
		);

		$routes['playlist'] = array(
			'route' => '/playlist',
			'controller' => 'PlaylistController',
			'action' => 'index'
		);


		//Rotas para músicas

		$routes['upload'] = array(
			'route' => '/upload',
			'controller' => 'MusicaController',
			'action' => 'upload'
		);

		$routes['processaupload'] = array(
			'route' => '/processaupload',
			'controller' => 'MusicaController',
			'action' => 'processaUpload'
		);

		$routes['minhasMusicas'] = array(
			'route' => '/minhas-musicas',
			'controller' => 'MusicaController',
			'action' => 'minhasMusicas'
		);

		$routes['remove-musica'] = array(
			'route' => '/remove-musica',
			'controller' => 'MusicaController',
			'action' => 'removeMusica'
		);

		$routes['editar'] = array(
			'route' => '/editar',
			'controller' => 'MusicaController',
			'action' => 'editar'
		);

		$routes['atualiza'] = array(
			'route' => '/atualiza',
			'controller' => 'MusicaController',
			'action' => 'atualiza'
		);

		//Rotas para Admin

		$routes['cadastro'] = array(
			'route' => '/cadastro-admin',
			'controller' => 'AdminController',
			'action' => 'cadastro'
		);

		$routes['admins'] = array(
			'route' => '/admins',
			'controller' => 'AdminController',
			'action' => 'admins'
		);

		$routes['remove-adm'] = array(
			'route' => '/remove-adm',
			'controller' => 'AdminController',
			'action' => 'removeAdm'
		);

		//rotas para genero

		$routes['genero'] = array(
			'route' => '/generos',
			'controller' => 'GeneroController',
			'action' => 'genero'
		);

		$routes['criar-genero'] = array(
			'route' => '/criar-genero',
			'controller' => 'GeneroController',
			'action' => 'criaGenero'
		);

		$routes['cadastra-genero'] = array(
			'route' => '/cadastra-genero',
			'controller' => 'GeneroController',
			'action' => 'cadastroGenero'
		);

		$routes['editar-genero'] = array(
			'route' => '/editar-genero',
			'controller' => 'GeneroController',
			'action' => 'editarGenero'
		);

		$routes['atualizar-genero'] = array(
			'route' => '/atualizar-genero',
			'controller' => 'GeneroController',
			'action' => 'atualizarGenero'
		);

		$routes['remover-genero'] = array(
			'route' => '/remover-genero',
			'controller' => 'GeneroController',
			'action' => 'removerGenero'
		);

		$this->setRoutes($routes);
	}
}
