<?php

abstract class Controller {

    protected $_view;

    public function __construct() {

        $this->_view = new View(new Request());
    }

    abstract public function index();

    protected function loadModel($modelo) {

        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';

        if (is_readable($rutaModelo)) {

            require_once $rutaModelo;

//          $modelo = new $modelo;
//          return $modelo;
        } else {

            throw new Exception('Error de modelo');
        }
    }

    protected function getLibrary($libreria) {

        $rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';

        if (is_readable($rutaLibreria)) {

            require_once $rutaLibreria;
        } else {

            throw new Exception('Error de libreria');
        }
    }

    /**
     * redirecciona a la pagina ingresada por parametro
     * @param strin $ruta
     */
    protected function redireccionar($ruta = false) {

        if ($ruta) {
            header('location:' . BASE_URL . $ruta);
            exit;
        } else {
            header('location:' . BASE_URL);
            exit;
        }
    }

    /**
     * Funcion que sanatiza un entero
     * @param int $int
     * @return int
     */
    protected function int($int) {
        return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * devuelve un dato escapado independiete del tipo de dato, y la manera de obtenerlo es por el metodo $_POST
     * @param string $clave
     * @return null,int,string,float
     */
    protected function post($clave) {

        if (!empty($_POST[$clave])) {

            if (is_int($_POST[$clave])) {

                return filter_var($_POST[$clave], FILTER_SANITIZE_NUMBER_INT);
            }

            if (is_float($_POST[$clave])) {

                return filter_var($_POST[$clave], FILTER_SANITIZE_NUMBER_FLOAT);
            }

            if (is_string($_POST[$clave])) {
                $_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES, 'UTF-8');
                return $_POST[$clave];
            }
        }
    }

    protected function stz_int($clave) {

        return filter_var($_REQUEST[$clave], FILTER_SANITIZE_NUMBER_INT);
    }

    protected function stz_float($clave) {

        return filter_var($_REQUEST[$clave], FILTER_SANITIZE_NUMBER_FLOAT);
    }

    protected function stz_str($clave) {

        $_REQUEST[$clave] = htmlspecialchars($_REQUEST[$clave], ENT_QUOTES, 'UTF-8');
        return $_REQUEST[$clave];
    }

    /**
     * devuelve un dato escapado independiete del tipo de dato, y la manera de obtenerlo es por el metodo $_GET
     * @param string $clave
     * @return null,int,string,float
     */
    protected function get($clave) {

        if (!empty($_GET[$clave])) {

            if (is_int($_GET[$clave])) {

                return filter_var($_GET[$clave], FILTER_SANITIZE_NUMBER_INT);
            }

            if (is_float($_GET[$clave])) {

                return filter_var($_GET[$clave], FILTER_SANITIZE_NUMBER_FLOAT);
            }

            if (is_string($_GET[$clave])) {
                $_GET[$clave] = htmlspecialchars($_GET[$clave], ENT_QUOTES, 'UTF-8');
                return $_GET[$clave];
            }
        }
    }

    /**
     * retorna la direccion de email validada y sin caracteres dañinos
     * @param String $email cadena con la direccion email de entrada
     * @return String email validado y sanatizado
     */
    protected function sanatizeEmail($email) {

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Obtiene un array de tipo clave valor de una cadena de valores serializados
     * ademas lo sanea
     * @param String $var
     * @return Array
     */
    protected function get_array_from_serialized($var) {

        $var = $_POST[$var];
        $array = array();
        parse_str($var, $array);
        return filter_var_array($array, FILTER_SANITIZE_STRING);
    }

    /**
     * Funcion que sanatiza un arreglo obtenido por POST
     * @param String $clave clave de la variable obtenida por post
     * @return Array
     */
    protected function sanatize_array($clave) {

        return filter_var_array($_POST[$clave], FILTER_SANITIZE_STRING);
    }

    /**
     * Funcion que retorna el Hash de una contraseña
     * @param String $password contraseña para hacer el hash
     * @return String Hash del String ingresado
     */
    public function hash_pass($password) {

        return hash('sha256', $password);
    }

    /**
     * devuelve un dato escapado listo para insertarlo en una consulta
     * @param type $clave
     * @return null,string,int,float
     */
    protected function quotePost($clave) {

        if (!empty($_POST[$clave])) {

            if (is_int($_POST[$clave]) || is_float($_POST[$clave])) {
                return $_POST[$clave];
            } else {
                return "'" . addcslashes(str_replace("'", "''", $_POST[$clave]), "\000\n\r\\\032") . "'";
            }
        } else {

            return null;
        }
    }

    protected function getAlphaNum($clave) {
        if (!empty($_POST[$clave]) && preg_match('/^[a-zA-Z0-9_]{3,16}$/', $_POST[$clave])) {
            return $_POST[$clave];
        } else {

            return '';
        }
    }

    protected function getRealIPAddress() {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

            //to check ip is pass from proxy

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {

            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return trim($ip);
    }

    public function get_twelve_hours_format($fecha) {

        return DATE("Y-m-d H:i:s", STRTOTIME($fecha));
    }

    /**
     * Funcion que verifica si la peticion es hecha por medio de ajax o no
     * @return boolean true en caso de ser una peticion ajax, de lo contrario dispara un error
     */
    public function is_ajax_request() {

        $isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

        if (!$isAjax) {
            $user_error = 'Access Denegado - not an AJAX request...';
            trigger_error($user_error, E_USER_ERROR);
        } else {
            return true;
        }
    }

}
?>








