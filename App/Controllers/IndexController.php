<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action 
{
	public function index()
	{
		$this->render('index','layouts/layoutIndex');
	}

	public function admin()
	{
		$this->verificaLogin();
		$this->render('admin','layouts/layoutAdmin');
	}

	 //verifica se está logado
	public function verificaLogin()
	{
		session_start();
		if(isset($_SESSION['logado']) && $_SESSION['logado'] == true){
			header('Location:/dashboard');
			return true;
		}
	}
}
