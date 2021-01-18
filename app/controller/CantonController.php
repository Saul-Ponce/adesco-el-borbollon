<?php
require_once './app/libs/Controller.php';
require_once './app/models/CantonModel.php';

class CantonController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        parent::__construct();
        $this->modelo = new CantonModel($conexion);
    }

    public  function modalGuardar(){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        Flight::render('ajax/canton/modal-guardar');
    }
    public function index()
    {
        $this->sesionActiva();
        /*$conexion= new Conexion();
        $datos_consulta = $conexion->obtenerConexion()->query('where id = :id',array(
            ':id' => 'es'
        ))->fetchAll();*/

        $datos= $this->modelo->seleccionar("*");
        $this->view('tablaCanton', [
            'js_especifico' => Utiles::printScript('Canton')
        ], array(
            'datos' => $datos
        ));

    }
    public function modalEditar($id){
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('GET');

        if ($id === null) {
            exit(1);
        }

        $canton = $this->modelo->seleccionar('*', array(
            'idcanton' => $id,
        ));

        Flight::render('ajax/canton/modal-editar', array(
            'canton' => $canton[0],
        ));
    }




    public function guardar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');
        if (!isset($_POST['canton'])) {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $canton_guardar = $_POST['canton'];
        $resultado_guardar = $this->modelo->insertar($canton_guardar);


        if ($resultado_guardar !== 0) {
            Excepcion::json(['error' => false,
                'mensaje' => 'Canton Guardado', ]);

        } else {
            if ($this->modelo->error()[2] !== null) {
                Excepcion::json(['error' => true,
                    'mensaje' => 'Error al guardar en el Canton',
                ]);
            } else {

            }
            Excepcion::json(['error' => false,
                'mensaje' => 'Canton Guardado',]);

        }
    }

    public function editar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');
     //   Excepcion::json($_POST['canton']);
        if (!isset($_POST['canton'])) {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $canton_editar = $_POST['canton'];

        if ($canton_editar['idcanton'] === '' || $canton_editar['nombrecanton'] === '' ) {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $id = $canton_editar['idcanton'];

        unset($canton_editar['idcanton']);

        $resultado = $this->modelo->actualizar($canton_editar, array(
            'idcanton' => $id,
        ));
        //Excepcion::json($resultado);
        if ($resultado !== 0) {
            Excepcion::json(['error' => false,
                'mensaje' => 'Canton Editado', ]);

        } else {
            if ($this->modelo->error()[2] !== null) {
                Excepcion::json(['error' => true,
                    'mensaje' => 'Error al editar en el Canton',
                ]);
            } else {

            }
            Excepcion::json(['error' => false,
                'mensaje' => 'Canton Editado',]);

        }

    }

    public function eliminar()
    {
        $this->isAjax();

        $this->validarMetodoPeticion('POST');

        $resultado_eliminar = $this->modelo->eliminar(array(
            'idcanton' => $_POST['idcanton'],
        ));


        if ($resultado_eliminar !== null) {
            Excepcion::json(['mensaje' => 'Canton eliminado con exito', 'redireccion' => '/canton']);
        }

        Excepcion::json(array(
            'error' => true,
            'redireccion' => null
        ));

    }

}
