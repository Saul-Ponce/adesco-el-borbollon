<?php

require_once './app/libs/Model.php';

class TarifaModel extends Model
{
    private $tabla;

    public function __construct($conexion){
        $this->tabla = "tarifa";

        parent::__construct($this->tabla, $conexion);
    }



}
