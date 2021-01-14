<?php
require_once './app/libs/Controller.php';
require_once './app/models/ClienteModel.php';
require_once './app/models/UsuarioModel.php';

class FormClienteController extends Controller
{
    private $modelo;
    private $modeloU;

    public function __construct($conexion)
    {
        parent::__construct();
        $this->modelo = new ClienteModel($conexion);
        $this->modeloU = new UsuarioModel($conexion);
    }

    public function index()
    {
        $this->sesionActiva();

        $datos = $this->sesion->get('login');
        $conexion= new Conexion();
        $cantones = $conexion->obtenerConexion()->query('SELECT * from canton')->fetchAll();
        $usuarios = $conexion->obtenerConexion()->query('SELECT * from usuario')->fetchAll();
        $this->view('formCliente', [
            'formCliente' => Utiles::printScript('formCliente')
        ], array(
            'login' => $datos,
            'cantones' => $cantones,
            'usuarios' => $usuarios
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
///cambio
    public function guardar()
    {
        $this->isAjax();

        $this->validarMetodoPeticion('POST');
        $usuario = array_slice($_POST, 10);
        $cliente = array_slice($_POST, 0, 10);
        $guardar_usuario = $this->modeloU->insertar($usuario);
        $errorU = $this->modeloU->error();
        if ($guardar_usuario !== null) {
            $conexion= new Conexion();
            $datos_consulta = $conexion->obtenerConexion()->query('SELECT idusuario FROM usuario WHERE usuario = :usuario',array(
                ':usuario' => $cliente['codcliente']
            ))->fetchAll();

            $cliente['id_usuario'] = intval($datos_consulta[0]['idusuario']);
            $resultado_guardar = $this->modelo->insertar($cliente);
            $errorc = $this->modelo->error();
            if ($resultado_guardar !== null || $errorc[0] === "00000") {
                Excepcion::json(['mensaje' => 'cliente creado con exito', 'redireccion' => null /*'/formCliente/tablaClientes'*/]);
            }
            else {
                Excepcion::json(array(
                    'resultado_guardar' => $errorc,
                    'error' => true,
                    'redireccion' => null
                ));
            }
        }else {
            Excepcion::json(array(
                'resultado_guardar' => $errorU,
                'error' => true,
                'redireccion' => null
            ));
        }
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
