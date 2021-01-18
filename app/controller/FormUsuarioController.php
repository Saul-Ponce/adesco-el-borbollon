<?php
require_once './app/libs/Controller.php';
require_once './app/models/UsuarioModel.php';

class formUsuarioController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        parent::__construct();
        $this->modelo = new UsuarioModel($conexion);
    }

    public function index()
    {
        $this->sesionActiva();

        $datos = $this->sesion->get('login');

        $this->view('formUsuario', [
            'js_especifico' => Utiles::printScript('formUsuario')
        ], array(
            'login' => $datos
        ));
    }

    public function validarUsuario($usuario)
    {
        $this->isAjax();

        $existe = $this->modelo->existe(array(
            'usuario' => $usuario
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
            Excepcion::json(['mensaje' => 'usuario creado con exito', 'redireccion' => '/formUsuario/tablaUsuarios']);
        }

        Excepcion::json(array(
            'error' => true,
            'redireccion' => null
        ));

    }

    public function tablaUsuarios()
    {
        $this->sesionActiva();

        $datos = $this->modelo->seleccionar('*');

        $this->view('tablaUsuario', [
            'js_especifico' => Utiles::printScript('tablaUsuario')
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

        $usuario = $this->modelo->seleccionar('*', array(
            'idusuario' => $id,
        ));

        Flight::render('ajax/usuario/modal-editar', array(
            'usuario' => $usuario[0],
        ));
    }

    public function editar()
    {
        $this->isAjax();
        $this->sesionActivaAjax();
        $this->validarMetodoPeticion('POST');

        if (!isset($_POST['usuarios'])) {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $usuario_editar = $_POST['usuarios'];

        if ($usuario_editar['idusuario'] === '' || $usuario_editar['usuario'] === ''
            || $usuario_editar['contrasenia'] === '' || $usuario_editar['correo'] === ''
            || $usuario_editar['tipo'] === '') {
            Excepcion::json(['error' => true, 'mensaje' => 'Hubo un error interno']);
        }

        $id = $usuario_editar['idusuario'];

        unset($usuario_editar['idusuario']);

        $resultado = $this->modelo->actualizar($usuario_editar, array(
            'idusuario' => $id,
        ));
        //Excepcion::json($resultado);
        if ($resultado !== 0) {
            Excepcion::json(['error' => false,
                'mensaje' => 'Usuario Editado', ]);

        } else {
            if ($this->modelo->error()[2] !== null) {
                Excepcion::json(['error' => true,
                    'mensaje' => 'Error al editar en el Usuario',
                ]);
            } else {

            }
            Excepcion::json(['error' => false,
                'mensaje' => 'Usuario Editado',]);

        }
    }

    public function eliminar()
    {
        $this->isAjax();

        $this->validarMetodoPeticion('POST');

        $resultado_eliminar = $this->modelo->eliminar(array(
            'idusuario' => $_POST['idusuario'],
        ));


        if ($resultado_eliminar !== null) {
            Excepcion::json(['mensaje' => 'usuario eliminado con exito', 'redireccion' => '/formUsuario/tablaUsuarios']);
        }

        Excepcion::json(array(
            'error' => true,
            'redireccion' => null
        ));
    }

}
