<?php

namespace App\Models;
use MF\Model\Model;

class Genero extends Model
{
   private $id;
   private $genero;
   private $diretorio;
   private $descricao;
   private $quantidadePorPagina;
   private $paginaAtual;
   private $inicio;

   public function salvar(){
      $query ='INSERT INTO tb_genero(genero, diretorio, descricao)
      VALUES(:genero, :diretorio, :descricao)';

      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':genero',    $this->__get('genero'));
      $stmt->bindValue(':diretorio', $this->__get('diretorio'));
      $stmt->bindValue(':descricao', $this->__get('descricao'));
      $stmt->execute();
   }

   public function getGenero(){

        $query = "SELECT * FROM tb_genero";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
     
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function getPorId(){

      $query = "SELECT id, genero, diretorio, descricao FROM tb_genero WHERE id = :id";
      $stmt  = $this->db->prepare($query);
      $stmt->bindValue(':id', $this->__get('id'));
      $stmt->execute();

      return $stmt->fetch(\PDO::FETCH_ASSOC);
   }

   public function getPorGenero(){

      $query = "SELECT * FROM tb_genero WHERE genero LIKE '%' :genero '%' ";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':genero', $this->__get('genero'));
      $stmt->execute();
       
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function totalGeneros(){
      $query = "SELECT COUNT(*) AS total FROM tb_genero";
      $stmt  = $this->db->prepare($query);
      $stmt->execute();
      
      return $stmt->fetch(\PDO::FETCH_ASSOC);
  }


   public function getGeneroPaginacao(){
      $query = "SELECT id, genero, diretorio, descricao FROM tb_genero 
               ORDER BY id DESC LIMIT :inicio, :quantidadePorPagina";
      
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':inicio', $this->__get('inicio'), \PDO::PARAM_INT);
      $stmt->bindValue(':quantidadePorPagina', $this->__get('quantidadePorPagina'), \PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function atualiza(){
      $query = "UPDATE tb_genero SET descricao = :descricao WHERE id = :id";
      $stmt  = $this->db->prepare($query);
      $stmt->bindValue(':descricao',  $this->__get('descricao'));
      $stmt->bindValue(':id', $this->__get('id'));
      $stmt->execute();
      
   }

   public function removeGenero(){
      $query = "DELETE FROM tb_genero WHERE id = :id";
      $stmt  = $this->db->prepare($query);
      $stmt->bindValue(':id', $this->__get('id'));
      $stmt->execute();
   }

   public function __set($atributo, $valor){
      $this->$atributo = $valor;
   }

   public function __get($atibuto){
      return $this->$atibuto;
   }
} 
