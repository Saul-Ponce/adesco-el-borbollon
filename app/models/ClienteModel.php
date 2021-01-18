<?php

require_once './app/libs/Model.php';

class ClienteModel extends Model
{
    private $tabla;

    public function __construct($conexion){
        $this->tabla = "cliente";

        parent::__construct($this->tabla, $conexion);
    }



}
