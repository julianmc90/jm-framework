<?php



//mostramos todos los errores
ini_set('display_errors', 1);
//set_time_limit(0); 

//DS: separador de directorios
define('DS', DIRECTORY_SEPARATOR);

//ROOT: Direccion real de la apliacion
define('ROOT', realpath(dirname(__FILE__)) . DS);

//APP_PATH: direccion del directorio aplicacion
define('APP_PATH', ROOT . 'application' . DS);

//definimos la zona horaria
date_default_timezone_set('America/Bogota');

// echo hash( 'sha256', '');

// exit();
 
try {

//requerimos los scripts necesarios
    require_once APP_PATH . 'Config.php';
    require_once APP_PATH . 'Request.php';
    require_once APP_PATH . 'Bootstrap.php';
    require_once APP_PATH . 'Database.php';
    require_once APP_PATH . 'Controller.php';
    require_once APP_PATH . 'Model.php';
    require_once APP_PATH . 'View.php';
    require_once APP_PATH . 'Session.php';
    require_once APP_PATH . 'CHtml.php';
    require_once APP_PATH . 'Acl.php';
    
    Session::init();
    
    Bootstrap::run(new Request());
    
} catch (Exception $exc) {
    echo $exc->getMessage();
}

