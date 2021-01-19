<?php
require_once './app/libs/Controller.php';
require_once './app/models/ConsumoAguaModel.php';

class HistorialConsumoController extends Controller
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
        /*$conexion= new Conexion();
        $datos_consulta = $conexion->obtenerConexion()->query('where id = :id',array(
            ':id' => 'es'
        ))->fetchAll();*/

        $datos = $this->sesion->get('login');
        $conexion= new Conexion();
        $datos_consulta = $conexion->obtenerConexion()->query('
        SELECT
        cliente.nombrecliente,
        cliente.apellidocliente,
        consumoagua.fechadelectura,
        consumoagua.lecturaactual,
        consumoagua.lecturaanterior,
        consumoagua.consumodelmes,
        tarifa.preciopormetroscubicos,
        tarifa.tarifaalcantarillado,
        consumoagua.monto
        FROM
        consumoagua
        INNER JOIN tarifa ON consumoagua.idtarifa = tarifa.idcobroagua
        INNER JOIN cliente ON consumoagua.idcliente = cliente.codcliente
        WHERE cliente.codcliente = :usuario
        ',array(
            ':usuario'=> $datos['usuario']
        ))->fetchAll();

        $this->view('tblConsumoCliente', [
            'js_especifico' => Utiles::printScript('tablaConsumoCli')
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
