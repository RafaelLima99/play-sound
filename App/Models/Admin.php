<?php

namespace App\Models;
use MF\Model\Model;

class Admin extends Model
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $emailValido;
    private $nivelAcesso;

    public function login()
    {
        //verifica se o email do usuário existe no banco
        $query = "SELECT * FROM tb_adm WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->email);
        $stmt->execute();

        //se existir
        //verifica se a senha digitada é a mesma que condiz com o hash da senha que está no banco
        if($stmt->rowCount()){
            $usuario = $stmt->fetch();
            if(password_verify($this->senha, $usuario['senha'])){
                //insere o id e nome do usuário nos atribustos
                $this->id   = $usuario['id'];
                $this->nome = $usuario['nome'];
                $this->nivelAcesso = $usuario['nivel_acesso'];
                return true;
            }
        }
        return false;
    }

    public function cadastra()
    {
        //se o e-mail a ser cadastrado for válido
        if($this->verificaEmail()){
            //cadastra os dados do usuário
            $query = "INSERT INTO tb_adm (nome, email, senha, nivel_acesso) VALUES (:nome, :email, :senha, :nivel_acesso)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":nome",  $this->nome);
            $stmt->bindValue(":email", $this->email);
            $stmt->bindValue(":senha", $this->senha);
            $stmt->bindValue(":nivel_acesso", $this->nivelAcesso);
            $stmt->execute();
            
            $this->emailValido = true;

        }else{
            $this->emailValido = false;
        }
    }

    //verifica se o email a ser cadastrado já existe no banco
    //caso exista retorna false
    public function verificaEmail()
    {
        $query = "SELECT * FROM tb_adm WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->email);
        $stmt->execute();

       if($stmt->rowCount()){
            return false;
       }else{
           return true;
       }   
    }

    public function getAdmin()
    {
        $query = "SELECT * FROM tb_adm ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function removeAdm()
    {
        $query = "DELETE FROM tb_adm WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
    }

    //seters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
     
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function setNivelAcesso($nivelAcesso)
    {
        $this->nivelAcesso = $nivelAcesso;
    }
 
     //geters
     public function getId()
    {
        return $this->id;
    }
     public function getNome()
    {
        return $this->nome;
    }

    public function getEmailValido()
    {
        return $this->emailValido;
    }

    public function geNivelAcesso()
    {
        return $this->nivelAcesso;
    }
}
