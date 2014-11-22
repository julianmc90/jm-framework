<?php

class loginModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUsuario($usuario, $password) {

        $result = $this->fetch_assoc("select * from abogados where nombre_usuario='" . $usuario . "' and password = '" . hash('sha256', $password) . "' and estado=1 and id!=1");

        if (count($result) == 0) {
            return false;
        } else {
            return $result;
        }
    }

}

?>
