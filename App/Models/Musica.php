<?php

namespace App\Models;
use MF\Model\Model;

class Musica extends Model
{
    private $id;
    private $id_adm;
    private $id_genero;
    private $musica;
    private $autor;
    private $arquivo;
    private $quantidadePorPagina;
    private $inicio;
    private $nome;

    public function salvar()
    {
        $query ='INSERT INTO tb_musicas(id_adm, id_genero, musica, autor, arquivo)
                 VALUES(:id_adm, :id_genero, :musica, :autor, :arquivo)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_adm',    $this->__get('id_adm'));
        $stmt->bindValue(':id_genero', $this->__get('id_genero'));
        $stmt->bindValue(':musica',    $this->__get('musica'));
        $stmt->bindValue(':autor',     $this->__get('autor'));
        $stmt->bindValue(':arquivo',   $this->__get('arquivo'));
        $stmt->execute();
    }

    public function getTotalMusica()
    {
        $query = "SELECT COUNT(*) as total FROM tb_musicas WHERE id_genero = :id_genero";
        $stmt  = $this->db->prepare($query);
        $stmt->bindValue(':id_genero', $this->__get('id_genero'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ)->total;
    }

    public function getTotalGenero()
    {
        //o GROUP BY está agrupando músicas quem tem o mesmo id_genero
        $query = "SELECT COUNT(*) AS total, g.genero AS genero FROM tb_musicas as m 
                  INNER JOIN tb_genero as g on m.id_genero = g.id GROUP BY id_genero";
                  
        $stmt  = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPorGenero()
    {
        $query = "SELECT musica, autor, arquivo FROM tb_musicas 
                  WHERE id_genero = :id_genero ORDER BY id DESC LIMIT :inicio, :quantidadePorPagina" ;
      
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_genero',$this->__get('id_genero'));
        $stmt->bindValue(':inicio', $this->__get('inicio'), \PDO::PARAM_INT);
        $stmt->bindValue(':quantidadePorPagina', $this->__get('quantidadePorPagina'), \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPorAdm()
    {
        $query = "SELECT id, id_genero, musica, autor, arquivo FROM tb_musicas 
                  WHERE id_adm = :id_adm ORDER BY id DESC LIMIT :inicio, :quantidadePorPagina";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_adm', $this->__get('id_adm'));
        $stmt->bindValue(':inicio', $this->__get('inicio'), \PDO::PARAM_INT);
        $stmt->bindValue(':quantidadePorPagina', $this->__get('quantidadePorPagina'), \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPorNome(){
        
        $query = "SELECT * FROM `tb_musicas` WHERE musica LIKE '%' :nome '%' ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->execute();
         
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
       
    }

    public function getPorId()
    {
        $query = "SELECT id, musica, autor FROM tb_musicas WHERE id = :id";
        $stmt  = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getPorNomeEId(){
       
        $query = "SELECT * FROM `tb_musicas` WHERE id_genero = :id_genero AND musica LIKE '%' :nome '%' ";
        $stmt  = $this->db->prepare($query);
        $stmt->bindValue(':id_genero', $this->__get('id_genero'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    

    public function removeMusica()
    {
        $query = "DELETE FROM tb_musicas WHERE id = :id";
        $stmt  = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
    }

    public function atualiza()
    {
        $query = "UPDATE tb_musicas SET musica = :musica, autor = :autor WHERE id = :id";
        $stmt  = $this->db->prepare($query);
        $stmt->bindValue(':musica', $this->__get('musica'));
        $stmt->bindValue(':autor',  $this->__get('autor'));
        $stmt->bindValue(':id',     $this->__get('id'));
        $stmt->execute();
    } 

    public function totalMusicas(){
        $query = "SELECT COUNT(*) AS total FROM tb_musicas where id_adm = :id_adm";
        $stmt  = $this->db->prepare($query);
        $stmt->bindValue(':id_adm', $this->__get('id_adm'));
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }
} 
