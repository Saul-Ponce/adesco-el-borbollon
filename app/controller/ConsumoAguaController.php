<?php
require_once './app/libs/Controller.php';
require_once './app/models/ConsumoAguaModel.php';

class ConsumoAguaController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        parent::__construct();
        $this->modelo = new ConsumoAguaModel($conexion);
    }

    public function index()
    {
        $this->sesionActiva();
        $conexion= new Conexion();

        $mes=date('m');
        $anio=date('Y');

        $datos_consulta = $conexion->obtenerConexion()->query('
        SELECT
        cliente.codcliente,
        cliente.nombrecliente,
        cliente.apellidocliente,
        cliente.dui,
        cliente.direccion,
        cliente.telefono
        FROM
        cliente
        INNER JOIN consumoagua AS ca ON ca.idcliente = cliente.codcliente
        WHERE
        MONTH(ca.fechadelectura) != :mes AND YEAR(ca.fechadelectura) = :anio
        ',array(
            ':mes' => $mes,
            ':anio' => $anio
        ))->fetchAll();

        if (empty($datos_consulta)){
            $datos_consulta = $conexion->obtenerConexion()->query('
            SELECT 
            cliente.codcliente,
            cliente.nombrecliente,
            cliente.apellidocliente,
            cliente.dui,
            cliente.direccion,
            cliente.telefono
            FROM
            cliente
            WHERE NOT EXISTS(
            SELECT
            cliente.codcliente
            FROM
            cliente
            INNER JOIN consumoagua AS ca 
            WHERE
            MONTH(ca.fechadelectura) = :mes AND YEAR(ca.fechadelectura) = :anio )'
            , array(
                    ':mes' => $mes,
                    ':anio' => $anio
                ))->fetchAll();
        }

        $this->view('tablaConsumo', [
            'js_especifico' => Utiles::printScript('Consumo')
        ], array(
            'datos' => $datos_consulta
        ));

    }

    public  function modalGuardar($id){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');
        $conexion= new Conexion();

        if ($id === null) {
            exit(1);
        }

        $datos_consulta = $conexion->obtenerConexion()->query('SELECT lecturaactual FROM consumoagua WHERE idcliente = :id', array(
            ':id' => $id,
        ))->fetchAll();

        if (!empty($datos_consulta)){
            Flight::render('ajax/consumo/modal-guardar', array(
                'lectura' => $datos_consulta[0],
                'idcliente' => $id
            ));
        }else{
            Flight::render('ajax/consumo/modal-guardar', array(
                'idcliente' => $id
            ));
        }

    }

    public function guardar()
    {

    }

    public function editar()
    {

    }

    public function eliminar()
    {

    }

}
