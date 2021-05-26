<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class GeneroController extends Action
{
    public function index(){
        echo "Generos";
    }
}