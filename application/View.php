<?php

class View {

    private $_controlador;
    private $_public_url;
    private $_js;
    private $_css;
    private $_js_library;
    private $_css_comp_library;

    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
        $this->_js = array();
        $this->_css = array();
        $this->_public_url = BASE_URL . 'public/';
    }

    public function renderizar($vista) {

        $js = array();
        if (count($this->_js)) {
            $js = $this->_js;
        }

        $css = array();
        if (count($this->_css)) {
            $css = $this->_css;
        }

        $main_css = $this->get_css_array_routes(Array(
            'bootstrap/css/bootstrap.min',
            'bootstrap/css/bootstrap-theme',
            'jquery/css/jquery-ui',
            'jquery/css/timepicker',
            'css/main'
        ));


        $main_js = $this->get_js_array_routes(Array(
            'jquery/jquery-1.9.1.min',
            'jquery/jquery-ui-1.10.0.min',
            'jquery/jquery-ui-timepicker-addon',
            'jquery/jquery.validate',
            'bootstrap/js/bootstrap.min',
            'jquery/my_addons',
            'js/main_active_menu'
        ));

        //$_lp es una variable utilizada para asignar rutas de scripts Javascript y Css
        $_lp = array(
            'main_css' => $main_css,
            'main_js' => $main_js,
            '_js_library' => $this->_js_library,
            '_css_comp_library' => $this->_css_comp_library,
            'js' => $js,
            'css' => $css
        );

        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.php';
        if (is_readable($rutaView)) {
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        } else {
            throw new Exception('Error de vista');
        }
    }

    public function get_js_library($library) {

        switch ($library) {

            case 'jtable':

                //$this->_public_url
                $this->_js_library = $this->get_js_array_routes(
                        Array('libs/jtable/jquery.jtable','libs/jtable/localization/jquery.jtable.es')
                );
                
                $this->_css_comp_library = $this->get_css_array_routes(
                        Array('libs/jtable/themes/metro/blue/jtable.min')
                        );
                        break;
        }
    }

    public function get_js_array_routes($rutas) {

        $size_rutas = count($rutas);

        for ($i = 0; $i < $size_rutas; $i++) {
            $arr[] = $this->_public_url . $rutas[$i] . '.js';
        }
        return $arr;
    }

    public function get_css_array_routes($rutas) {

        $size_rutas = count($rutas);

        for ($i = 0; $i < $size_rutas; $i++) {
            $arr[] = $this->_public_url . $rutas[$i] . '.css';
        }
        return $arr;
    }

    public function setJs(array $js) {

        if (is_array($js) && count($js)) {

            for ($i = 0; $i < count($js); $i++) {

                $this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
            }
        } else {

            throw new Exception('error de js');
        }
    }

    public function setCss(array $css) {

        if (is_array($css) && count($css)) {

            for ($i = 0; $i < count($css); $i++) {

                $this->_css[] = BASE_URL . 'views/' . $this->_controlador . '/css/' . $css[$i] . '.css';
            }
        } else {

            throw new Exception('error de css');
        }
    }

    public function js($ruta) {

        echo "<script type='text/javascript' src='" . $ruta . "' ></script>";
    }

    public function css($ruta) {

        echo "<link rel='stylesheet' type='text/css' href='" . $ruta . "' />";
    }

    /**
     * script que incluira los scripts enrutados desde el controlador
     * @param array $array
     */
    public function get_js($array) {


        if (!empty($array) && count($array)) {

            for ($i = 0; $i < count($array); $i++) {

                echo "<script src='" . $array[$i] . "' type='text/javascript'></script>";
            }
        }
    }

    public function favicon() {

        echo "<link rel='shortcut icon' href='" . BASE_URL . "'>";
    }

    /*
     * funcion que imprime css en el header html del layout reciviendo un array de rutas
     */

    public function imp_arr_css($arr) {
        for ($i = 0; $i < count($arr); $i++) {
            echo "<link rel='stylesheet' type='text/css' href='" . $arr[$i] . "' />";
        }
    }

    public function imp_arr_js($arr) {
        for ($i = 0; $i < count($arr); $i++) {
            echo "<script src='" . $arr[$i] . "' type='text/javascript'></script>";
        }
    }

}

?>
