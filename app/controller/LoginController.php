<?php
require_once './app/libs/Controller.php';
require_once './app/models/UsuarioModel.php';

class LoginController extends Controller
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

        $datos = $this->modelo->seleccionar('*');

        Flight::render('login');
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

    public function mostrarX(){
        $datos = $this->modelo->seleccionar('test');
        Flight::render('vista', array(
            'datos' => $datos
        ));
    }

    public function iniciarSesion()
    {

        if (!isset($_POST['login'])) {
            Excepcion::json(['error' => true, 'tipo' => 'error_sesion']);
        }


        $resultado = $this->modelo->existe($_POST['login']);

        if ($resultado) {

            $this->crearSesion($_POST['login']['usuario']);
            Excepcion::json(['error' => false, 'url' => '/']);
        }
        Excepcion::json(['error' => true, 'tipo' => 'no_encontrado', 'error_bd' => $this->modelo->error()]);
    }

    public function cerrarSesion()
    {
        $sesion = new Session();
        $sesion->destroy();
        Flight::redirect('/login', 200);
    }

    //Metodos privados

    private function crearSesion($usuario)
    {


        $data = $this->modelo->seleccionar(array('idusuario', 'usuario', 'tipo'), array('usuario' => $usuario));

        $data = $data[0];

        $this->sesion->set('login', $data);
    }

}
