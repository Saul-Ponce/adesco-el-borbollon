<?php

require_once './app/libs/Model.php';

class HomeModel extends Model
{
    private $tabla;

    public function __construct($conexion){
        $this->tabla = "usuario";

        parent::__construct($this->tabla, $conexion);
    }



}
