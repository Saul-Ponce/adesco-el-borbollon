<?php

require_once './app/libs/Model.php';

class ReportePagoModel extends Model
{
    private $tabla;

    public function __construct($conexion){

        $this->tabla = "pagorecibo";
        //$this->tabla = "recibo";
        //$this->tabla = "cliente";
        //$this->tabla = "canton";

        parent::__construct($this->tabla, $conexion);
    }



}
