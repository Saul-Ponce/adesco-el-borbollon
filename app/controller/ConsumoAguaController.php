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
        LEFT JOIN consumoagua ON consumoagua.idcliente = cliente.codcliente
        WHERE
        MONTH(consumoagua.fechadelectura) != :mes AND YEAR(consumoagua.fechadelectura) <= :anio OR ISNULL(consumoagua.idcliente)
        ',array(
            ':mes' => $mes,
            ':anio' => $anio
        ))->fetchAll();


        $datos_consulta2 = $conexion->obtenerConexion()->query('
        SELECT
        cliente.codcliente,
        cliente.nombrecliente,
        cliente.apellidocliente,
        consumoagua.fechadelectura,
        consumoagua.lecturaactual,
        consumoagua.lecturaanterior,
        consumoagua.consumodelmes,
        tarifa.preciopormetroscubicos,
        tarifa.tarifaalcantarillado,
        consumoagua.monto,
        consumoagua.codcosumoagua
        FROM
        consumoagua
        INNER JOIN tarifa ON consumoagua.idtarifa = tarifa.idcobroagua
        INNER JOIN cliente ON consumoagua.idcliente = cliente.codcliente
        WHERE NOT EXISTS(SELECT * FROM detallerecibo)
        ')->fetchAll();

        $this->view('tablaConsumo', [
            'js_especifico' => Utiles::printScript('Consumo')
        ], array(
            'datos' => $datos_consulta,
            'datos2' => $datos_consulta2
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
                'lectura' => 0,
                'idcliente' => $id
            ));
        }

    }

    public function guardar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');
        if (!isset($_POST['consumo'])) {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $datos_consumo = $_POST['consumo'];
        $idcliente = $datos_consumo['idcliente'];
        $lecturaactual = $datos_consumo['lecturaactual'];
        $lecturaanterior = $datos_consumo['lecturaanterior'];
        $fechadelectura = $datos_consumo['fechadelectura'];

        $consumo_mes = abs($lecturaactual - $lecturaanterior);
        $conexion= new Conexion();
        $datos_consulta = $conexion->obtenerConexion()->query('SELECT
        idcobroagua,
        preciopormetroscubicos,
        tarifaalcantarillado
        FROM
        tarifa
        WHERE
        cantdesde_metroscubicos <=:lectura AND canthasta_metroscubicos >=:lectura', array(
            ':lectura' => $consumo_mes,
        ))->fetchAll();

        if($consumo_mes <= 10){
            $monto = 2.29 + $datos_consulta[0]['tarifaalcantarillado'];
        }else {
            $monto = ($consumo_mes * $datos_consulta[0]['preciopormetroscubicos']) + $datos_consulta[0]['tarifaalcantarillado'];
        }

        $consumo = array(
            'fechadelectura' => $fechadelectura,
            'lecturaactual' => $lecturaactual,
            'lecturaanterior' => $lecturaanterior,
            'consumodelmes' => $consumo_mes,
            'idcliente' => $idcliente,
            'idtarifa' => $datos_consulta[0]['idcobroagua'],
            'monto' => $monto,
        );
        $resultado_guardar = $this->modelo->insertar($consumo);

        if ($resultado_guardar !== 0) {
            Excepcion::json(['error' => false,
                'mensaje' => 'Consumo Guardado', 'errorlog'=> $this->modelo->error()]);
        } else {
            if ($this->modelo->error()[2] !== null) {
                Excepcion::json(['error' => true,
                    'mensaje' => 'Error al guardar en el Consumo',
                ]);
            } else {
                Excepcion::json(['error' => false,
                    'mensaje' => 'Consumo Guardado(inseguro)',]);
            }

        }
    }

    public function editar()
    {

    }

    public function eliminar()
    {

    }

}
