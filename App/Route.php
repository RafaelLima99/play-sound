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
			'controller' => 'DashboardController',
			'action' => 'dashboard'
		);

		$routes['upload'] = array(
			'route' => '/upload',
			'controller' => 'DashboardController',
			'action' => 'upload'
		);

		$routes['minhasMusicas'] = array(
			'route' => '/minhas-musicas',
			'controller' => 'DashboardController',
			'action' => 'minhasMusicas'
		);

		$routes['cadastro'] = array(
			'route' => '/cadastro',
			'controller' => 'DashboardController',
			'action' => 'cadastro'
		);

		$routes['admins'] = array(
			'route' => '/admins',
			'controller' => 'DashboardController',
			'action' => 'admins'
		);

		$routes['remove-musica'] = array(
			'route' => '/remove-musica',
			'controller' => 'DashboardController',
			'action' => 'removeMusica'
		);

		$routes['remove-adm'] = array(
			'route' => '/remove-adm',
			'controller' => 'DashboardController',
			'action' => 'removeAdm'
		);

		$routes['editar'] = array(
			'route' => '/editar',
			'controller' => 'DashboardController',
			'action' => 'editar'
		);

		$routes['atualiza'] = array(
			'route' => '/atualiza',
			'controller' => 'DashboardController',
			'action' => 'atualiza'
		);

		$routes['processaupload'] = array(
			'route' => '/processaupload',
			'controller' => 'DashboardController',
			'action' => 'processaUpload'
		);

		$routes['eletronica'] = array(
			'route' => '/eletronica',
			'controller' => 'PlaylistController',
			'action' => 'eletronica'
		);

		$routes['rap'] = array(
			'route' => '/rap',
			'controller' => 'PlaylistController',
			'action' => 'rap'
		);

		$routes['evangelica'] = array(
			'route' => '/evangelica',
			'controller' => 'PlaylistController',
			'action' => 'evangelica'
		);

		$routes['para-estudar'] = array(
			'route' => '/para-estudar',
			'controller' => 'PlaylistController',
			'action' => 'paraEstudar'
		);

		$routes['reggae'] = array(
			'route' => '/reggae',
			'controller' => 'PlaylistController',
			'action' => 'reggae'
		);

		$routes['para-programar'] = array(
			'route' => '/para-programar',
			'controller' => 'PlaylistController',
			'action' => 'paraProgramar'
		);

		$routes['anime'] = array(
			'route' => '/anime',
			'controller' => 'PlaylistController',
			'action' => 'anime'
		);

		$routes['forro'] = array(
			'route' => '/forro',
			'controller' => 'PlaylistController',
			'action' => 'forro'
		);

		$routes['playlist'] = array(
			'route' => '/playlist',
			'controller' => 'PlaylistController',
			'action' => 'forro'
		);

		$routes['genero'] = array(
			'route' => '/generos',
			'controller' => 'GeneroController',
			'action' => 'index'
		);

		$this->setRoutes($routes);
	}
}
