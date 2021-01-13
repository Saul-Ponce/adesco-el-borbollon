<?php
require_once './app/libs/Controller.php';
require_once './app/models/ClienteModel.php';

class FormClienteController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        parent::__construct();
        $this->modelo = new ClienteModel($conexion);
    }

    public function index()
    {
        $this->sesionActiva();

        $datos = $this->sesion->get('login');

        $this->view('formCliente', [
            'formCliente' => Utiles::printScript('formCliente')
        ], array(
            'login' => $datos
        ));
    }

    public function validarCliente($cliente)
    {
        $this->isAjax();

        $existe = $this->modelo->existe(array(
            'cliente' => $cliente
        ));


        $resultado = array();

        if ($existe) {
            $resultado = array(
                'error' => true
            );
        } else {
            $resultado = array(
                'error' => false
            );

            Excepcion::json($resultado);
        }
    }

    public function guardar()
    {
        $this->isAjax();

        $this->validarMetodoPeticion('POST');
        $resultado_guardar = $this->modelo->insertar($_POST);

        if ($resultado_guardar !== null) {
            Excepcion::json(['mensaje' => 'cliente creado con exito', 'redireccion' => '/formCiente/tablaClientes']);
        }

        Excepcion::json(array(
            'error' => true,
            'redireccion' => null
        ));

    }

    public function tablaClientes()
    {
        $this->sesionActiva();

        $datos = $this->modelo->seleccionar('*');

        $this->view('tablaClientes', [
            'formCliente' => Utiles::printScript('formCliente')
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

        $cliente = $this->modelo->seleccionar('*', array(
            'idcliente' => $id,
        ));

        Flight::render('ajax/cliente/modal-editar', array(
            'cliente' => $cliente[0],
        ));
    }

    public function editar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        if (!isset($_POST['clientes'])) {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $cliente_editar = $_POST['clientes'];

        if ($cliente_editar['idcliente'] === '' || $cliente_editar['nombrecliente'] === ''
            || $cliente_editar['apellidocliente'] === '' || $cliente_editar['dui'] === ''
            || $cliente_editar['nit'] === ''|| $cliente_editar['direccion'] === ''
            || $cliente_editar['telefono'] === ''|| $cliente_editar['id_canton'] === ''
            || $cliente_editar['matriculaescritura'] === ''|| $cliente_editar['id_usuario'] === '') {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $id = $cliente_editar['idcliente'];

        unset($cliente_editar['idcliente']);

        $resultado = $this->modelo->actualizar($cliente_editar, array(
            'idcliente' => $id,
        ));
        //Excepcion::json($resultado);
        if ($resultado !== 0) {
            Excepcion::json(['error' => false,
                'mensaje' => 'Cliente Editado', ]);

        } else {
            if ($this->modelo->error()[2] !== null) {
                Excepcion::json(['error' => true,
                    'mensaje' => 'Error al editar en el Cliente',
                ]);
            } else {

            }
            Excepcion::json(['error' => false,
                'mensaje' => 'Cliente Editado',]);

        }
    }

    public function eliminar()
    {
        $this->isAjax();

        $this->validarMetodoPeticion('POST');

        $resultado_eliminar = $this->modelo->eliminar(array(
            'idcliente' => $_POST['idcliente'],
        ));


        if ($resultado_eliminar !== null) {
            Excepcion::json(['mensaje' => 'cliente eliminado con exito', 'redireccion' => '/formCliente/tablaClientes']);
        }

        Excepcion::json(array(
            'error' => true,
            'redireccion' => null
        ));
    }

}
