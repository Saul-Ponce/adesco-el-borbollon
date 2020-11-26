<?php

require_once './app/libs/Model.php';

class UsuarioModel extends Model
{
    private $tabla;

    public function __construct($conexion){
        $this->tabla = "usuario";

        parent::__construct($this->tabla, $conexion);
    }



}
