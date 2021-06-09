<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AdminController extends Action
{
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
                header('Location: /cadastro-admin?inputvazio=true');
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
                header('Location: /admins');
            }else{
                header('Location: /cadastro-admin?emailvalido=false');
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

    public function validaLogin()
	{
		session_start();
		if(!$_SESSION['logado']){
            header('Location: /admin');
            return true;
        }
	}
}