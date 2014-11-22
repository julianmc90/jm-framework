<?php

/**
 * Clase para administrar las listas de control de acceso
 * $_db Objeto de tipo Database
 * $_id id del usuario
 */
class ACL {

    public function __construct() {
        
    }

    /**
     * Esta funcion evalua si el usuario logueado tiene permiso en la llave indicada
     * @param String $key llave del permiso
     * @return boolean
     */
    public static function get_access($key) {
        
        $odb = new Database('mysql');
        $id_u = Session::get('id_usuario');
        
        $permiso = $odb->fetch_all("select permisos.key from permisos,permisos_roles where permisos.id = permisos_roles.id_permiso and permisos_roles.id_role=(select usuarios_roles.id_rol from usuarios_roles where usuarios_roles.id_usuario in (select id from usuarios where id = {$id_u} and estado= 1)) and permisos_roles.estado=1 and permisos.key='{$key}'");     
        
        if ($permiso == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * funcion que otorga o niega el acceso a determinada area de la aplicacion 
     * @param String $key llave del permiso
     * @param boolean $isAjaxRequest con este parametro le decimos si se va a evaluar por medio de ajax
     * @return boolean,String retorna booleano si no es ajax request y seria verdadero, redirecciona si es falso, y si es
     * ajax request retornara string: 1 si tiene el permiso y no_permiso si es falso 
     */
    public static function acceso($key, $isAjaxRequest = false) {

        $permiso = ACL::get_access($key);

        switch ($isAjaxRequest) {

            case true:
                if ($permiso == true) {
                    echo "1";
                } else {
                    echo "no_permiso";
                }
                break;

            case false:
                if ($permiso == true) {
                    return true;
                } else {
                    
                    header("location: " . BASE_URL . 'error/access/5050');
                }
                break;
        }
    }

}

?>
