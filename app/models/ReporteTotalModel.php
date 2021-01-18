<?php

require_once './app/libs/Model.php';

class ReporteTotalModel extends Model
{
    private $tabla;

    public function __construct($conexion){
        $this->tabla = "consumoagua";
        $this->tabla = "canton";
        parent::__construct($this->tabla, $conexion);
    }



}
