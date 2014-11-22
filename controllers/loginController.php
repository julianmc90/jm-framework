<?php

class loginController extends Controller {

    private $_login;

    public function __construct() {

        parent::__construct();

        $this->loadModel('login');
        $this->_login = new loginModel();
    }

    public function index() {
        
        if (Session::get('autenticado')) {
            $this->redireccionar('clientes');
        }

        $this->_view->titulo = 'Iniciar Sesión';
        $this->_view->setCss(array('login'));
        $this->_view->setJs(array('login'));
        $this->_view->renderizar('login');
    }

    public function autenticar() {

        if ($this->is_ajax_request()) {

            $resultado_login = $this->_login->getUsuario($this->stz_str('nombre_de_usuario'), $this->stz_str('password'));

            if ($resultado_login !== false) {

                //inicializamos algunas variables de sesion
                Session::set('autenticado', true);
                Session::set('usuario', $resultado_login[0]['nombre_usuario']);
                Session::set('nombre', $resultado_login[0]['nombre']);
                Session::set('apellido', $resultado_login[0]['apellido']);
                Session::set('id', $resultado_login[0]['id']);
                echo "1";
            } else {
                echo "2";
            }
        }
    }

    public function cerrar() {

        Session::destroy();
        $this->redireccionar('login');
    }

}

?>