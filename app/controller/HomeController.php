<?php
require_once './app/libs/Controller.php';
require_once './app/models/HomeModel.php';

class HomeController extends Controller
{
    private $modelo;

    public function __construct($conexion)
    {
        parent::__construct();
        $this->modelo = new HomeModel($conexion);
    }

    public function index()
    {
        $this->sesionActiva();
        /*$conexion= new Conexion();
        $datos_consulta = $conexion->obtenerConexion()->query('where id = :id',array(
            ':id' => 'es'
        ))->fetchAll();*/

        $datos = $this->sesion->get('login');

        $this->view('inicio', [
            'js_especifico' => Utiles::printScript('home')
        ], array(
            'login' => $datos
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
