<?php

require_once './app/libs/Model.php';

class ReporteConsumoModel extends Model
{
    private $tabla;

    public function __construct($conexion){
        $this->tabla = "consumoagua";

        parent::__construct($this->tabla, $conexion);
    }



}
