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
        MONTH(ca.fechadelectura) != :mes
        ',array(
            ':mes' => $mes
        ))->fetchAll();


        $this->view('tablaConsumo', [
            'js_especifico' => Utiles::printScript('Consumo')
        ], array(
            'datos' => $datos_consulta
        ));

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
