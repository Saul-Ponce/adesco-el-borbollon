<?php

require_once './app/libs/Model.php';

class CantonModel extends Model
{
    private $tabla;

    public function __construct($conexion){
        $this->tabla = "canton";

        parent::__construct($this->tabla, $conexion);
    }



}
