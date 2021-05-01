<?php

namespace App\Models;
use MF\Model\Model;

class Genero extends Model
{
   public function getGenero(){

        $query = "SELECT * FROM `tb_genero`";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
     
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
   }
} 
