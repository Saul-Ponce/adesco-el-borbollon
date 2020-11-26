<?php

class Model
{
    protected $conexion;
    private $tabla;

    protected function __construct($tabla, Conexion $conexion)
    {
        $this->conexion = $conexion->obtenerConexion();
        $this->tabla = $tabla;
    }


    public function insertar($registro)
    {
        $this->conexion->insert($this->tabla, $registro);
        return $this->conexion->id();
    }

    public function actualizar($registro, $condicion = '')
    {
        return $this->conexion->update($this->tabla, $registro, $condicion)->rowCount();
    }

    public function eliminar($condicion = '')
    {
        return $this->conexion->delete($this->tabla, $condicion)->rowCount();
    }

    public function seleccionar($campos, $condicion = '')
    {
        return $this->conexion->select($this->tabla, $campos, $condicion);
    }

    public function obtenerUno($campos, $condicion = '')
    {
        return $this->conexion->get($this->tabla, $campos, $condicion);
    }

    public function existe($condicion = '')
    {
        return $this->conexion->has($this->tabla, $condicion);
    }

    public function last()
    {
        return $this->conexion->last();
    }

    public function error()
    {
        return $this->conexion->error();
    }

    public function conexion()
    {
        return $this->conexion;
    }

}
