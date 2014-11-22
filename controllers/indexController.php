<?php

class indexController extends Controller {

    public function __construct() {

        parent::__construct();
    }

    public function index() {

        if (!Session::get('autenticado')) {
            $this->redireccionar('login');
        }

        $this->_view->titulo = "Inicio";
        $this->_view->setJs(array('inicio'));
        $this->_view->renderizar('index');
    }

}

?>