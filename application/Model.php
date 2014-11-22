<?php

/**
 * Clase que hereda de la Clase Database
 * 
 */
class Model extends Database {

    public function __construct() {

        /**
         * Funcion de construccion del objeto en el que se debe especificar
         *  el motor de datos por defecto que usara la aplicacion
         */
        parent::__construct('mysql');
    }



}

?>
